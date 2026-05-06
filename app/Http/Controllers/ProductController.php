<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductType;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the inventory list with search, filter, and pagination.
     */
    public function index(Request $request)
    {
        $query = Product::with(['variants'])
            ->withSum('sales', 'quantity')
            ->withSum('resellerStocks', 'quantity');

        // Search by name or SKU
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by stock level
        match ($request->input('stock')) {
            'out'    => $query->where('stock', 0),
            'low'    => $query->where('stock', '>', 0)->where('stock', '<', 50),
            'medium' => $query->where('stock', '>=', 50)->where('stock', '<=', 100),
            'high'   => $query->where('stock', '>', 100),
            default  => null,
        };

        // Filter by volume
        if ($volume = $request->input('volume')) {
            $query->where('volume_ml', $volume);
        }

        // Sort
        $sortMap = [
            'name'            => ['name', 'asc'],
            'retail_price'    => ['retail_price', 'desc'],
            'wholesale_price' => ['wholesale_price', 'desc'],
            'stock'           => ['stock', 'asc'],
            'volume'          => ['volume_ml', 'asc'],
        ];
        [$sortCol, $sortDir] = $sortMap[$request->input('sort', 'name')] ?? ['name', 'asc'];
        $query->orderBy($sortCol, $sortDir);

        $products = $query->paginate(10)->appends($request->all());

        if ($request->ajax() && !$request->header('X-SPA')) {
            return view('admin.products.partials.table', compact('products'))->render();
        }

        // Summary stats for header
        $totalProducts   = Product::count();
        $adminStock      = \App\Models\ProductVariant::sum('stock');
        $resellerStock   = \App\Models\ResellerStock::sum('quantity');
        $totalStock      = $adminStock + $resellerStock;
        $lowStockCount   = \App\Models\ProductVariant::where('stock', '>', 0)->where('stock', '<', 50)->count();
        $outOfStock      = \App\Models\ProductVariant::where('stock', 0)->count();

        // Available volume options for filter dropdown
        $volumes = Product::distinct()->orderBy('volume_ml')->pluck('volume_ml');

        return view('admin.products.index', compact(
            'products',
            'totalProducts',
            'totalStock',
            'lowStockCount',
            'outOfStock',
            'volumes',
            'adminStock',
            'resellerStock'
        ));
    }

    public function create()
    {
        $categories   = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('admin.products.create', compact('categories', 'productTypes'));
    }

    public function store(StoreProductRequest $request)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());
            
            // Auto-detect fragrance family if empty
            if (empty($product->fragrance_family)) {
                $detected = $this->detectFragranceFamily($product);
                if ($detected) {
                    $product->update(['fragrance_family' => $detected]);
                }
            }
            
            // Handle Variants
            if ($request->has('variants')) {
                foreach ($request->input('variants') as $variantData) {
                    $product->variants()->create([
                        'name' => $variantData['name'],
                        'sku' => $variantData['sku'] ?? $product->sku . '-' . $variantData['name'],
                        'retail_price' => $variantData['retail_price'],
                        'wholesale_price' => $variantData['wholesale_price'],
                        'stock' => $variantData['stock'],
                    ]);
                }

                // Update parent stock sum
                $product->update(['stock' => collect($request->input('variants'))->sum('stock')]);
            }

            // Handle Images
            if ($request->hasFile('images')) {
                $primaryIndex = (int) $request->input('primary_index', 0);
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === $primaryIndex,
                    ]);
                }
            }

            \App\Models\ActivityLog::log(
                'product_created',
                $product,
                "Created new product: {$product->name} with " . (is_array($request->variants) ? count($request->variants) : 0) . " variants",
                $request->all()
            );

            return redirect()->route('admin.products.index')->with('success', 'Product, variants, and images added successfully.');
        });
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories   = Category::orderBy('name')->get();
        $productTypes = ProductType::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories', 'productTypes'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $product) {
            $oldStock = $product->stock;
            $product->update($request->validated());

            // Auto-detect fragrance family if empty
            if (empty($product->fragrance_family)) {
                $detected = $this->detectFragranceFamily($product);
                if ($detected) {
                    $product->update(['fragrance_family' => $detected]);
                }
            }

            // Sync Variants
            if ($request->has('variants')) {
                $variantIds = [];
                foreach ($request->input('variants') as $variantData) {
                    $variant = $product->variants()->updateOrCreate(
                        ['id' => $variantData['id'] ?? null],
                        [
                            'name' => $variantData['name'],
                            'sku' => $variantData['sku'] ?? $product->sku . '-' . $variantData['name'],
                            'retail_price' => $variantData['retail_price'],
                            'wholesale_price' => $variantData['wholesale_price'],
                            'stock' => $variantData['stock'],
                        ]
                    );
                    $variantIds[] = $variant->id;
                }
                // Delete variants not in the request
                $product->variants()->whereNotIn('id', $variantIds)->delete();

                // Update parent product fallback fields (optional but good for legacy)
                if (!empty($request->input('variants'))) {
                    $first = $request->input('variants')[0];
                    $product->update([
                        'retail_price' => $first['retail_price'],
                        'wholesale_price' => $first['wholesale_price'],
                        'stock' => collect($request->input('variants'))->sum('stock'),
                    ]);
                }
            }

            // Handle Image Deletions
            if ($request->has('delete_images')) {
                foreach ($request->input('delete_images') as $imageId) {
                    $image = $product->images()->find($imageId);
                    if ($image) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Handle Primary Image Selection
            $primaryType = $request->input('primary_type');
            if ($primaryType === 'existing') {
                $primaryId = $request->input('primary_id');
                $product->images()->update(['is_primary' => false]);
                $product->images()->where('id', $primaryId)->update(['is_primary' => true]);
            }

            // Handle New Image Uploads
            if ($request->hasFile('images')) {
                // If primary was set to existing above, any new images will be non-primary
                // Unless primaryType is 'new'
                $primaryIndex = ($primaryType === 'new') ? (int) $request->input('primary_index', 0) : -1;
                
                if ($primaryType === 'new') {
                    $product->images()->update(['is_primary' => false]);
                }

                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $index === $primaryIndex,
                    ]);
                }
            }

            // Fallback: If no primary exists (all deleted), set the first available as primary
            if (!$product->images()->where('is_primary', true)->exists() && $product->images()->exists()) {
                $product->images()->first()->update(['is_primary' => true]);
            }

            $product->refresh();

            \App\Models\ActivityLog::log(
                'product_updated',
                $product,
                "Updated product details, variants, and images for {$product->name}",
                ['changes' => $request->all()]
            );

            // Fire inventory alerts (simplified check on total stock for now)
            $totalStock = $product->variants->sum('stock');
            if ($totalStock === 0 && $oldStock !== 0) {
                NotificationService::outOfStock($product);
            }

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        });
    }

    public function destroy(Product $product)
    {
        \App\Models\ActivityLog::log(
            'product_deleted',
            null,
            "Deleted product: {$product->name} (SKU: {$product->sku})",
            ['product_id' => $product->id, 'name' => $product->name, 'sku' => $product->sku]
        );
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    /**
     * Auto-detect the fragrance family of a product based on its olfactory notes.
     */
    protected function detectFragranceFamily(Product $product): ?string
    {
        $notesConfig = config('scent-notes.notes', []);
        $scores = [
            'fresh' => 0,
            'floral' => 0,
            'woody' => 0,
            'oriental' => 0,
            'gourmand' => 0,
        ];

        $textLayers = [
            'top_note' => ['text' => strtolower($product->top_note ?? ''), 'weight' => 1],
            'heart_note' => ['text' => strtolower($product->heart_note ?? ''), 'weight' => 2],
            'base_note' => ['text' => strtolower($product->base_note ?? ''), 'weight' => 3],
        ];

        foreach ($notesConfig as $noteKeyword => $meta) {
            $family = $meta['family'] ?? null;
            if (!$family || !array_key_exists($family, $scores)) {
                continue;
            }

            foreach ($textLayers as $layer => $info) {
                if (empty($info['text'])) {
                    continue;
                }
                if (str_contains($info['text'], $noteKeyword)) {
                    $scores[$family] += $info['weight'];
                }
            }
        }

        $bestFamily = null;
        $maxScore = 0;
        foreach ($scores as $family => $score) {
            if ($score > $maxScore) {
                $maxScore = $score;
                $bestFamily = $family;
            }
        }

        return $bestFamily;
    }
}
