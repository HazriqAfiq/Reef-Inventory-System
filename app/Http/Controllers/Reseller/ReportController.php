<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ── 1. Procurement Expenditures (Wholesale Sourcing) ─────────────────
        $totalProcurementSpend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->sum('total_price');

        $totalSourcedOrders = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->count();

        $averageOrderValue = $totalSourcedOrders > 0 ? $totalProcurementSpend / $totalSourcedOrders : 0;

        // Current Month Stats
        $currentMonthSpend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthlyGoal = (float) $user->monthly_goal;
        $goalProgress = $monthlyGoal > 0 ? min(100, round(($currentMonthSpend / $monthlyGoal) * 100, 1)) : 0;


        // ── 2. Current Shelf Stock Valuation & Margins ────────────────────────
        $stocks = $user->resellerStocks()->with('product')->get();

        $totalStockUnits = 0;
        $stockValuationCost = 0.0;
        $stockValuationRetail = 0.0;

        foreach ($stocks as $stock) {
            if ($stock->product) {
                $qty = $stock->quantity;
                $totalStockUnits += $qty;
                $stockValuationCost += $qty * $stock->product->wholesale_price;
                $stockValuationRetail += $qty * $stock->product->retail_price;
            }
        }

        $potentialProfitMargin = $stockValuationRetail - $stockValuationCost;
        $averageMarginPercentage = $stockValuationRetail > 0 ? ($potentialProfitMargin / $stockValuationRetail) * 100 : 0;


        // ── 3. Sourcing Trends (6-Month Purchase Expenditures) ───────────────
        $monthlyTrend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_key"),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_name"),
                DB::raw('SUM(total_price) as total_spend')
            )
            ->groupBy('month_key', 'month_name')
            ->orderBy('month_key', 'asc')
            ->take(6)
            ->get();


        // ── 4. Wholesale Order Status Distribution ───────────────────────────
        $statusBreakdown = $user->orders()
            ->select('status', DB::raw('COUNT(id) as count'), DB::raw('SUM(total_price) as total_val'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $statuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PAID,
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED,
            Order::STATUS_CANCELLED
        ];

        $orderStats = [];
        foreach ($statuses as $st) {
            $orderStats[$st] = [
                'count' => $statusBreakdown[$st]->count ?? 0,
                'total' => $statusBreakdown[$st]->total_val ?? 0
            ];
        }


        // ── 5. Sourcing Intelligence (Top Sourced Products) ───────────────────
        $topSourcedProducts = OrderItem::whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED]);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as total_spend'))
            ->groupBy('product_id')
            ->with(['product.primaryImage', 'product.category'])
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('reseller.reports.index', compact(
            'totalProcurementSpend',
            'totalSourcedOrders',
            'averageOrderValue',
            'currentMonthSpend',
            'monthlyGoal',
            'goalProgress',
            'totalStockUnits',
            'stockValuationCost',
            'stockValuationRetail',
            'potentialProfitMargin',
            'averageMarginPercentage',
            'monthlyTrend',
            'orderStats',
            'topSourcedProducts'
        ));
    }

    public function exportPdf()
    {
        $user = auth()->user();

        // ── 1. Procurement Expenditures (Wholesale Sourcing) ─────────────────
        $totalProcurementSpend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->sum('total_price');

        $totalSourcedOrders = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->count();

        $averageOrderValue = $totalSourcedOrders > 0 ? $totalProcurementSpend / $totalSourcedOrders : 0;

        // Current Month Stats
        $currentMonthSpend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthlyGoal = (float) $user->monthly_goal;
        $goalProgress = $monthlyGoal > 0 ? min(100, round(($currentMonthSpend / $monthlyGoal) * 100, 1)) : 0;


        // ── 2. Current Shelf Stock Valuation & Margins ────────────────────────
        $stocks = $user->resellerStocks()->with('product')->get();

        $totalStockUnits = 0;
        $stockValuationCost = 0.0;
        $stockValuationRetail = 0.0;

        foreach ($stocks as $stock) {
            if ($stock->product) {
                $qty = $stock->quantity;
                $totalStockUnits += $qty;
                $stockValuationCost += $qty * $stock->product->wholesale_price;
                $stockValuationRetail += $qty * $stock->product->retail_price;
            }
        }

        $potentialProfitMargin = $stockValuationRetail - $stockValuationCost;
        $averageMarginPercentage = $stockValuationRetail > 0 ? ($potentialProfitMargin / $stockValuationRetail) * 100 : 0;


        // ── 3. Sourcing Trends (6-Month Purchase Expenditures) ───────────────
        $monthlyTrend = $user->orders()
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED])
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_key"),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_name"),
                DB::raw('SUM(total_price) as total_spend')
            )
            ->groupBy('month_key', 'month_name')
            ->orderBy('month_key', 'asc')
            ->take(6)
            ->get();


        // ── 4. Wholesale Order Status Distribution ───────────────────────────
        $statusBreakdown = $user->orders()
            ->select('status', DB::raw('COUNT(id) as count'), DB::raw('SUM(total_price) as total_val'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $statuses = [
            Order::STATUS_PENDING,
            Order::STATUS_PAID,
            Order::STATUS_PROCESSING,
            Order::STATUS_SHIPPED,
            Order::STATUS_DELIVERED,
            Order::STATUS_CANCELLED
        ];

        $orderStats = [];
        foreach ($statuses as $st) {
            $orderStats[$st] = [
                'count' => $statusBreakdown[$st]->count ?? 0,
                'total' => $statusBreakdown[$st]->total_val ?? 0
            ];
        }


        // ── 5. Sourcing Intelligence (Top Sourced Products) ───────────────────
        $topSourcedProducts = OrderItem::whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_PROCESSING, Order::STATUS_SHIPPED, Order::STATUS_DELIVERED]);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(quantity * price) as total_spend'))
            ->groupBy('product_id')
            ->with(['product.primaryImage', 'product.category'])
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        $pdf = Pdf::loadView('reseller.reports.pdf', compact(
            'user',
            'totalProcurementSpend',
            'totalSourcedOrders',
            'averageOrderValue',
            'currentMonthSpend',
            'monthlyGoal',
            'goalProgress',
            'totalStockUnits',
            'stockValuationCost',
            'stockValuationRetail',
            'potentialProfitMargin',
            'averageMarginPercentage',
            'monthlyTrend',
            'orderStats',
            'topSourcedProducts'
        ));

        return $pdf->download("reseller_performance_report_" . now()->format('Y_m_d') . ".pdf");
    }
}
