<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear  = (int) $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->has('month') ? $request->input('month') : Carbon::now()->month;

        $earliestYear = Sale::min('created_at') ? Carbon::parse(Sale::min('created_at'))->year : Carbon::now()->year;
        $availableYears = collect(range(Carbon::now()->year, $earliestYear))->unique()->sortDesc();

        $availableMonths = ($selectedYear === Carbon::now()->year) 
            ? range(1, Carbon::now()->month) 
            : range(1, 12);

        $periodLabel = $selectedMonth 
            ? Carbon::create()->month((int) $selectedMonth)->format('F') . ' ' . $selectedYear
            : 'Year ' . $selectedYear;

        $shortPeriodLabel = $selectedMonth
            ? Carbon::create()->month((int) $selectedMonth)->format('M') . ' ' . $selectedYear
            : $selectedYear;

        if (auth()->user()->isAdmin()) {
            $baseQuery = Sale::with(['user', 'product'])
                ->whereYear('created_at', $selectedYear);

            if ($selectedMonth) {
                $baseQuery->whereMonth('created_at', $selectedMonth);
                $days = collect(range(1, Carbon::createFromDate($selectedYear, (int)$selectedMonth, 1)->daysInMonth));
                $trendMap = (clone $baseQuery)->selectRaw('DAY(created_at) as day, SUM(total_price) as rev, SUM(quantity) as units')->groupBy('day')->get()->keyBy('day');
                $trendLabels = $days->map(fn($d) => str_pad($d, 2, '0', STR_PAD_LEFT) . ' ' . substr($periodLabel, 0, 3))->values();
                $trendRevenue = $days->map(fn($d) => round($trendMap->has($d) ? $trendMap->get($d)->rev : 0, 2))->values();
                $trendUnits = $days->map(fn($d) => (int)($trendMap->has($d) ? $trendMap->get($d)->units : 0))->values();
            } else {
                $months = collect(range(1, 12));
                $trendMap = (clone $baseQuery)->selectRaw('MONTH(created_at) as month, SUM(total_price) as rev, SUM(quantity) as units')->groupBy('month')->get()->keyBy('month');
                $trendLabels = $months->map(fn($m) => Carbon::create()->month($m)->format('M'))->values();
                $trendRevenue = $months->map(fn($m) => round($trendMap->has($m) ? $trendMap->get($m)->rev : 0, 2))->values();
                $trendUnits = $months->map(fn($m) => (int)($trendMap->has($m) ? $trendMap->get($m)->units : 0))->values();
            }

            $monthRevenue      = (clone $baseQuery)->sum('total_price');
            $monthUnitsSold    = (clone $baseQuery)->sum('quantity');
            $monthTransactions = (clone $baseQuery)->count();

            $sales = (clone $baseQuery)->latest()->paginate(15)->appends($request->all());

            if ($request->ajax() && !$request->header('X-SPA')) {
                return view('admin.sales.partials.table', compact('sales'))->render();
            }

            return view('admin.sales.index', compact(
                'sales', 'selectedYear', 'selectedMonth', 'availableYears', 'availableMonths',
                'periodLabel', 'shortPeriodLabel',
                'monthRevenue', 'monthUnitsSold', 'monthTransactions',
                'trendLabels', 'trendRevenue', 'trendUnits'
            ));
        }

        $baseQuery = auth()->user()->sales()
            ->with('product')
            ->whereYear('created_at', $selectedYear);

        if ($selectedMonth) {
            $baseQuery->whereMonth('created_at', $selectedMonth);
            $days = collect(range(1, Carbon::createFromDate($selectedYear, (int)$selectedMonth, 1)->daysInMonth));
            $trendMap = (clone $baseQuery)->selectRaw('DAY(created_at) as day, SUM(total_price) as rev, SUM(quantity) as units')->groupBy('day')->get()->keyBy('day');
            $trendLabels = $days->map(fn($d) => str_pad($d, 2, '0', STR_PAD_LEFT) . ' ' . substr($periodLabel, 0, 3))->values();
            $trendRevenue = $days->map(fn($d) => round($trendMap->has($d) ? $trendMap->get($d)->rev : 0, 2))->values();
            $trendUnits = $days->map(fn($d) => (int)($trendMap->has($d) ? $trendMap->get($d)->units : 0))->values();
        } else {
            $months = collect(range(1, 12));
            $trendMap = (clone $baseQuery)->selectRaw('MONTH(created_at) as month, SUM(total_price) as rev, SUM(quantity) as units')->groupBy('month')->get()->keyBy('month');
            $trendLabels = $months->map(fn($m) => Carbon::create()->month($m)->format('M'))->values();
            $trendRevenue = $months->map(fn($m) => round($trendMap->has($m) ? $trendMap->get($m)->rev : 0, 2))->values();
            $trendUnits = $months->map(fn($m) => (int)($trendMap->has($m) ? $trendMap->get($m)->units : 0))->values();
        }

        $monthRevenue      = (clone $baseQuery)->sum('total_price');
        $monthUnitsSold    = (clone $baseQuery)->sum('quantity');
        $monthTransactions = (clone $baseQuery)->count();

        $sales = (clone $baseQuery)->latest()->paginate(15)->appends($request->all());

        if ($request->ajax() && !$request->header('X-SPA')) {
            $view = $isAdmin ? 'admin.sales.partials.table' : 'reseller.sales.partials.table';
            return view($view, compact('sales'))->render();
        }

        return view('reseller.sales.index', compact(
            'sales', 'selectedYear', 'selectedMonth', 'availableYears', 'availableMonths',
            'periodLabel', 'shortPeriodLabel',
            'monthRevenue', 'monthUnitsSold', 'monthTransactions',
            'trendLabels', 'trendRevenue', 'trendUnits'
        ));
    }

    public function create()
    {
        $products = auth()->user()->resellerStocks()->where('quantity', '>', 0)->with('product')->get();
        return view('reseller.sales.create', compact('products'));
    }

    public function store(StoreSaleRequest $request)
    {
        $stock = auth()->user()->resellerStocks()->where('product_id', $request->product_id)->firstOrFail();

        if ($stock->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough personal stock available. Please restock from Admin.']);
        }

        $sale = auth()->user()->sales()->create([
            'product_id'  => $stock->product_id,
            'quantity'    => $request->quantity,
            'total_price' => $stock->product->retail_price * $request->quantity,
        ]);

        $stock->decrement('quantity', $request->quantity);

        // Load relation for notification message
        $sale->load('product');
        NotificationService::newSale($sale, auth()->user());

        // Check admin-side inventory level after reseller stock deducted
        $product = $stock->product->fresh();
        if ($product->stock === 0) {
            NotificationService::outOfStock($product);
        } elseif ($product->stock < 50) {
            NotificationService::lowStock($product);
        }

        return redirect()->route('reseller.sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale) {}
    public function edit(Sale $sale) {}
    public function update(UpdateSaleRequest $request, Sale $sale) {}
    public function destroy(Sale $sale) {}

    public function report(Request $request)
    {
        $selectedYear  = (int) $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->has('month') ? $request->input('month') : Carbon::now()->month;

        $periodLabel = $selectedMonth 
            ? Carbon::create()->month((int) $selectedMonth)->format('F') . ' ' . $selectedYear
            : 'Year ' . $selectedYear;

        $baseQuery = Sale::query()->whereYear('created_at', $selectedYear);

        if ($selectedMonth) {
            $baseQuery->whereMonth('created_at', $selectedMonth);
        }

        $monthRevenue      = (clone $baseQuery)->sum('total_price');
        $monthUnitsSold    = (clone $baseQuery)->sum('quantity');
        $monthTransactions = (clone $baseQuery)->count();

        $prevQuery = Sale::query();
        if ($selectedMonth) {
            $prevDate = Carbon::create($selectedYear, (int)$selectedMonth, 1)->subMonth();
            $prevQuery->whereYear('created_at', $prevDate->year)->whereMonth('created_at', $prevDate->month);
            $prevPeriodLabel = $prevDate->format('M Y');
        } else {
            $prevQuery->whereYear('created_at', $selectedYear - 1);
            $prevPeriodLabel = 'Year ' . ($selectedYear - 1);
        }

        $prevRevenue      = (clone $prevQuery)->sum('total_price');
        $prevUnitsSold    = (clone $prevQuery)->sum('quantity');
        $prevTransactions = (clone $prevQuery)->count();

        $calcDelta = function($current, $prev) {
            if ($prev == 0) return $current > 0 ? '+100%' : '0%';
            $pct = (($current - $prev) / $prev) * 100;
            return ($pct > 0 ? '+' : '') . number_format($pct, 1) . '%';
        };

        $deltas = [
            'revenue' => $calcDelta($monthRevenue, $prevRevenue),
            'units'   => $calcDelta($monthUnitsSold, $prevUnitsSold),
            'txs'     => $calcDelta($monthTransactions, $prevTransactions),
            'label'   => "vs $prevPeriodLabel"
        ];

        $salesByProduct = (clone $baseQuery)
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(total_price) as total_rev')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_rev')
            ->get();

        $resellers = \App\Models\User::where('role', 'reseller')->get();
        $salesGrouped = (clone $baseQuery)
            ->selectRaw('user_id, COUNT(id) as tx_count, SUM(quantity) as total_qty, SUM(total_price) as total_rev')
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $salesByReseller = $resellers->map(function ($reseller) use ($salesGrouped) {
            $stats = $salesGrouped->get($reseller->id);
            return (object) [
                'user' => $reseller,
                'tx_count' => $stats ? $stats->tx_count : 0,
                'total_qty' => $stats ? $stats->total_qty : 0,
                'total_rev' => $stats ? $stats->total_rev : 0,
            ];
        })->sortByDesc('total_rev')->values();

        $pdf = Pdf::loadView('admin.sales.report', compact(
            'periodLabel',
            'monthRevenue', 'monthUnitsSold', 'monthTransactions',
            'salesByProduct', 'salesByReseller', 'deltas'
        ));

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'RPIMS-Sales-Report-' . str_replace(' ', '-', $periodLabel) . '.pdf';

        return $pdf->download($fileName);
    }
}
