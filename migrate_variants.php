<?php

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function () {
    $products = Product::all();
    foreach ($products as $product) {
        // Only create if no variants exist
        if ($product->variants()->count() === 0) {
            ProductVariant::create([
                'product_id' => $product->id,
                'name' => $product->volume_ml ? $product->volume_ml . 'ml' : 'Default',
                'sku' => $product->sku,
                'retail_price' => $product->retail_price,
                'wholesale_price' => $product->wholesale_price,
                'stock' => $product->stock,
                'volume_ml' => $product->volume_ml,
            ]);
        }
    }
});

echo "Product variants populated successfully.\n";
