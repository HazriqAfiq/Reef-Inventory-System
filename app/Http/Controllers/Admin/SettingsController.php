<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a specific settings page.
     */
    public function showPage($page = 'brand')
    {
        $pageGroups = [
            'brand' => [
                'global' => 'Store Identity', 
                'announcement' => 'Announcement Bar',
                'contact' => 'Contact Information',
                'social' => 'Social Media',
                'branding' => 'Branding', 
                'philosophy' => 'Our Philosophy'
            ],
            'layout' => [
                'homepage' => 'Homepage', 
                'collection' => 'Collection', 
                'new_arrivals' => 'New Arrivals', 
                'best_sellers' => 'Best Sellers',
                'promotion_layout' => 'Promotions'
            ],
            'promotion' => [
                'promotions' => 'Promotions Configuration'
            ],
            'experience' => [
                'engagement' => 'Customer Engagement', 
                'scent_finder' => 'Scent Finder Discovery'
            ],
            'system' => [
                'auth' => 'Authentication'
            ]
        ];
        
        if (!array_key_exists($page, $pageGroups)) {
            return redirect()->route('admin.settings.page', 'brand');
        }

        $sections = $pageGroups[$page];
        $settings = Setting::whereIn('group', array_keys($sections))->get();

        $viewPath = ($page === 'promotion') ? 'admin.settings.promotion' : 'admin.settings.page';

        $categories = collect();
        $totalActiveProducts = 0;
        $activePromosCount = 0;
        $scheduledPromosCount = 0;
        $totalPromoRevenue = 0;
        $productsOnPromotion = collect();

        if ($page === 'promotion') {
            $categories = \App\Models\Category::orderBy('name')->get();
            $totalActiveProducts = \App\Models\Product::active()->count();
            
            // Calculate Active Promos
            $activePromosCount = \App\Models\Product::whereNotNull('promotion_type')
                ->get()
                ->filter(function ($product) {
                    return $product->isPromotionActive();
                })
                ->count();

            // Calculate Scheduled Promos
            $scheduledPromosCount = \App\Models\Product::whereNotNull('promotion_type')
                ->where('promotion_starts_at', '>', now())
                ->count();

            // Total Global Sales Revenue
            $totalPromoRevenue = \App\Models\Order::where('status', 'paid')
                ->where(function($q) {
                    $q->whereNull('user_id')
                      ->orWhereHas('user', function($u) { $u->where('role', \App\Models\User::ROLE_BUYER); });
                })
                ->sum('total_price');

            // Products currently on promotion
            $productsOnPromotion = \App\Models\Product::whereNotNull('promotion_type')
                ->with('primaryImage')
                ->orderBy('name')
                ->get();
        }

        $title = ucfirst($page) . ' Settings';

        return view($viewPath, compact('title', 'settings', 'page', 'sections', 'categories', 'totalActiveProducts', 'activePromosCount', 'scheduledPromosCount', 'totalPromoRevenue', 'productsOnPromotion'));
    }

    /**
     * Update storefront settings for a specific page.
     */
    public function updatePage(Request $request, $page)
    {
        $data = $request->except('_token');

        $pageGroups = [
            'brand' => ['global', 'branding', 'appearance'],
            'layout' => ['homepage', 'collection', 'new_arrivals', 'best_sellers'],
            'promotion' => ['marketing', 'promotions'],
            'experience' => ['engagement', 'scent_finder'],
            'system' => ['auth']
        ];
        
        if (!array_key_exists($page, $pageGroups)) {
            return redirect()->back()->with('error', 'Invalid settings group.');
        }

        $groups = $pageGroups[$page];

        // Note: Checkbox boolean fields don't send anything if unchecked. 
        // Iterate through all boolean settings in this group to address unchecked ones.
        $groupSettings = Setting::whereIn('group', $groups)->get();

        foreach ($groupSettings as $setting) {
            if ($setting->type === 'boolean') {
                $setting->update(['value' => $request->has($setting->key) ? '1' : '0']);
            }
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting || $setting->type === 'boolean') continue; // Booleans handled above

            // Handle Image Upload
            if ($setting->type === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Determine folder based on key
                $folder = 'hero';
                if (str_contains($key, 'logo')) $folder = 'branding';
                if (str_contains($key, 'sign_in') || str_contains($key, 'sign_up')) $folder = 'auth';
                
                $path = $file->storeAs($folder, $filename, 'public');
                $dbPath = $folder . '/' . $filename;
                
                // Delete old image if it exists and is not the original protected default
                $protectedDefaults = ['hero/hero_cinematic.png', 'branding/logo.png'];
                if ($setting->value && !in_array($setting->value, $protectedDefaults)) {
                    if (Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                }

                $setting->update(['value' => $dbPath]);
                continue;
            }

            // Handle Text/TextArea
            if (!is_null($value)) {
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', ucfirst(str_replace('_', ' ', $page)) . ' settings updated successfully.');
    }

    /**
     * Set a global promotion across products based on scope (all, category, or individual).
     */
    public function globalPromotion(Request $request)
    {
        $request->validate([
            'promotion_type' => 'required|in:discount_percent,bogo',
            'discount_percentage' => 'nullable|required_if:promotion_type,discount_percent|integer|min:1|max:100',
            'promotion_badge' => 'nullable|string|max:50',
            'promotion_starts_at' => 'nullable|date',
            'promotion_ends_at' => 'nullable|date|after_or_equal:promotion_starts_at',
            'target_scope' => 'required|in:all,category,individual',
            'target_category' => 'nullable|required_if:target_scope,category|exists:categories,id',
            'target_products' => 'nullable|required_if:target_scope,individual|array',
            'target_products.*' => 'integer|exists:products,id',
            'promotion_min_qty' => 'nullable|integer|min:1',
            'promotion_target' => 'nullable|in:all,direct,reseller',
            'promotion_badge_color' => 'nullable|string',
        ]);

        $query = Product::query();
        $scope = $request->input('target_scope', 'all');
        
        if ($scope === 'category' && $request->filled('target_category')) {
            $query->where('category_id', $request->target_category);
        } elseif ($scope === 'individual' && $request->filled('target_products')) {
            $query->whereIn('id', $request->target_products);
        }

        $affectedCount = $query->count();

        $query->update([
            'promotion_type' => $request->promotion_type,
            'promotion_value' => $request->promotion_type === 'discount_percent' ? $request->discount_percentage : null,
            'promotion_badge' => $request->promotion_badge ?? ($request->promotion_type === 'bogo' ? 'BUY 1 GET 1' : 'PROMO'),
            'promotion_starts_at' => $request->promotion_starts_at,
            'promotion_ends_at' => $request->promotion_ends_at,
            'promotion_min_qty' => $request->promotion_min_qty ?? 1,
            'promotion_min_amount' => 0,
            'promotion_target' => $request->promotion_target ?? 'all',
            'promotion_badge_color' => 'bg-yellow-500',
        ]);

        if ($scope === 'all') {
            Setting::updateOrCreate(['key' => 'is_global_sale_active'], ['value' => '1']);
            $promoDesc = $request->promotion_type === 'bogo' ? 'Buy 1 Free 1' : $request->discount_percentage . '% off';
            Setting::updateOrCreate(['key' => 'global_sale_description'], ['value' => $promoDesc]);
        }

        $promoDesc = $request->promotion_type === 'bogo' ? 'Buy 1 Free 1' : $request->discount_percentage . '%';
        $message = "Promotion ({$promoDesc}) applied to {$affectedCount} product(s).";

        return redirect()->back()->with('success', $message);
    }

    public function endGlobalSale(Request $request)
    {
        Product::query()->update([
            'promotion_type' => null,
            'promotion_value' => null,
            'promotion_badge' => null,
            'promotion_starts_at' => null,
            'promotion_ends_at' => null,
            'promotion_min_qty' => 1,
            'promotion_min_amount' => 0,
            'promotion_target' => 'all',
            'promotion_badge_color' => 'bg-yellow-500',
        ]);

        Setting::updateOrCreate(['key' => 'is_global_sale_active'], ['value' => '0']);
        Setting::updateOrCreate(['key' => 'global_sale_description'], ['value' => '']);

        return redirect()->back()->with('success', 'All active promotions have been safely terminated.');
    }

    /**
     * Remove promotion from a single product.
     */
    public function removeProductPromotion(Product $product)
    {
        $product->update([
            'promotion_type' => null,
            'promotion_value' => null,
            'promotion_badge' => null,
            'promotion_starts_at' => null,
            'promotion_ends_at' => null,
            'promotion_min_qty' => 1,
            'promotion_min_amount' => 0,
            'promotion_target' => 'all',
            'promotion_badge_color' => 'bg-yellow-500',
        ]);

        return redirect()->back()->with('success', "Promotion removed from {$product->name}.");
    }

    /**
     * Search products for the promotion product picker (JSON API).
     */
    public function searchProducts(Request $request)
    {
        $query = $request->input('q', '');
        
        $productsQuery = Product::query()->where('is_active', true);

        if (!empty($query)) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            });
        }
        
        $products = $productsQuery->select('id', 'name', 'sku')
            ->orderBy('name')
            ->limit(100) // Increase limit for "Browse All"
            ->get();

        return response()->json($products);
    }
}
