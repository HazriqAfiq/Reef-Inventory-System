<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class StorefrontController extends Controller
{
    /**
     * Storefront Homepage: Best Sellers & New Arrivals
     */
    public function index()
    {
        // 0. Settings
        $settings = $this->loadSettings();

        // 1. New Arrivals: Products released in the last 3 months
        $newArrivals = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->where('release_date', '>=', now()->subMonths(3))
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->latest('release_date')
            ->limit(4)
            ->get();

        // 2. Best Sellers: Top products by total quantity sold
        $bestSellers = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->orderByDesc('sales_sum_quantity')
            ->limit(4)
            ->get();

        // 3. Promotions: Products with active promotions
        $promotionalItems = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->onPromotion(auth()->user())
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->limit(4)
            ->get();

        return view('storefront.index', compact('newArrivals', 'bestSellers', 'promotionalItems', 'settings'));
    }

    /**
     * Shop / Collection Page: Filtering & Search
     */
    public function collection(Request $request)
    {
        $query = Product::active()->withSum('sales', 'quantity');

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtering by Category (via normalized categories table, filtering by slug)
        if ($category = $request->input('category')) {
            $slugs = explode(',', $category);

            // Automatically include unisex when men or women is selected
            if (in_array('men', $slugs) || in_array('woman', $slugs)) {
                $slugs[] = 'unisex';
            }
            $slugs = array_unique($slugs);

            $query->whereHas('category', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // Filtering by Type (via normalized product_types table, filtering by slug)
        if ($type = $request->input('type')) {
            $slugs = explode(',', $type);
            $query->whereHas('productType', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }

        // Filtering by Price Range
        if ($minPrice = $request->input('min_price')) {
            $query->where('retail_price', '>=', $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('retail_price', '<=', $maxPrice);
        }

        // Sorting
        $query->withSum('variants', 'stock')->orderByRaw('variants_sum_stock > 0 DESC');

        switch ($request->input('sort')) {
            case 'low-high':
                $query->orderBy('retail_price', 'asc');
                break;
            case 'high-low':
                $query->orderBy('retail_price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();
        $settings = $this->loadSettings();

        if ($request->ajax()) {
            return view('storefront.partials.products-grid', compact('products'))->render();
        }

        return view('storefront.collection', compact('products', 'settings'));
    }

    /**
     * Product Detail Page
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['images', 'category', 'productType', 'reviews.user', 'variants'])
            ->withSum('sales', 'quantity')
            ->firstOrFail();
        $userReview = auth()->check()
            ? $product->reviews->firstWhere('user_id', auth()->id())
            : null;

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->limit(4)
            ->get();

        return view('storefront.show', compact('product', 'relatedProducts', 'userReview'));
    }

    /**
     * New Arrivals Page
     */
    public function newArrivals(Request $request)
    {
        $products = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->where('release_date', '>=', now()->subMonths(3))
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->latest('release_date')
            ->get();

        if ($request->ajax()) {
            return view('storefront.partials.products-grid', compact('products'))->render();
        }

        $settings = $this->loadSettings();
        
        $pageTitle = 'New Arrivals';
        $pageSubtitle = 'Recently Unveiled';
        $bannerImage = $settings['new_arrivals_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }

    /**
     * Best Sellers Page
     */
    public function bestSellers(Request $request)
    {
        $products = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->orderByDesc('sales_sum_quantity')
            ->get();

        if ($request->ajax()) {
            return view('storefront.partials.products-grid', compact('products'))->render();
        }

        $settings = $this->loadSettings();

        $pageTitle = 'Best Sellers';
        $pageSubtitle = 'Our Most Celebrated Scents';
        $bannerImage = $settings['best_sellers_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }

    /**
     * Promotions Page
     */
    public function promotions(Request $request)
    {
        // Automatically hide page if no active promotions exist
        if (!Product::hasActivePromotions(auth()->user())) {
            return redirect()->route('storefront.index');
        }

        $products = Product::active()
            ->withSum('variants', 'stock')
            ->withSum('sales', 'quantity')
            ->onPromotion(auth()->user())
            ->orderByRaw('variants_sum_stock > 0 DESC')
            ->orderBy('retail_price', 'asc')
            ->get();

        if ($request->ajax()) {
            return view('storefront.partials.products-grid', compact('products'))->render();
        }

        $settings = $this->loadSettings();
        $pageTitle = 'Exclusive Promos';
        $pageSubtitle = 'Discover our latest promotional events and seasonal discounts.';
        $bannerImage = $settings['promotions_hero_image'] ?? null;

        return view('storefront.simple-collection', compact('products', 'settings', 'pageTitle', 'pageSubtitle', 'bannerImage'));
    }

    /**
     * Load key-value storefront settings safely.
     */
    protected function loadSettings()
    {
        if (! Schema::hasTable('settings')) {
            return collect();
        }

        return Setting::query()->pluck('value', 'key');
    }
}
