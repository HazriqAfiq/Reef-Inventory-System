<?php

namespace App\Http\Controllers\Reseller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = $user->resellerStocks()->with(['product.primaryImage']);

        // Search by product name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by Stock Level
        if ($request->filled('stock')) {
            $stockFilter = $request->stock;
            if ($stockFilter === 'high') {
                $query->where('quantity', '>', 100);
            } elseif ($stockFilter === 'medium') {
                $query->whereBetween('quantity', [50, 100]);
            } elseif ($stockFilter === 'low') {
                $query->whereBetween('quantity', [1, 49]);
            } elseif ($stockFilter === 'out') {
                $query->where('quantity', 0);
            }
        }

        // Filter by Volume
        if ($request->filled('volume')) {
            $volume = $request->volume;
            $query->whereHas('product', function($q) use ($volume) {
                $q->where('volume_ml', $volume);
            });
        }

        // Sort
        $sort = $request->get('sort', 'name');
        if ($sort === 'stock_desc') {
            $query->orderBy('quantity', 'desc');
        } elseif ($sort === 'stock_asc') {
            $query->orderBy('quantity', 'asc');
        } elseif ($sort === 'last_audited') {
            $query->orderBy('updated_at', 'desc');
        } else {
            // Sort by product name
            $query->join('products', 'reseller_stocks.product_id', '=', 'products.id')
                  ->select('reseller_stocks.*')
                  ->orderBy('products.name', 'asc');
        }

        $stocks = $query->paginate(15)->withQueryString();

        // 4 KPI Card values computed for the WHOLE inventory of this reseller
        $allStocks = $user->resellerStocks()->get();
        $totalProducts = $allStocks->count();
        $totalStockUnits = $allStocks->sum('quantity');
        
        $averageAge = $allStocks->avg(function($stock) {
            return $stock->updated_at ? $stock->updated_at->diffInDays(now()) : 99;
        }) ?? 0;

        $lowStockCount = $allStocks->whereBetween('quantity', [1, 15])->count();
        $outOfStockCount = $allStocks->where('quantity', 0)->count();

        // Volumes list for dropdown
        $volumes = Product::distinct()->pluck('volume_ml')->toArray();

        return view('reseller.stock.index', compact(
            'stocks', 'totalProducts', 'totalStockUnits', 'averageAge', 'lowStockCount', 'outOfStockCount', 'volumes'
        ));
    }
}
