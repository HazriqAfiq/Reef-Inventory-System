<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'nullable|string|max:1000',
        ]);

        // Only verified buyers can create/update a review.
        $hasBought = Auth::user()->orders()
            ->where('status', 'delivered')
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        if (!$hasBought) {
            return back()->with('error', 'Only verified buyers can leave a review.');
        }

        $existing = ProductReview::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existing) {
            $existing->update([
                'rating' => $request->rating,
                'body' => $request->body,
            ]);

            ActivityLog::log(
                'product_review_updated',
                $existing,
                'Product review updated.',
                ['product_id' => $product->id, 'rating' => $request->rating]
            );

            return back()->with('success', 'Your review has been updated.');
        }

        $review = $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'body' => $request->body,
        ]);

        ActivityLog::log(
            'product_review_created',
            $review,
            'Product review created.',
            ['product_id' => $product->id, 'rating' => $request->rating]
        );

        return back()->with('success', 'Thank you for your review!');
    }

    public function destroy(Product $product, ProductReview $review)
    {
        if ($review->product_id !== $product->id) {
            abort(404);
        }

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        ActivityLog::log(
            'product_review_deleted',
            $product,
            'Product review deleted.',
            ['product_id' => $product->id, 'review_id' => $review->id]
        );

        return back()->with('success', 'Your review has been removed.');
    }
}
