<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ResellerStock;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResellerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ── 1. Load Personal Stocks & Products ────────────────────────────
        $myStocks = $user->resellerStocks()->with(['product.primaryImage'])->get();

        // If user has no stocks yet, seed them or retrieve available products to allow audit
        if ($myStocks->isEmpty()) {
            $products = Product::all();
            foreach ($products as $p) {
                ResellerStock::create([
                    'user_id' => $user->id,
                    'product_id' => $p->id,
                    'quantity' => 0,
                ]);
            }
            $myStocks = $user->resellerStocks()->with(['product.primaryImage'])->get();
        }

        // ── 2. Top-Row KPI Calculations ──────────────────────────────────
        $totalAssetValuation = 0.0;
        $totalUnitsHeld = 0;
        $verifiedThisWeekCount = 0;

        $myStocks->each(function($stock) use (&$totalAssetValuation, &$totalUnitsHeld, &$verifiedThisWeekCount) {
            $stock->days_since_audit = $stock->updated_at ? $stock->updated_at->diffInDays(now()) : 99;
            
            // Asset Valuation (Current Count * Retail Price)
            if ($stock->product) {
                $totalAssetValuation += $stock->quantity * $stock->product->price;
                $totalUnitsHeld += $stock->quantity;
            }

            // Freshness audit health (Verified within 7 days)
            if ($stock->days_since_audit <= 7) {
                $verifiedThisWeekCount++;
            }

            // Map Freshness metrics
            if ($stock->days_since_audit <= 1) {
                $stock->freshness_status = 'Fresh (Verified today)';
                $stock->freshness_badge_color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                $stock->freshness_dot_color = 'bg-emerald-500';
                $stock->freshness_score = 100;
            } elseif ($stock->days_since_audit <= 3) {
                $stock->freshness_status = 'Recent (Verified within 3 days)';
                $stock->freshness_badge_color = 'bg-indigo-50 text-indigo-600 border-indigo-100';
                $stock->freshness_dot_color = 'bg-indigo-500';
                $stock->freshness_score = 80;
            } elseif ($stock->days_since_audit <= 7) {
                $stock->freshness_status = 'Warning (Over 4 days old)';
                $stock->freshness_badge_color = 'bg-amber-50 text-amber-600 border-amber-100';
                $stock->freshness_dot_color = 'bg-amber-500';
                $stock->freshness_score = 50;
            } else {
                $stock->freshness_status = 'Stale (Requires immediate audit)';
                $stock->freshness_badge_color = 'bg-rose-50 text-rose-600 border-rose-100';
                $stock->freshness_dot_color = 'bg-rose-500';
                $stock->freshness_score = 10;
            }
        });

        $totalStockItemsCount = max(1, $myStocks->count());
        $auditHealthPercentage = round(($verifiedThisWeekCount / $totalStockItemsCount) * 100);

        // ── 3. Stock Status & Distribution (Bar Chart) ───────────────────
        $stockLabels = $myStocks->map(fn($s) => $s->product?->name)->values();
        $stockCounts = $myStocks->pluck('quantity')->values();

        // ── 4. Needs Attention List ──────────────────────────────────────
        // Items where last verified > 7 days or quantity is dangerously low (<= 5)
        $needsAttentionList = $myStocks->filter(function($stock) {
            return $stock->days_since_audit > 7 || $stock->quantity <= 5;
        })->sortByDesc('days_since_audit')->take(5)->values();

        // ── 5. Restock Recommendations ───────────────────────────────────
        // Proactively suggest buying replacement boxes if quantity is under 15
        $restockRecommendations = [];
        foreach ($myStocks as $stock) {
            if ($stock->quantity <= 15 && $stock->product) {
                $recommendedQty = 40 - $stock->quantity; // Restock target ceiling
                $restockRecommendations[] = [
                    'product' => $stock->product,
                    'current_qty' => $stock->quantity,
                    'recommended_qty' => $recommendedQty,
                    'reason' => $stock->quantity == 0 ? 'Out of Stock' : 'Low Stock Threshold'
                ];
            }
        }
        $restockRecommendations = collect($restockRecommendations)->sortBy('current_qty')->take(3)->values();

        // ── 6. Order Status Tracker (Incoming Shipments) ─────────────────
        $myRecentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->take(4)
            ->get();

        // ── 7. Monthly Wholesale Goals (procurement targets) ─────────────
        $thisMonthSpend = $user->orders()
            ->where('status', '!=', Order::STATUS_CANCELLED)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $monthlyGoal = (float) $user->monthly_goal;
        $goalProgress = $monthlyGoal > 0 ? min(100, round(($thisMonthSpend / $monthlyGoal) * 100, 1)) : 0;

        return view('reseller.dashboard', compact(
            'myStocks', 'totalAssetValuation', 'totalUnitsHeld', 'auditHealthPercentage',
            'stockLabels', 'stockCounts',
            'needsAttentionList', 'restockRecommendations', 'myRecentOrders',
            'thisMonthSpend', 'monthlyGoal', 'goalProgress'
        ));
    }

    public function auditPage()
    {
        $user = auth()->user();
        $myStocks = $user->resellerStocks()->with(['product.primaryImage'])->get();

        // If user has no stocks yet, seed them
        if ($myStocks->isEmpty()) {
            $products = Product::all();
            foreach ($products as $p) {
                ResellerStock::create([
                    'user_id' => $user->id,
                    'product_id' => $p->id,
                    'quantity' => 0,
                ]);
            }
            $myStocks = $user->resellerStocks()->with(['product.primaryImage'])->get();
        }

        $verifiedThisWeekCount = 0;
        $myStocks->each(function($stock) use (&$verifiedThisWeekCount, $user) {
            $stock->days_since_audit = $stock->updated_at ? $stock->updated_at->diffInDays(now()) : 99;
            if ($stock->days_since_audit <= 7) {
                $verifiedThisWeekCount++;
            }

            // Map Freshness metrics
            if ($stock->days_since_audit <= 1) {
                $stock->freshness_status = 'Fresh (Verified today)';
                $stock->freshness_badge_color = 'bg-emerald-50 text-emerald-600 border-emerald-100';
            } elseif ($stock->days_since_audit <= 3) {
                $stock->freshness_status = 'Recent (Verified within 3 days)';
                $stock->freshness_badge_color = 'bg-indigo-50 text-indigo-600 border-indigo-100';
            } elseif ($stock->days_since_audit <= 7) {
                $stock->freshness_status = 'Warning (Over 4 days old)';
                $stock->freshness_badge_color = 'bg-amber-50 text-amber-600 border-amber-100';
            } else {
                $stock->freshness_status = 'Stale (Audit Required)';
                $stock->freshness_badge_color = 'bg-rose-50 text-rose-600 border-rose-100';
            }

            // The maximum they can audit is strictly their current database stock count
            $stock->total_restocked = $stock->quantity;
        });

        $totalStockItemsCount = max(1, $myStocks->count());
        $auditHealthPercentage = round(($verifiedThisWeekCount / $totalStockItemsCount) * 100);

        return view('reseller.audit.index', compact('myStocks', 'auditHealthPercentage'));
    }

    public function auditStock(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array',
            'stocks.*' => 'required|integer|min:0',
        ]);

        $user = auth()->user();

        foreach ($request->stocks as $stockId => $qty) {
            $stock = $user->resellerStocks()->find($stockId);
            if (!$stock) {
                continue;
            }

            $maxAllowed = $stock->quantity;

            if ($qty > $maxAllowed) {
                return back()->with('error', "Audit integrity violation! You cannot audit '{$stock->product->name}' with {$qty} units. The maximum allowed is {$maxAllowed} units (Current Stock on Hand).");
            }

            $stock->update([
                'quantity' => $qty,
                'updated_at' => now(), // Force-update timestamp to today
            ]);
        }

        return back()->with('success', 'Physical shelf counts successfully updated! Audit health is restored to green.');
    }

    public function updateGoal(Request $request)
    {
        $request->validate(['monthly_goal' => 'required|numeric|min:0']);
        auth()->user()->update(['monthly_goal' => $request->monthly_goal]);
        return back()->with('success', 'Monthly restock target updated successfully.');
    }
}
