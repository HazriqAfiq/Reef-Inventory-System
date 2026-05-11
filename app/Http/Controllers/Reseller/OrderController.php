<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Product;
use App\Models\ResellerStock;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(15);
        return view('reseller.orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::active()->with('primaryImage')->get();
        $totalMoq = (int) \App\Models\Setting::getValue('reseller_total_moq', 15);
        $productMoq = (int) \App\Models\Setting::getValue('reseller_product_moq', 5);
        
        // Fetch persisted JSON cart mapping
        $cart = auth()->user()->cart;
        $cartItems = $cart && is_array($cart->content) ? $cart->content : [];

        // Fetch saved delivery addresses
        $addresses = auth()->user()->addresses()->latest()->get();
        $defaultAddress = $addresses->firstWhere('is_default', true) ?? $addresses->first();

        return view('reseller.orders.create', compact('products', 'totalMoq', 'productMoq', 'cartItems', 'addresses', 'defaultAddress'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'     => 'required|array',
            'quantity'       => 'required|array',
            // Address: either a saved address_id OR inline fields
            'address_id'     => 'nullable|exists:addresses,id',
            'recipient_name' => 'required_without:address_id|string|max:255',
            'phone'          => 'required_without:address_id|string|max:20',
            'address_line_1' => 'required_without:address_id|string|max:255',
            'city'           => 'required_without:address_id|string|max:100',
            'state'          => 'required_without:address_id|string|max:100',
            'postal_code'    => 'required_without:address_id|string|max:20',
        ]);

        $totalMoq = (int) \App\Models\Setting::getValue('reseller_total_moq', 15);
        $productMoq = (int) \App\Models\Setting::getValue('reseller_product_moq', 5);

        $productIds = $request->input('product_id');
        $quantities = $request->input('quantity');

        $totalPrice = 0;
        $orderItems = [];
        $totalQuantity = 0;

        foreach ($productIds as $i => $pId) {
            $qty = (int) ($quantities[$i] ?? 0);
            if ($qty > 0) {
                $product = \App\Models\Product::findOrFail($pId);

                // Low-Stock Cleardown Rule: if stock is below the per-product MOQ set by admin, reseller must purchase exactly 100% of the available stock.
                if ($product->stock < $productMoq) {
                    if ($qty !== $product->stock) {
                        return back()->withErrors(['quantity' => "For low-stock product '{$product->name}' (stock below minimum MOQ of {$productMoq}), you must purchase all remaining {$product->stock} units to clear stock."]);
                    }
                } else {
                    // Standard MOQ Check
                    if ($qty < $productMoq) {
                        return back()->withErrors(['quantity' => "Quantity selected for '{$product->name}' must be at least {$productMoq} units."]);
                    }
                    if ($product->stock < $qty) {
                        return back()->withErrors(['quantity' => "Not enough stock for {$product->name}."]);
                    }
                }
                
                $price = $product->wholesale_price * $qty;
                $totalPrice += $price;
                $totalQuantity += $qty;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->wholesale_price,
                ];
            }
        }

        if (empty($orderItems)) {
            return back()->withErrors(['quantity' => 'Please select at least one item.']);
        }

        if ($totalQuantity < $totalMoq) {
            return back()->withErrors(['quantity' => "Minimum Order Quantity (MOQ) for Resellers is {$totalMoq} items total."]);
        }

        $order = auth()->user()->orders()->create([
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'billplz_id'  => 'MOCK_' . uniqid(),
        ]);

        $order->items()->createMany($orderItems);

        // Snapshot the delivery address into order_addresses
        if ($request->filled('address_id')) {
            $addr = Address::where('id', $request->address_id)
                           ->where('user_id', auth()->id())
                           ->firstOrFail();
            OrderAddress::create([
                'order_id'   => $order->id,
                'first_name' => $addr->recipient_name,
                'last_name'  => '',
                'email'      => auth()->user()->email,
                'phone'      => $addr->phone,
                'address'    => $addr->address_line_1 . ($addr->address_line_2 ? ', ' . $addr->address_line_2 : ''),
                'city'       => $addr->city,
                'state'      => $addr->state,
                'postcode'   => $addr->postal_code,
            ]);
        } else {
            // Inline address entry
            OrderAddress::create([
                'order_id'   => $order->id,
                'first_name' => $request->recipient_name,
                'last_name'  => '',
                'email'      => auth()->user()->email,
                'phone'      => $request->phone,
                'address'    => $request->address_line_1 . ($request->address_line_2 ? ', ' . $request->address_line_2 : ''),
                'city'       => $request->city,
                'state'      => $request->state,
                'postcode'   => $request->postal_code,
            ]);
        }

        // Notify admins of the new wholesale order
        NotificationService::newOrder($order, auth()->user());

        // Clear persistent database cart on successful order creation
        $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->content = [];
            $cart->save();
        }

        return redirect()->route('reseller.orders.payment', $order);
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status === 'paid') {
            return redirect()->route('reseller.orders.show', $order);
        }
        return view('reseller.orders.payment', compact('order'));
    }

    public function callback(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status === 'paid') {
            return redirect()->route('reseller.orders.show', $order);
        }

        $order->update(['status' => 'paid']);

        foreach ($order->items as $item) {
            $item->product->decrement('stock', $item->quantity);

            // Update Reseller Stock
            $stock = ResellerStock::firstOrCreate([
                'user_id' => $order->user_id,
                'product_id' => $item->product_id,
            ]);
            $stock->increment('quantity', $item->quantity);
        }

        // Notify the reseller that their order was approved
        NotificationService::orderApproved($order);

        return redirect()->route('reseller.orders.show', $order)->with('success', 'Payment successful. Order confirmed.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('reseller.orders.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product', 'user');
        
        $pdf = Pdf::loadView('reseller.orders.invoice', compact('order'));
        return $pdf->download("invoice_ORD_{$order->id}.pdf");
    }

    /**
     * Display a beautiful detailed view of a product for resellers.
     */
    public function showProduct(Product $product)
    {
        $product->load(['images', 'primaryImage']);
        
        // B2B Wholesale Profit margins calculations
        $profit = $product->retail_price - $product->wholesale_price;
        $margin = $product->retail_price > 0 ? round(($profit / $product->retail_price) * 100, 1) : 0;
        
        // Fetch persisted JSON cart mapping and active products
        $allProducts = Product::active()->with('primaryImage')->get();
        $cart = auth()->user()->cart;
        $cartItems = $cart && is_array($cart->content) ? $cart->content : [];
        $totalMoq = (int) \App\Models\Setting::getValue('reseller_total_moq', 15);
        $productMoq = (int) \App\Models\Setting::getValue('reseller_product_moq', 5);

        return view('reseller.products.show', compact('product', 'profit', 'margin', 'allProducts', 'cartItems', 'totalMoq', 'productMoq'));
    }

    /**
     * Update dynamic persistent database cart selections via AJAX.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $cart = \App\Models\Cart::firstOrCreate([
            'user_id' => auth()->id(),
        ], [
            'content' => [],
        ]);

        $content = is_array($cart->content) ? $cart->content : [];

        if ($quantity > 0) {
            $content[$productId] = $quantity;
        } else {
            unset($content[$productId]);
        }

        $cart->content = $content;
        $cart->save();

        return response()->json([
            'success' => true,
            'cart' => $content,
        ]);
    }

    /**
     * Clear dynamic persistent database cart selections via AJAX.
     */
    public function clearCart()
    {
        $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->content = [];
            $cart->save();
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
