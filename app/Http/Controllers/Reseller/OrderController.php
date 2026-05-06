<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $products = Product::active()->get();
        return view('reseller.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
        ]);

        $productIds = $request->input('product_id');
        $quantities = $request->input('quantity');

        $totalPrice = 0;
        $orderItems = [];
        $totalQuantity = 0;

        foreach ($productIds as $i => $pId) {
            $qty = (int) ($quantities[$i] ?? 0);
            if ($qty > 0) {
                $product = \App\Models\Product::findOrFail($pId);
                if ($product->stock < $qty) {
                    return back()->withErrors(['quantity' => "Not enough stock for {$product->name}."]);
                }
                
                $price = $product->wholesale_price * $qty;
                $totalPrice += $price;
                $totalQuantity += $qty;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->wholesale_price,
                ];
            }
        }

        if (empty($orderItems)) {
            return back()->withErrors(['quantity' => 'Please select at least one item.']);
        }

        if ($totalQuantity < 15) {
            return back()->withErrors(['quantity' => 'Minimum Order Quantity (MOQ) for Resellers is 15 items total.']);
        }

        $order = auth()->user()->orders()->create([
            'total_price' => $totalPrice,
            'status' => 'pending',
            'billplz_id' => 'MOCK_' . uniqid(),
        ]);

        $order->items()->createMany($orderItems);

        // Notify admins of the new wholesale order
        NotificationService::newOrder($order, auth()->user());

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
}
