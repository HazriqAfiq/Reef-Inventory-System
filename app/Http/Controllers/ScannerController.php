<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    /**
     * Look up a product by its SKU for barcode scanning operations.
     */
    public function lookup(Request $request, $sku)
    {
        $product = Product::active()
            ->where('sku', $sku)
            ->with(['variants', 'images'])
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found for SKU: ' . $sku
            ], 404);
        }

        // Return core product data
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'retail_price' => $product->retail_price,
                'wholesale_price' => $product->wholesale_price,
                'stock' => $product->stock,
                'volume_ml' => $product->volume_ml,
                'image_url' => $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : null,
            ]
        ]);
    }
}
