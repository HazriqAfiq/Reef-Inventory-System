<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_verified_buyer_can_create_and_update_review(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();
        $this->createDeliveredOrder($user, $product);

        $create = $this->actingAs($user)->post(route('product.review', $product), [
            'rating' => 5,
            'body' => 'Excellent scent.',
        ]);

        $create->assertRedirect();
        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
        ]);

        $update = $this->actingAs($user)->post(route('product.review', $product), [
            'rating' => 3,
            'body' => 'Updated opinion.',
        ]);

        $update->assertRedirect();
        $this->assertDatabaseHas('product_reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 3,
            'body' => 'Updated opinion.',
        ]);
        $this->assertEquals(1, ProductReview::query()->where('user_id', $user->id)->where('product_id', $product->id)->count());
    }

    public function test_non_buyer_cannot_create_review(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)->post(route('product.review', $product), [
            'rating' => 4,
            'body' => 'Should fail.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('product_reviews', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_delete_own_review(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();
        $review = ProductReview::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => 5,
            'body' => 'Mine',
        ]);

        $response = $this->actingAs($user)->delete(route('product.review.destroy', [$product, $review]));

        $response->assertRedirect();
        $this->assertDatabaseMissing('product_reviews', ['id' => $review->id]);
    }

    private function createDeliveredOrder(User $user, Product $product): void
    {
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 100,
            'status' => Order::STATUS_DELIVERED,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'price' => 100,
        ]);
    }

    private function createProduct(): Product
    {
        return Product::create([
            'sku' => 'PRD-'.uniqid(),
            'name' => 'Review Product '.uniqid(),
            'slug' => 'review-product-'.uniqid(),
            'description' => 'Review test product',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 10,
            'is_active' => true,
        ]);
    }
}
