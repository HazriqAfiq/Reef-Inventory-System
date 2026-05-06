<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_end_to_end_order_flow_with_promotion_and_cancellation(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'role' => User::ROLE_BUYER,
        ]);

        $product = Product::create([
            'sku' => 'FLOW-PRD-'.uniqid(),
            'name' => 'Flow Product '.uniqid(),
            'slug' => 'flow-product-'.uniqid(),
            'description' => 'Flow regression product',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 999,
            'is_active' => true,
            'promotion_type' => 'discount_percent',
            'promotion_value' => 20,
        ]);

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'name' => '100ml',
            'sku' => 'FLOW-VAR-'.uniqid(),
            'retail_price' => 100,
            'wholesale_price' => 50,
            'stock' => 10,
            'volume_ml' => 100,
        ]);

        $addToCart = $this->actingAs($user)->postJson(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
        $addToCart->assertOk()->assertJson(['success' => true]);

        $checkout = $this->actingAs($user)->post(route('checkout.store'), [
            'first_name' => 'Jane',
            'last_name' => 'Buyer',
            'email' => 'jane@example.com',
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'city' => 'Kuala Lumpur',
            'postcode' => '50000',
            'state' => 'WP Kuala Lumpur',
        ]);

        $checkout->assertRedirect(route('checkout.success'));
        $order = Order::latest('id')->first();
        $this->assertNotNull($order);
        $this->assertEquals(Order::STATUS_PAID, $order->status);
        $this->assertEquals(160.0, (float) $order->total_price); // 2 x 100 with 20% discount
        $this->assertEquals(8, $variant->fresh()->stock);

        $cancel = $this->actingAs($user)->post(route('account.orders.cancel', $order));
        $cancel->assertRedirect();
        $this->assertEquals(Order::STATUS_CANCELLED, $order->fresh()->status);
        $this->assertEquals(10, $variant->fresh()->stock);
    }
}
