<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── 1. Overview Cards (Critical numbers only) ────────────────────────
        $totalProducts = Product::count();
        $totalStockUnits = Product::sum('stock'); // HQ Stock
        $lowStockProductsCount = Product::where('stock', '<', 50)->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $totalResellers = User::where('role', User::ROLE_RESELLER)->count();
        
        // Monthly statistics (Current calendar month)
        $monthlyOrdersCount = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $monthlyRevenue = Order::where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // ── 2. Sales & Order Analytics ───────────────────────────────────────
        // Orders & Revenue Trend (Last 30 Days)
        $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->startOfDay());
        
        $dailyOrders = Order::select(
            DB::raw("date(created_at) as day"),
            DB::raw("COUNT(id) as count"),
            DB::raw("SUM(total_price) as revenue")
        )
        ->where('created_at', '>=', now()->subDays(29)->startOfDay())
        ->groupBy('day')
        ->get()
        ->keyBy('day');

        $trendLabels = $days->map(fn($d) => $d->format('d M'))->values();
        $trendRevenue = $days->map(fn($d) => round((float)($dailyOrders[$d->toDateString()]->revenue ?? 0), 2))->values();
        $trendCount = $days->map(fn($d) => (int)($dailyOrders[$d->toDateString()]->count ?? 0))->values();

        // Top Selling Products (by wholesale sales quantity)
        $topSellingProducts = Product::withSum(['orderItems as wholesale_qty' => function($q) {
                $q->whereHas('order', function($o) { $o->where('status', 'paid'); });
            }], 'quantity')
            ->withSum(['orderItems as wholesale_revenue' => function($q) {
                $q->whereHas('order', function($o) { $o->where('status', 'paid'); });
            }], DB::raw('quantity * price'))
            ->orderByDesc('wholesale_qty')
            ->take(5)
            ->get();

        // Top Reseller Buyers
        $topResellers = User::where('role', User::ROLE_RESELLER)
            ->withSum(['orders as wholesale_spend' => function($query) {
                $query->where('status', 'paid');
            }], 'total_price')
            ->withCount(['orders' => function($query) {
                $query->where('status', 'paid');
            }])
            ->orderByDesc('wholesale_spend')
            ->take(5)
            ->get();

        // ── 3. Inventory Alerts ──────────────────────────────────────────────
        // Low stock items (0 < stock < 50)
        $lowStockItems = Product::where('stock', '>', 0)
            ->where('stock', '<', 50)
            ->orderBy('stock')
            ->take(15)
            ->get();
            
        // Out of stock products (stock == 0)
        $outOfStockItems = Product::where('stock', 0)
            ->orderBy('name')
            ->take(15)
            ->get();
            
        // Recently restocked items (stock >= 50, sorted by updated_at desc)
        $recentlyRestockedItems = Product::where('stock', '>=', 50)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // ── 4. Recent Orders (Operational Visibility) ───────────────────────
        $recentOrders = Order::with('user')
            ->withSum('items as total_quantity', 'quantity')
            ->latest()
            ->take(10)
            ->get();

        // ── 5. Reseller Activity ─────────────────────────────────────────────
        // New Resellers (joined recently)
        $newResellers = User::where('role', User::ROLE_RESELLER)
            ->latest()
            ->take(5)
            ->get();
            
        // Most Active Resellers (alias of top reseller buyers)
        $mostActiveResellers = $topResellers;
        
        // Resellers with no recent orders (no orders in the last 30 days)
        $dormantResellers = User::where('role', User::ROLE_RESELLER)
            ->whereDoesntHave('orders', function($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->withMax('orders as last_order_date', 'created_at')
            ->take(5)
            ->get();

        // ── 6. Action Needed Section ─────────────────────────────────────────
        // Orders below MOQ
        $totalMoq = (int) \App\Models\Setting::getValue('reseller_total_moq', 15);
        $ordersBelowMoq = Order::with('user')
            ->withSum('items as total_quantity', 'quantity')
            ->latest()
            ->take(100)
            ->get()
            ->filter(fn($o) => ($o->total_quantity ?? 0) < $totalMoq)
            ->take(5);

        // Pending payment
        $pendingPaymentOrders = Order::with('user')
            ->withSum('items as total_quantity', 'quantity')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Low inventory warnings (low or out of stock warnings)
        $lowInventoryWarnings = Product::where('stock', '<', 50)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalStockUnits', 'lowStockProductsCount', 'pendingOrdersCount', 'totalResellers',
            'monthlyOrdersCount', 'monthlyRevenue',
            'trendLabels', 'trendRevenue', 'trendCount',
            'topSellingProducts', 'topResellers',
            'lowStockItems', 'outOfStockItems', 'recentlyRestockedItems',
            'recentOrders',
            'newResellers', 'mostActiveResellers', 'dormantResellers',
            'ordersBelowMoq', 'pendingPaymentOrders', 'lowInventoryWarnings'
        ));
    }
}
