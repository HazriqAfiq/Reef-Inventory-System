<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResellerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ── All-time KPIs ─────────────────────────────────────────────────
        $myTotalRevenue  = $user->sales()->sum('total_price');
        $myTotalUnits    = $user->sales()->sum('quantity');
        $myTotalSales    = $user->sales()->count();
        $myCommission    = $user->calculateCommission($myTotalRevenue);

        // ── This-month KPIs ───────────────────────────────────────────────
        $thisMonthRevenue = $user->sales()
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $lastMonthRevenue = $user->sales()
            ->whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->sum('total_price');

        $revenueChange = $lastMonthRevenue > 0
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : null;

        $thisMonthCommission = $user->calculateCommission($thisMonthRevenue);
        $lastMonthCommission = $user->calculateCommission($lastMonthRevenue);
        $commissionChange = $lastMonthCommission > 0
            ? round((($thisMonthCommission - $lastMonthCommission) / $lastMonthCommission) * 100, 1)
            : null;

        // ── Inventory snapshot (Personal Stock) ───────────────────────────
        $availableProducts = $user->resellerStocks()->where('quantity', '>', 0)->count();
        $lowStockProducts  = $user->resellerStocks()
            ->where('quantity', '>', 0)
            ->where('quantity', '<=', 10)
            ->with('product')
            ->orderBy('quantity')
            ->get();

        // ── Chart: Daily revenue (last 30 days) scoped to this reseller ───
        $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->startOfDay());

        $dailyRevMap = $user->sales()
            ->select(DB::raw("date(created_at) as day"), DB::raw("SUM(total_price) as revenue"))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('revenue', 'day');

        $dailyUnitMap = $user->sales()
            ->select(DB::raw("date(created_at) as day"), DB::raw("SUM(quantity) as units"))
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('units', 'day');

        $trendLabels  = $days->map(fn($d) => $d->format('d M'))->values();
        $trendRevenue = $days->map(fn($d) => round((float)($dailyRevMap[$d->toDateString()] ?? 0), 2))->values();
        $trendUnits   = $days->map(fn($d) => (int)($dailyUnitMap[$d->toDateString()] ?? 0))->values();

        // ── Top 5 products this reseller has sold ────────────────────────
        $myTopProducts = $user->sales()
            ->select('product_id',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(total_price) as total_rev')
            )
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $topProductLabels = $myTopProducts->map(fn($p) => $p->product->name)->values();
        $topProductData   = $myTopProducts->pluck('total_qty')->values();
        $topProductRev    = $myTopProducts->pluck('total_rev')->values();

        // ── Performance Insights ──────────────────────────────────────────
        $insights = [];
        if ($revenueChange !== null) {
            if ($revenueChange > 0) {
                $insights[] = "Your sales increased by {$revenueChange}% this month! Keep up the great work.";
            } elseif ($revenueChange < 0) {
                $insights[] = "Your sales are down ".abs($revenueChange)."% compared to last month.";
            }
        }
        $topSeller = $myTopProducts->first();
        if ($topSeller) {
            $insights[] = "{$topSeller->product->name} is currently your best-selling product.";
        }
        if ($lowStockProducts->count() > 0) {
            $insights[] = "You have {$lowStockProducts->count()} product(s) running low on available stock.";
        } else {
            $insights[] = "Inventory levels are currently healthy.";
        }

        // ── Sparklines Data ───────────────────────────────────────────────
        $sparkRevenue   = $trendRevenue->slice(-7)->values();
        $sparkUnits     = $trendUnits->slice(-7)->values();

        // ── Recent sales ──────────────────────────────────────────────────
        $myRecentSales = $user->sales()
            ->with('product')
            ->latest()
            ->take(8)
            ->get();

        // ── 5. New Strategic Aggregates ─────────────────────────────────────
        // Weekly Velocity (Mon-Sun)
        $weeklyVelocityData = collect(range(0, 6))->map(function($i) use ($user) {
            return $user->sales()->where(DB::raw("DAYOFWEEK(created_at)"), $i + 1)->count();
        })->values();

        // Category Distribution
        $categoryDistribution = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('sales', 'products.id', '=', 'sales.product_id')
            ->where('sales.user_id', $user->id)
            ->select('categories.name', DB::raw('SUM(sales.quantity) as total_qty'))
            ->groupBy('categories.name')
            ->pluck('total_qty', 'categories.name');

        // Goal Progress
        $monthlyGoal = (float) $user->monthly_goal;
        $goalProgress = $monthlyGoal > 0 ? min(100, round(($thisMonthRevenue / $monthlyGoal) * 100, 1)) : 0;

        return view('reseller.dashboard', compact(
            'myTotalRevenue', 'myTotalUnits', 'myTotalSales', 'myCommission',
            'thisMonthRevenue', 'revenueChange', 'commissionChange',
            'availableProducts', 'lowStockProducts',
            'trendLabels', 'trendRevenue', 'trendUnits',
            'myTopProducts', 'topProductLabels', 'topProductData', 'topProductRev',
            'insights', 'sparkRevenue', 'sparkUnits',
            'myRecentSales', 'monthlyGoal', 'goalProgress',
            'weeklyVelocityData', 'categoryDistribution'
        ));
    }

    public function updateGoal(\Illuminate\Http\Request $request)
    {
        $request->validate(['monthly_goal' => 'required|numeric|min:0']);
        auth()->user()->update(['monthly_goal' => $request->monthly_goal]);
        return back()->with('success', 'Monthly goal updated successfully.');
    }
}
