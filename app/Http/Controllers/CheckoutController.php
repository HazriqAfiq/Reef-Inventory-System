<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $selectedIds = session()->get('selected_cart_items', []);
        
        // Filter cart to only include selected items
        if (!empty($selectedIds)) {
            $cart = array_intersect_key($cart, array_flip($selectedIds));
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one item to checkout.');
        }

        $variantIds = array_keys($cart);
        $variants = \App\Models\ProductVariant::with('product')->whereIn('id', $variantIds)->get();
        $foundVariantIds = $variants->pluck('id')->map(fn ($id) => (string) $id)->all();
        $unknownVariantIds = array_diff(array_map('strval', $variantIds), $foundVariantIds);

        if (! empty($unknownVariantIds)) {
            foreach ($unknownVariantIds as $unknownId) {
                unset($cart[$unknownId]);
            }
            session()->put('cart', $cart);
            $this->syncCartToDatabase($cart);
            $variantIds = array_keys($cart);
            $variants = \App\Models\ProductVariant::with('product')->whereIn('id', $variantIds)->get();

            if (empty($cart)) {
                return redirect()->route('storefront.index')->with('error', 'Your cart items are no longer available.');
            }
        }
        
        $checkoutItems = $this->buildCheckoutItems($variants, $cart);
        $originalTotal = collect($checkoutItems)->sum('original_subtotal');
        $total = collect($checkoutItems)->sum('subtotal');
        $totalDiscount = $originalTotal - $total;

        $userPoints = Auth::check() ? Auth::user()->loyalty_points : 0;

        return view('storefront.checkout', compact('checkoutItems', 'cart', 'total', 'userPoints', 'originalTotal', 'totalDiscount'));
    }

    /**
     * Process order placement (Mock Success)
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $selectedIds = session()->get('selected_cart_items', []);

        // Filter cart to only include selected items
        if (!empty($selectedIds)) {
            $cart = array_intersect_key($cart, array_flip($selectedIds));
        }

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one item to checkout.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'city'       => 'required|string',
            'postcode'   => 'required|string',
            'state'      => 'required|string',
            'use_points' => 'nullable|boolean',
        ]);

        try {
            return DB::transaction(function () use ($cart, $request) {
                $variantIds = array_keys($cart);
                $variants = \App\Models\ProductVariant::with('product')->whereIn('id', $variantIds)->lockForUpdate()->get();
                $foundVariantIds = $variants->pluck('id')->map(fn ($id) => (string) $id)->all();
                $unknownVariantIds = array_diff(array_map('strval', $variantIds), $foundVariantIds);

                if (! empty($unknownVariantIds)) {
                    throw new \RuntimeException('One or more cart items are no longer available. Please review your cart.');
                }

                $checkoutItems = $this->buildCheckoutItems($variants, $cart);
                $totalPrice = collect($checkoutItems)->sum('subtotal');
                $itemsData = [];
                $salesData = [];

                foreach ($checkoutItems as $item) {
                    /** @var ProductVariant $variant */
                    $variant = $item['variant'];
                    $qty = $item['quantity'];

                    if ($variant->stock < $qty) {
                        throw new \RuntimeException("Stock for {$variant->product->name} ({$variant->name}) has changed. Please review your cart.");
                    }

                    $itemsData[] = [
                        'product_id' => $variant->product_id,
                        'product_variant_id' => $variant->id,
                        'quantity'   => $qty,
                        'price'      => $item['unit_price'],
                    ];

                    $salesData[] = [
                        'user_id'     => Auth::id(),
                        'product_id'  => $variant->product_id,
                        'product_variant_id' => $variant->id,
                        'quantity'    => $qty,
                        'total_price' => $item['subtotal'],
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ];

                    $variant->decrement('stock', $qty);
                }

                // Loyalty Points Redemption
                $pointsRedeemed = 0;
                $discountAmount = 0;
                if ($request->use_points && Auth::check() && Auth::user()->loyalty_points > 0) {
                    $maxDiscount = $totalPrice * 0.5; // Max 50% discount from points
                    $availableDiscount = Auth::user()->loyalty_points / 100; // 100 pts = RM1
                    
                    $discountAmount = min($maxDiscount, $availableDiscount);
                    $pointsRedeemed = $discountAmount * 100;
                    
                    $totalPrice -= $discountAmount;
                }

                // Points Earned (1 point per RM1)
                $pointsEarned = floor($totalPrice);

                // 1. Create Order
                $order = Order::create([
                    'user_id'         => Auth::id(),
                    'total_price'     => $totalPrice,
                    'points_earned'   => $pointsEarned,
                    'points_redeemed' => $pointsRedeemed,
                    'discount_amount' => $discountAmount,
                    'status'          => 'paid',
                    'billplz_id'      => 'MOCK_STORE_' . uniqid(),
                ]);

                // 2. Update User Points
                if (Auth::check()) {
                    $user = Auth::user();
                    $user->loyalty_points = ($user->loyalty_points - $pointsRedeemed) + $pointsEarned;
                    $user->save();
                }

                // 3. Shipping Address
                OrderAddress::create([
                    'order_id'   => $order->id,
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                    'email'      => $request->email,
                    'phone'      => $request->phone,
                    'address'    => $request->address,
                    'city'       => $request->city,
                    'state'      => $request->state,
                    'postcode'   => $request->postcode,
                ]);

                $order->items()->createMany($itemsData);
                Sale::insert($salesData);
                session()->forget('cart');
                $this->syncCartToDatabase([]);

                \App\Models\ActivityLog::log(
                    'storefront_order_placed',
                    $order,
                    "New order RM" . number_format($order->total_price, 2) . " placed. Points earned: {$pointsEarned}",
                    ['order_id' => $order->id, 'points_earned' => $pointsEarned]
                );

                // 6. Notify Admin (if legacy helper exists)
                if (method_exists(NotificationService::class, 'notifyAdmins')) {
                    NotificationService::notifyAdmins(
                        "New Storefront Order",
                        "Order #{$order->id} for RM" . number_format($order->total_price, 2) . " has been placed. Points earned: {$pointsEarned}",
                        route('admin.orders.show', $order->id)
                    );
                }

                return redirect()->route('checkout.success')->with('order_id', $order->id);
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('storefront.success');
    }

    protected function syncCartToDatabase(array $cart): void
    {
        if (Auth::check()) {
            \App\Models\Cart::updateOrCreate(
                ['user_id' => Auth::id()],
                ['content' => $cart]
            );
        }
    }

    protected function buildCheckoutItems($variants, array $cart): array
    {
        $items = [];

        foreach ($variants as $variant) {
            $quantity = (int) ($cart[$variant->id] ?? 0);
            if ($quantity <= 0) {
                continue;
            }

            $basePrice = (float) $variant->retail_price;
            $unitPrice = $basePrice;
            $payableQuantity = $quantity;

            if ($variant->product->isPromotionActive()) {
                if ($variant->product->promotion_type === 'discount_percent') {
                    $unitPrice = max(0, $basePrice - ($basePrice * ((float) $variant->product->promotion_value / 100)));
                } elseif ($variant->product->promotion_type === 'bogo') {
                    $payableQuantity = max(0, $quantity - floor($quantity / 2));
                }
            }

            $originalSubtotal = round($basePrice * $quantity, 2);
            $subtotal = round($unitPrice * $payableQuantity, 2);

            $items[] = [
                'variant' => $variant,
                'quantity' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'original_subtotal' => $originalSubtotal,
                'subtotal' => $subtotal,
            ];
        }

        return $items;
    }
}
