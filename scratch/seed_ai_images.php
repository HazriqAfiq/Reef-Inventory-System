<?php

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

DB::transaction(function () {
    // 1. Clear existing images
    ProductImage::truncate();

    // 2. Define AI images
    $aiImages = [
        ['path' => 'products/ai_perfume_1.png', 'primary' => true],
        ['path' => 'products/ai_perfume_2.png', 'primary' => false],
        ['path' => 'products/ai_perfume_3.png', 'primary' => false],
    ];

    // 3. Assign to all products
    $products = Product::all();
    foreach ($products as $product) {
        foreach ($aiImages as $img) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $img['path'],
                'is_primary' => $img['primary'],
            ]);
        }
    }
});

echo "Successfully seeded multiple AI images for " . Product::count() . " products.\n";
