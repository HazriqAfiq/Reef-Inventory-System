<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResellerOrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default total and product MOQs
        Setting::updateOrCreate(['key' => 'reseller_total_moq'], ['value' => '15']);
        Setting::updateOrCreate(['key' => 'reseller_product_moq'], ['value' => '5']);
    }

    public function test_reseller_can_render_restock_page(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);

        $response = $this
            ->actingAs($reseller)
            ->get(route('reseller.orders.create'));

        $response->assertOk();
    }

    public function test_order_fails_if_under_total_wholesale_moq(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        
        $product = Product::create([
            'sku' => 'SKU-001',
            'name' => 'High Stock Cologne',
            'slug' => 'high-stock-cologne',
            'description' => 'A wonderful high stock scent',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 100,
            'is_active' => true,
        ]);

        // Attempting to buy 5 units (satisfies per-product MOQ, but total order 5 is under total MOQ of 15)
        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$product->id],
                'quantity' => [5],
            ]);

        $response->assertSessionHasErrors(['quantity']);
        $this->assertEquals(0, $reseller->orders()->count());
    }

    public function test_standard_product_moq_is_enforced_when_stock_is_abundant(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        
        $product = Product::create([
            'sku' => 'SKU-001',
            'name' => 'High Stock Cologne',
            'slug' => 'high-stock-cologne',
            'description' => 'A wonderful high stock scent',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 100,
            'is_active' => true,
        ]);

        // Attempting to buy 3 units of an abundant stock product (fails standard product MOQ of 5)
        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$product->id],
                'quantity' => [3],
            ]);

        $response->assertSessionHasErrors(['quantity']);
    }

    public function test_low_stock_buy_all_rule_requires_all_remaining_stock(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        
        // Product 1: Low stock (4 remaining, which is < 10)
        $lowStockProduct = Product::create([
            'sku' => 'SKU-LOW-1',
            'name' => 'Rare Amber Elixir',
            'slug' => 'rare-amber-elixir',
            'description' => 'Extremely rare formulation',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 4,
            'is_active' => true,
        ]);

        // Product 2: Abundant stock to help reach overall order MOQ of 15
        $abundantProduct = Product::create([
            'sku' => 'SKU-ABUND-1',
            'name' => 'Ocean Breeze',
            'slug' => 'ocean-breeze',
            'description' => 'Continuous high quantity availability',
            'wholesale_price' => 40,
            'retail_price' => 80,
            'stock' => 50,
            'is_active' => true,
        ]);

        // Scenario A: Attempting to buy 2 units of the low-stock item (fails because they must buy ALL 4)
        $responseA = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$lowStockProduct->id, $abundantProduct->id],
                'quantity' => [2, 12], // 2 + 12 = 14 total (and invalid individual count)
            ]);

        $responseA->assertSessionHasErrors(['quantity']);
        $this->assertEquals(0, $reseller->orders()->count());

        // Scenario B: Buying ALL 4 of the low-stock item + 12 of the abundant item (succeeds!)
        $responseB = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$lowStockProduct->id, $abundantProduct->id],
                'quantity' => [4, 12], // 4 + 12 = 16 total (meets 15 MOQ, and clears low stock exactly)
            ]);

        $responseB->assertSessionHasNoErrors();
        $responseB->assertRedirect();
        
        $this->assertEquals(1, $reseller->orders()->count());
        $order = $reseller->orders()->first();
        $this->assertEquals(2, $order->items()->count());
    }

    public function test_low_stock_threshold_shifts_dynamically_with_admin_setting(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);

        // Shift per-product MOQ setting to 4
        Setting::updateOrCreate(['key' => 'reseller_product_moq'], ['value' => '4']);

        // Create a product with stock = 3 (which is < 4, so it is considered clear-stock)
        $lowStockProduct = Product::create([
            'sku' => 'SKU-LOW-DYN',
            'name' => 'Dynamic Wood Scent',
            'slug' => 'dynamic-wood-scent',
            'description' => 'Shifting triggers test',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 3,
            'is_active' => true,
        ]);

        // Create abundant helper product to satisfy total MOQ
        $abundantProduct = Product::create([
            'sku' => 'SKU-ABUND-DYN',
            'name' => 'Forest Rain',
            'slug' => 'forest-rain',
            'description' => 'Heavy stock helper',
            'wholesale_price' => 40,
            'retail_price' => 80,
            'stock' => 50,
            'is_active' => true,
        ]);

        // Ordering 2 of the low-stock item must fail because dynamic threshold has shifted (must buy all 3)
        $responseFail = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$lowStockProduct->id, $abundantProduct->id],
                'quantity' => [2, 13],
            ]);

        $responseFail->assertSessionHasErrors(['quantity']);

        // Ordering all 3 of the low-stock item + 13 helper items must succeed!
        $responseOk = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$lowStockProduct->id, $abundantProduct->id],
                'quantity' => [3, 13],
            ]);

        $responseOk->assertSessionHasNoErrors();
        $this->assertEquals(1, $reseller->orders()->count());
    }

    public function test_reseller_can_add_item_to_persistent_cart(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        $product = Product::create([
            'sku' => 'SKU-CART-1',
            'name' => 'Persistent Parfum',
            'slug' => 'persistent-parfum',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 100,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.cart.update'), [
                'product_id' => $product->id,
                'quantity' => 5,
            ]);

        $response->assertOk()->assertJson(['success' => true]);
        
        $this->assertDatabaseHas('carts', [
            'user_id' => $reseller->id,
        ]);

        $cart = $reseller->cart;
        $this->assertNotNull($cart);
        $this->assertEquals([$product->id => 5], $cart->content);
    }

    public function test_reseller_can_remove_item_from_persistent_cart(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        $product = Product::create([
            'sku' => 'SKU-CART-1',
            'name' => 'Persistent Parfum',
            'slug' => 'persistent-parfum',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 100,
            'is_active' => true,
        ]);

        // Seed initial cart item
        $cart = \App\Models\Cart::create([
            'user_id' => $reseller->id,
            'content' => [$product->id => 5],
        ]);

        // Set quantity to 0 to remove item
        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.cart.update'), [
                'product_id' => $product->id,
                'quantity' => 0,
            ]);

        $response->assertOk();
        $this->assertEquals([], $cart->fresh()->content);
    }

    public function test_reseller_can_clear_persistent_cart(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        
        // Seed initial cart
        $cart = \App\Models\Cart::create([
            'user_id' => $reseller->id,
            'content' => [12 => 5, 34 => 10],
        ]);

        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.cart.clear'));

        $response->assertOk();
        $this->assertEquals([], $cart->fresh()->content);
    }

    public function test_persistent_cart_is_cleared_on_successful_checkout(): void
    {
        $reseller = User::factory()->create(['role' => 'reseller']);
        
        $product = Product::create([
            'sku' => 'SKU-CHECKOUT-1',
            'name' => 'Checkout Scent',
            'slug' => 'checkout-scent',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 100,
            'is_active' => true,
        ]);

        // Seed dynamic cart with selection
        $cart = \App\Models\Cart::create([
            'user_id' => $reseller->id,
            'content' => [$product->id => 15],
        ]);

        // Checkout the items (satisfies MOQ of 15 units total)
        $response = $this
            ->actingAs($reseller)
            ->post(route('reseller.orders.store'), [
                'product_id' => [$product->id],
                'quantity' => [15],
            ]);

        $response->assertRedirect();
        $this->assertEquals([], $cart->fresh()->content);
    }
}
