<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class POSController extends Controller
{
    /**
     * Show the POS scanner screen for Admins to record direct sales.
     */
    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        return view('admin.sales.create', compact('products'));
    }

    /**
     * Store the direct sale.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $totalRevenue = 0;
        $totalItems = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            
            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => "Not enough stock for {$product->name}. Available: {$product->stock}"
                ], 400);
            }

            $price = $product->retail_price * $item['quantity'];
            $totalRevenue += $price;
            $totalItems += $item['quantity'];

            // Create individual sale records (or a grouped order, but currently Sale is per product)
            $sale = auth()->user()->sales()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_price' => $price,
            ]);

            $product->decrement('stock', $item['quantity']);

            // Notifications
            if ($product->stock === 0) {
                NotificationService::outOfStock($product);
            } elseif ($product->stock < 50) {
                NotificationService::lowStock($product);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully recorded sale of {$totalItems} items for RM" . number_format($totalRevenue, 2)
        ]);
    }
}
