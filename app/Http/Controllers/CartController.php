<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        // If authenticated and session cart is empty, try loading from DB
        if (auth()->check() && empty($cart)) {
            $dbCart = \App\Models\Cart::where('user_id', auth()->id())->first();
            if ($dbCart) {
                $cart = $dbCart->content;
                session()->put('cart', $cart);
            }
        }

        $variantIds = array_keys($cart);
        $variants = \App\Models\ProductVariant::with(['product', 'product.images'])->whereIn('id', $variantIds)->get();

        $cartData = [];
        $total = 0;
        $originalTotal = 0;
        $totalDiscount = 0;

        foreach ($variants as $variant) {
            $quantity = $cart[$variant->id];
            $basePrice = $variant->retail_price;
            
            $payableQuantity = $quantity;
            $itemDiscountedPrice = $basePrice;
            $freeItems = 0;
            
            $user = auth()->user(); // Will be null for guests

            if ($variant->product->isPromotionActive($quantity, $user)) {
                if ($variant->product->promotion_type === 'discount_percent') {
                    $itemDiscountedPrice = max(0, $basePrice - ($basePrice * ($variant->product->promotion_value / 100)));
                } elseif ($variant->product->promotion_type === 'bogo') {
                    $freeItems = floor($quantity / 2);
                    $payableQuantity = $quantity - $freeItems;
                }
            }

            $originalSubtotal = $basePrice * $quantity;
            
            if ($variant->product->isPromotionActive($quantity, $user) && $variant->product->promotion_type === 'bogo') {
                $subtotal = $basePrice * $payableQuantity;
            } else {
                $subtotal = $itemDiscountedPrice * $quantity;
            }

            $itemDiscount = $originalSubtotal - $subtotal;

            $total += $subtotal;
            $originalTotal += $originalSubtotal;
            $totalDiscount += $itemDiscount;

            $cartData[] = [
                'variant' => $variant,
                'product' => $variant->product,
                'quantity' => $quantity,
                'original_subtotal' => $originalSubtotal,
                'subtotal' => $subtotal,
                'discount' => $itemDiscount,
                'free_items' => $freeItems,
            ];
        }

        $variantIds = array_keys($cart);
        $selectedItems = session()->get('selected_cart_items', $variantIds);

        return view('storefront.cart', compact('cartData', 'total', 'originalTotal', 'totalDiscount', 'variantIds', 'selectedItems'));
    }

    /**
     * Update selected items for checkout
     */
    public function updateSelection(Request $request)
    {
        $selectedIds = $request->input('selected_ids', []);
        session()->put('selected_cart_items', $selectedIds);
        return response()->json(['success' => true]);
    }

    /**
     * Add product to cart via AJAX/Form
     */
    public function add(Request $request)
    {
        $productId = (int) $request->input('product_id');
        $variantId = $request->input('variant_id');
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            $quantity = 1;
        }

        if ($variantId) {
            $variant = ProductVariant::with('product')->findOrFail($variantId);
        } elseif ($productId > 0) {
            $variant = ProductVariant::with('product')
                ->where('product_id', $productId)
                ->orderBy('id')
                ->first();

            if (! $variant) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'No variant available for this product.'], 422)
                    : back()->with('error', 'No variant available for this product.');
            }
        } else {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Invalid product or variant selection.'], 422)
                : back()->with('error', 'Invalid product or variant selection.');
        }

        $variantId = $variant->id;
        $cart = session()->get('cart', []);
        $newQuantity = ($cart[$variantId] ?? 0) + $quantity;

        if ($variant->stock < $newQuantity) {
            $message = "Only {$variant->stock} item(s) available for {$variant->product->name} ({$variant->name}).";
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $message], 422)
                : back()->with('error', $message);
        }

        // Key by variant_id
        $cart[$variantId] = $newQuantity;

        session()->put('cart', $cart);
        $this->syncToDatabase($cart);

        ActivityLog::log(
            'cart_item_added',
            $variant,
            'Item added to cart.',
            ['variant_id' => $variantId, 'quantity' => $quantity, 'cart_quantity' => $newQuantity]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => array_sum($cart),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update cart quantity
     */
    public function update(Request $request)
    {
        $variantId = $request->input('variant_id');
        $quantity = (int) $request->input('quantity');

        if ($quantity <= 0) {
            return $this->remove($variantId);
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$variantId])) {
            $variant = ProductVariant::with('product')->find($variantId);
            if (! $variant) {
                unset($cart[$variantId]);
                session()->put('cart', $cart);
                $this->syncToDatabase($cart);
                return back()->with('error', 'This product variant is no longer available and has been removed from cart.');
            }

            if ($quantity > $variant->stock) {
                return back()->with('error', "Only {$variant->stock} item(s) available for {$variant->product->name} ({$variant->name}).");
            }

            $cart[$variantId] = $quantity;
            session()->put('cart', $cart);
            $this->syncToDatabase($cart);

            ActivityLog::log(
                'cart_item_updated',
                $variant,
                'Cart item quantity updated.',
                ['variant_id' => $variantId, 'quantity' => $quantity]
            );
        }

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove item from cart
     */
    public function remove($variantId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$variantId])) {
            $removedQuantity = $cart[$variantId];
            unset($cart[$variantId]);
            session()->put('cart', $cart);
            $this->syncToDatabase($cart);

            ActivityLog::log(
                'cart_item_removed',
                ProductVariant::find($variantId),
                'Item removed from cart.',
                ['variant_id' => $variantId, 'quantity' => $removedQuantity]
            );
        }

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Move item to wishlist
     */
    public function moveToWishlist(Request $request, $variantId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please login to save items to your wishlist.');
        }

        $user = auth()->user();
        $variant = ProductVariant::with('product')->find($variantId);
        if (! $variant) {
            return back()->with('error', 'Selected cart item is no longer available.');
        }

        // Add to wishlist if not already there
        if (!$user->wishlists()->where('product_id', $variant->product_id)->exists()) {
            $user->wishlists()->create(['product_id' => $variant->product_id]);
        }

        // Remove from cart
        return $this->remove($variantId)->with('success', 'Item moved to wishlist.');
    }

    /**
     * Sync cart to database for authenticated users
     */
    protected function syncToDatabase($cart)
    {
        if (auth()->check()) {
            \App\Models\Cart::updateOrCreate(
                ['user_id' => auth()->id()],
                ['content' => $cart]
            );
        }
    }
}
