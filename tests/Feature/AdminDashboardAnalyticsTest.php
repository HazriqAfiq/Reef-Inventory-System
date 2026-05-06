<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_uses_variant_stock_metrics(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        $product = Product::create([
            'sku' => 'ADM-PRD-'.uniqid(),
            'name' => 'Admin Product '.uniqid(),
            'slug' => 'admin-product-'.uniqid(),
            'description' => 'Admin dashboard product',
            'wholesale_price' => 50,
            'retail_price' => 100,
            'stock' => 999, // legacy field should not drive admin stock KPI
            'is_active' => true,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '50ml',
            'sku' => 'ADM-VAR-'.uniqid(),
            'retail_price' => 80,
            'wholesale_price' => 40,
            'stock' => 100,
        ]);

        ProductVariant::create([
            'product_id' => $product->id,
            'name' => '100ml',
            'sku' => 'ADM-VAR-'.uniqid(),
            'retail_price' => 120,
            'wholesale_price' => 60,
            'stock' => 10,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertViewHas('adminStock', 110)
            ->assertViewHas('totalProducts', 2)
            ->assertViewHas('lowStockCount', 1);
    }
}
