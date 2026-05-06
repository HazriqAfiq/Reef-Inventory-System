<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryScannerController extends Controller
{
    /**
     * Show the inventory scanning screen.
     */
    public function index()
    {
        $products = Product::active()->orderBy('name')->get();
        return view('admin.inventory.scan-in', compact('products'));
    }

    /**
     * Add stock to a scanned product.
     */
    public function restock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->increment('stock', $request->quantity);

        // Record an activity log
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Restocked via Scanner',
            'description' => "Added {$request->quantity} units to {$product->name} (SKU: {$product->sku}).",
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully added {$request->quantity} units to {$product->name}.",
            'new_stock' => $product->stock
        ]);
    }
}
