<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ── 1. KPI Cards (Channel-Based) ──────────────────────────────────────
        


        // Wholesale Revenue: Sales made to Resellers (Partner stock purchase)
        $wholesaleRevenue = \App\Models\Order::where('status', 'paid')
            ->sum('total_price');

        // Total Net Income: Real income for the Admin
        $totalNetIncome = $wholesaleRevenue;

        // Wholesale Units Sold: Total units supplied to resellers
        $wholesaleUnitsSold = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->where('status', 'paid');
        })->sum('quantity');

        // Reseller Network Volume: Sales made BY resellers to their customers (Market Volume / Sell-Out)
        $networkVolume = Sale::sum('total_price');

        $adminStock           = Product::sum('stock');
        $resellerStock        = \App\Models\ResellerStock::sum('quantity');
        $totalProductsInStock = $adminStock + $resellerStock;
        
        $activeResellers      = User::where('role', \App\Models\User::ROLE_RESELLER)->count();
        $totalProducts        = Product::count();
        $lowStockCount        = Product::where('stock', '<', 50)->count();

        // Month-over-month total income change
        $thisMonthIncome = \App\Models\Order::where('status', 'paid')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        $lastMonthIncome = \App\Models\Order::where('status', 'paid')
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_price');

        $incomeChange = $lastMonthIncome > 0
            ? round((($thisMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100, 1)
            : null;

        // ── 2. Trends (last 30 days) ──────────────────────────────────────────
        $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->startOfDay());



        // Daily Wholesale Revenue
        $dailyWholesale = \App\Models\Order::where('status', 'paid')
            ->whereHas('user', function($q) { $q->where('role', \App\Models\User::ROLE_RESELLER); })
            ->select(DB::raw("date(created_at) as day"), DB::raw("SUM(total_price) as revenue"))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('revenue', 'day');

        // Daily Reseller Network Sales (Market Velocity)
        $dailyNetwork = Sale::whereHas('user', function($q) { $q->where('role', \App\Models\User::ROLE_RESELLER); })
            ->select(DB::raw("date(created_at) as day"), DB::raw("SUM(total_price) as revenue"))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('revenue', 'day');

        // Total Trend Items (Retail units - Admin + Reseller)
        $dailyTotalUnits = Sale::select(DB::raw("date(created_at) as day"), DB::raw("SUM(quantity) as units"))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('units', 'day');

        $trendLabels         = $days->map(fn($d) => $d->format('d M'))->values();

        $trendWholesale      = $days->map(fn($d) => round((float)($dailyWholesale[$d->toDateString()] ?? 0), 2))->values();
        $trendNetwork        = $days->map(fn($d) => round((float)($dailyNetwork[$d->toDateString()] ?? 0), 2))->values();
        $trendUnits          = $days->map(fn($d) => (int)($dailyTotalUnits[$d->toDateString()] ?? 0))->values();

        // ── 3. Inventory & SKU Growth (Sparklines) ──────────────────────────
        $sparkSkus = $days->map(fn($d) => Product::where('created_at', '<=', $d->endOfDay())->count())->slice(-7)->values();

        $currentStockTotal = $totalProductsInStock;
        $sparkStock = $days->map(function($d) use ($currentStockTotal) {
            $salesSince = Sale::where('created_at', '>', $d->endOfDay())->sum('quantity');
            $wholesaleSince = \App\Models\OrderItem::whereHas('order', function($q) { $q->where('status', 'paid'); })
                                                   ->where('created_at', '>', $d->endOfDay())
                                                   ->sum('quantity');
            return $currentStockTotal + $salesSince + $wholesaleSince;
        })->slice(-7)->values();

        // ── 4. Additional Lists & Lists ──────────────────────────────────────
        $months = collect(range(5, 0))->map(fn($i) => now()->subMonths($i));
        $monthlySalesLabels = $months->map(fn($m) => $m->format('M Y'))->values();
        $monthlySalesData   = $months->map(fn($m) => round((float) \App\Models\Order::where('status', 'paid')->whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->sum('total_price'), 2))->values();

        // Top products by wholesale order volume
        $topProductsChart = Product::withSum(['orderItems as wholesale_qty' => function($q) {
            $q->whereHas('order', function($o) { $o->where('status', 'paid'); });
        }], 'quantity')
        ->withSum(['orderItems as wholesale_revenue' => function($q) {
            $q->whereHas('order', function($o) { $o->where('status', 'paid'); });
        }], DB::raw('quantity * price'))
        ->orderByDesc('wholesale_qty')
        ->take(8)
        ->get();

        $topProductLabels = $topProductsChart->pluck('name')->values();
        $topProductData   = $topProductsChart->map(fn($p) => $p->wholesale_qty ?? 0)->values();
        $topProductRevenueData = $topProductsChart->map(fn($p) => round((float)($p->wholesale_revenue ?? 0), 2))->values();

        $topProducts = $topProductsChart->take(5);

        // Top resellers by wholesale spend
        $topResellers = User::where('role', \App\Models\User::ROLE_RESELLER)
            ->withSum(['orders as wholesale_spend' => function($query) {
                $query->where('status', 'paid');
            }], 'total_price')
            ->orderByDesc('wholesale_spend')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<', 50)->orderBy('stock')->get();

        $recentWholesaleOrders = \App\Models\Order::with('user')
            ->latest()
            ->take(6)
            ->get();

        // ── Insights ──────────────────────────────────────────────────────────
        $insights = [];
        if ($incomeChange !== null) {
            $insights[] = ($incomeChange >= 0) ? "Direct income grew by {$incomeChange}% this month." : "Direct income dipped by ".abs($incomeChange)."% this month.";
        }
        if ($topSelling = $topProductsChart->first()) {
            $insights[] = "{$topSelling->name} is the current network top-seller.";
        }
        $insights[] = ($lowStockCount > 0) ? "{$lowStockCount} SKUs require restocking." : "Inventory levels are fully optimal.";

        $sparkRevenue = $trendWholesale->slice(-7)->values(); // Default sparkline shows wholesale trend

        // ── 5. New Strategic Aggregates ─────────────────────────────────────
        // Weekly Velocity (Mon-Sun)
        $weeklyVelocityData = collect(range(0, 6))->map(function($i) {
            return Sale::where(DB::raw("DAYOFWEEK(created_at)"), $i + 1)->count();
        })->values();

        // Category Distribution
        $categoryDistribution = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sales', 'products.id', '=', 'sales.product_id')
            ->select('categories.name', DB::raw('SUM(sales.quantity) as total_qty'))
            ->groupBy('categories.name')
            ->pluck('total_qty', 'categories.name');

        return view('admin.dashboard', compact(
            'wholesaleRevenue', 'totalNetIncome', 'networkVolume',
            'wholesaleUnitsSold', 'adminStock', 'resellerStock', 'totalProductsInStock',
            'totalProducts', 'lowStockCount', 'incomeChange', 'activeResellers',
            'trendLabels', 'trendWholesale', 'trendNetwork', 'trendUnits',
            'monthlySalesLabels', 'monthlySalesData',
            'topProductLabels', 'topProductData', 'topProductRevenueData',
            'topProducts', 'topResellers',
            'lowStockProducts', 'recentWholesaleOrders',
            'insights', 'sparkRevenue', 'sparkSkus', 'sparkStock', 'topProductsChart',
            'weeklyVelocityData', 'categoryDistribution'
        ));
    }
}
