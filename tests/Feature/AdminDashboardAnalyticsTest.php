<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_uses_product_stock_metrics(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        Product::create([
            'sku' => 'ADM-PRD-1',
            'name' => 'Product One',
            'slug' => 'product-one',
            'description' => 'Test Product One',
            'wholesale_price' => 40,
            'retail_price' => 80,
            'stock' => 100,
            'is_active' => true,
        ]);

        Product::create([
            'sku' => 'ADM-PRD-2',
            'name' => 'Product Two',
            'slug' => 'product-two',
            'description' => 'Test Product Two',
            'wholesale_price' => 60,
            'retail_price' => 120,
            'stock' => 10, // low stock (< 50)
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertViewHas('adminStock', 110)
            ->assertViewHas('totalProducts', 2)
            ->assertViewHas('lowStockCount', 1);
    }
}
