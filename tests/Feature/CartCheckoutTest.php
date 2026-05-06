<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_for_checkout_routes(): void
    {
        $this->get(route('checkout.index'))->assertRedirect(route('login'));
        $this->post(route('checkout.store'), $this->validCheckoutPayload())->assertRedirect(route('login'));
        $this->get(route('checkout.success'))->assertRedirect(route('login'));
    }

    public function test_cart_add_supports_quick_add_without_variant_id(): void
    {
        $variant = $this->createVariant();

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $variant->product_id,
            'quantity' => 1,
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);
        $this->assertEquals(1, session('cart')[$variant->id] ?? 0);
    }

    public function test_cart_add_rejects_quantity_over_stock_for_existing_item(): void
    {
        $variant = $this->createVariant(stock: 2);
        session()->put('cart', [$variant->id => 2]);

        $response = $this->postJson(route('cart.add'), [
            'product_id' => $variant->product_id,
            'variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);
        $this->assertEquals(2, session('cart')[$variant->id] ?? 0);
    }

    public function test_move_to_wishlist_removes_correct_variant_from_cart(): void
    {
        $user = User::factory()->create();
        $variantA = $this->createVariant();
        $variantB = $this->createVariant(product: $variantA->product, suffix: 'b');

        session()->put('cart', [
            $variantA->id => 1,
            $variantB->id => 1,
        ]);

        $response = $this->actingAs($user)
            ->post(route('cart.wishlist', $variantA->id));

        $response->assertRedirect();
        $this->assertArrayNotHasKey($variantA->id, session('cart'));
        $this->assertArrayHasKey($variantB->id, session('cart'));
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $variantA->product_id,
        ]);
    }

    public function test_checkout_redirects_to_cart_when_variant_is_missing(): void
    {
        $user = User::factory()->create();
        $variant = $this->createVariant();
        session()->put('cart', [$variant->id => 1]);
        $variant->delete();

        $response = $this->actingAs($user)->post(route('checkout.store'), $this->validCheckoutPayload());

        $response->assertRedirect(route('cart.index'));
        $response->assertSessionHas('error');
    }

    public function test_checkout_applies_discount_percent_promotion_to_order_total(): void
    {
        $user = User::factory()->create();
        $variant = $this->createVariant();
        $variant->product->update([
            'promotion_type' => 'discount_percent',
            'promotion_value' => 10,
        ]);
        session()->put('cart', [$variant->id => 2]); // 200 base, 180 after 10%

        $response = $this->actingAs($user)->post(route('checkout.store'), $this->validCheckoutPayload());

        $response->assertRedirect(route('checkout.success'));
        $order = Order::latest('id')->first();
        $this->assertNotNull($order);
        $this->assertEquals(180.0, (float) $order->total_price);
    }

    public function test_checkout_applies_bogo_promotion_to_order_total(): void
    {
        $user = User::factory()->create();
        $variant = $this->createVariant();
        $variant->product->update([
            'promotion_type' => 'bogo',
            'promotion_badge' => 'BUY 1 GET 1',
        ]);
        session()->put('cart', [$variant->id => 3]); // pay for 2

        $response = $this->actingAs($user)->post(route('checkout.store'), $this->validCheckoutPayload());

        $response->assertRedirect(route('checkout.success'));
        $order = Order::latest('id')->first();
        $this->assertNotNull($order);
        $this->assertEquals(200.0, (float) $order->total_price);
    }

    private function validCheckoutPayload(): array
    {
        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'city' => 'Kuala Lumpur',
            'postcode' => '50000',
            'state' => 'WP Kuala Lumpur',
        ];
    }

    private function createVariant(?Product $product = null, int $stock = 10, string $suffix = 'a'): ProductVariant
    {
        $product ??= Product::create([
            'sku' => 'CRT-PRD-'.uniqid(),
            'name' => 'Cart Product '.uniqid(),
            'slug' => 'cart-product-'.uniqid(),
            'description' => 'Cart test product',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => $stock,
            'is_active' => true,
        ]);

        return ProductVariant::create([
            'product_id' => $product->id,
            'name' => strtoupper($suffix).' 100ml',
            'sku' => 'CRT-VAR-'.uniqid().'-'.$suffix,
            'retail_price' => 100,
            'wholesale_price' => 50,
            'stock' => $stock,
            'volume_ml' => 100,
        ]);
    }
}
