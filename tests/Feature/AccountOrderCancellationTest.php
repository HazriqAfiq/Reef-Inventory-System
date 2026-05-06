<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountOrderCancellationTest extends TestCase
{
    use RefreshDatabase;

    public function test_cancelling_paid_order_restores_variant_stock(): void
    {
        $user = User::factory()->create();
        $variant = $this->createVariant(stock: 5);

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => 200,
            'status' => Order::STATUS_PAID,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $variant->product_id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
            'price' => 100,
        ]);

        $response = $this->actingAs($user)->post(route('account.orders.cancel', $order));

        $response->assertRedirect();
        $this->assertEquals(Order::STATUS_CANCELLED, $order->fresh()->status);
        $this->assertEquals(7, $variant->fresh()->stock);
    }

    private function createVariant(int $stock = 10): ProductVariant
    {
        $product = Product::create([
            'sku' => 'ACC-PRD-'.uniqid(),
            'name' => 'Account Product '.uniqid(),
            'slug' => 'account-product-'.uniqid(),
            'description' => 'Account test product',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => $stock,
            'is_active' => true,
        ]);

        return ProductVariant::create([
            'product_id' => $product->id,
            'name' => '100ml',
            'sku' => 'ACC-VAR-'.uniqid(),
            'retail_price' => 100,
            'wholesale_price' => 50,
            'stock' => $stock,
            'volume_ml' => 100,
        ]);
    }
}
