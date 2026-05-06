<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Auth::user()
            ->wishlists()
            ->with(['product.primaryImage'])
            ->latest()
            ->paginate(12);

        return view('account.wishlist', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $wishlistItem = $user->wishlists()->where('product_id', $product->id)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $status = 'removed';
            $message = 'Product removed from wishlist.';
        } else {
            $user->wishlists()->create(['product_id' => $product->id]);
            $status = 'added';
            $message = 'Product added to wishlist.';
        }

        ActivityLog::log(
            $status === 'added' ? 'wishlist_added' : 'wishlist_removed',
            $product,
            $message,
            ['product_id' => $product->id, 'status' => $status]
        );

        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
                'count' => $user->wishlists()->count(),
            ]);
        }

        return back()->with('success', $message);
    }
}
