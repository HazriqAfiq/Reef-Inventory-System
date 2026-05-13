<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // ── 1. Sales & Performance Analytics ──────────────────────────────────
        $totalPaidOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalPaidRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total_price');
        $averageOrderValue = $totalPaidOrders > 0 ? $totalPaidRevenue / $totalPaidOrders : 0;

        // Current Month stats
        $currentMonthOrders = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $currentMonthRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Order status distribution breakdown
        $statusBreakdown = Order::select('status', DB::raw('count(id) as count'), DB::raw('sum(total_price) as total_val'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];
        $orderStats = [];
        foreach ($statuses as $st) {
            $orderStats[$st] = [
                'count' => $statusBreakdown[$st]->count ?? 0,
                'total' => $statusBreakdown[$st]->total_val ?? 0
            ];
        }

        // ── 2. Best-Selling Fragrances ─────────────────────────────────────────
        $bestSellingProducts = Product::withSum(['orderItems as total_qty_sold' => function ($q) {
                $q->whereHas('order', function ($o) {
                    $o->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
                });
            }], 'quantity')
            ->withSum(['orderItems as total_revenue' => function ($q) {
                $q->whereHas('order', function ($o) {
                    $o->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
                });
            }], DB::raw('quantity * price'))
            ->orderByDesc('total_qty_sold')
            ->get()
            ->map(function ($product) use ($totalPaidRevenue) {
                $product->revenue_share = $totalPaidRevenue > 0 ? ($product->total_revenue / $totalPaidRevenue) * 100 : 0;
                return $product;
            });

        // ── 3. Reseller Insights ───────────────────────────────────────────────
        $topResellers = User::where('role', User::ROLE_RESELLER)
            ->withSum(['orders as total_spend' => function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
            }], 'total_price')
            ->withCount(['orders' => function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
            }])
            ->orderByDesc('total_spend')
            ->get();

        $newResellersCount = User::where('role', User::ROLE_RESELLER)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Inactive/Dormant resellers (no orders in last 60 days)
        $dormantResellers = User::where('role', User::ROLE_RESELLER)
            ->whereDoesntHave('orders', function ($q) {
                $q->where('created_at', '>=', now()->subDays(60));
            })
            ->withMax('orders as last_order_date', 'created_at')
            ->get();

        // ── 4. Inventory Alerts ────────────────────────────────────────────────
        $outOfStock = Product::where('stock', 0)->orderBy('name')->get();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<', 50)->orderBy('stock')->get();

        return view('admin.reports.index', compact(
            'totalPaidOrders',
            'totalPaidRevenue',
            'averageOrderValue',
            'currentMonthOrders',
            'currentMonthRevenue',
            'orderStats',
            'bestSellingProducts',
            'topResellers',
            'newResellersCount',
            'dormantResellers',
            'outOfStock',
            'lowStock'
        ));
    }

    public function exportPdf()
    {
        // ── 1. Sales & Performance Analytics ──────────────────────────────────
        $totalPaidOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalPaidRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])->sum('total_price');
        $averageOrderValue = $totalPaidOrders > 0 ? $totalPaidRevenue / $totalPaidOrders : 0;

        // Current Month stats
        $currentMonthOrders = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $currentMonthRevenue = Order::whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        // Order status distribution breakdown
        $statusBreakdown = Order::select('status', DB::raw('count(id) as count'), DB::raw('sum(total_price) as total_val'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $statuses = ['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'];
        $orderStats = [];
        foreach ($statuses as $st) {
            $orderStats[$st] = [
                'count' => $statusBreakdown[$st]->count ?? 0,
                'total' => $statusBreakdown[$st]->total_val ?? 0
            ];
        }

        // ── 2. Best-Selling Fragrances ─────────────────────────────────────────
        $bestSellingProducts = Product::withSum(['orderItems as total_qty_sold' => function ($q) {
                $q->whereHas('order', function ($o) {
                    $o->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
                });
            }], 'quantity')
            ->withSum(['orderItems as total_revenue' => function ($q) {
                $q->whereHas('order', function ($o) {
                    $o->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
                });
            }], DB::raw('quantity * price'))
            ->orderByDesc('total_qty_sold')
            ->get()
            ->map(function ($product) use ($totalPaidRevenue) {
                $product->revenue_share = $totalPaidRevenue > 0 ? ($product->total_revenue / $totalPaidRevenue) * 100 : 0;
                return $product;
            });

        // ── 3. Reseller Insights ───────────────────────────────────────────────
        $topResellers = User::where('role', User::ROLE_RESELLER)
            ->withSum(['orders as total_spend' => function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
            }], 'total_price')
            ->withCount(['orders' => function ($q) {
                $q->whereIn('status', ['paid', 'processing', 'shipped', 'delivered']);
            }])
            ->orderByDesc('total_spend')
            ->get();

        $newResellersCount = User::where('role', User::ROLE_RESELLER)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Inactive/Dormant resellers (no orders in last 60 days)
        $dormantResellers = User::where('role', User::ROLE_RESELLER)
            ->whereDoesntHave('orders', function ($q) {
                $q->where('created_at', '>=', now()->subDays(60));
            })
            ->withMax('orders as last_order_date', 'created_at')
            ->get();

        // ── 4. Inventory Alerts ────────────────────────────────────────────────
        $outOfStock = Product::where('stock', 0)->orderBy('name')->get();
        $lowStock = Product::where('stock', '>', 0)->where('stock', '<', 50)->orderBy('stock')->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'totalPaidOrders',
            'totalPaidRevenue',
            'averageOrderValue',
            'currentMonthOrders',
            'currentMonthRevenue',
            'orderStats',
            'bestSellingProducts',
            'topResellers',
            'newResellersCount',
            'dormantResellers',
            'outOfStock',
            'lowStock'
        ));

        return $pdf->download("sales_performance_report_" . now()->format('Y_m_d') . ".pdf");
    }
}
