<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_wishlist_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('account.wishlist'));

        $response->assertOk();
    }

    public function test_toggle_wishlist_adds_product_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)->post(route('wishlist.toggle', $product));

        $response->assertRedirect();
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_toggle_wishlist_removes_existing_product(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->post(route('wishlist.toggle', $product));

        $response->assertRedirect();
        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_toggle_wishlist_returns_json_for_ajax_requests(): void
    {
        $user = User::factory()->create();
        $product = $this->createProduct();

        $response = $this->actingAs($user)->postJson(route('wishlist.toggle', $product));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'status' => 'added',
                'count' => 1,
            ]);
    }

    private function createProduct(): Product
    {
        return Product::create([
            'sku' => 'SKU-'.uniqid(),
            'name' => 'Wishlist Product '.uniqid(),
            'slug' => 'wishlist-product-'.uniqid(),
            'description' => 'Test description',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 10,
            'is_active' => true,
        ]);
    }
}
