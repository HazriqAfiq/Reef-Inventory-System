<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

// ── Storefront (Guest Accessible) ───────────────────────────────────
Route::get('/', [StorefrontController::class, 'index'])->name('storefront.index');
Route::get('/collection', [StorefrontController::class, 'collection'])->name('storefront.collection');
Route::get('/product/{slug}', [StorefrontController::class, 'show'])->name('storefront.show');
Route::post('/product/{product}/review', [\App\Http\Controllers\ProductReviewController::class, 'store'])->name('product.review')->middleware('auth');
Route::delete('/product/{product}/review/{review}', [\App\Http\Controllers\ProductReviewController::class, 'destroy'])->name('product.review.destroy')->middleware('auth');
Route::get('/new-arrivals', [StorefrontController::class, 'newArrivals'])->name('storefront.newArrivals');
Route::get('/best-sellers', [StorefrontController::class, 'bestSellers'])->name('storefront.bestSellers');
Route::get('/promotions', [StorefrontController::class, 'promotions'])->name('storefront.promotions');
Route::get('/scent-finder', [App\Http\Controllers\Storefront\ScentFinderController::class, 'index'])->name('storefront.scent-finder');
Route::get('/scent-finder/results', [App\Http\Controllers\Storefront\ScentFinderController::class, 'results'])->name('storefront.scent-finder.results');


// ── Shopping Cart ────────────────────────────────────────────────────
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/{productId}/wishlist', [\App\Http\Controllers\CartController::class, 'moveToWishlist'])->name('cart.wishlist');
Route::post('/cart/selection/update', [\App\Http\Controllers\CartController::class, 'updateSelection'])->name('cart.selection.update');

// ── Checkout ─────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});


Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isReseller()) {
        return redirect()->route('reseller.dashboard');
    }

    // Default for Buyers: Redirect to Account Page
    return redirect()->route('account.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('resellers', \App\Http\Controllers\Admin\ResellerController::class);
    Route::get('/sales', [\App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/report', [\App\Http\Controllers\SaleController::class, 'report'])->name('sales.report');
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
    
    // Scanner & POS
    Route::get('/inventory/scan-in', [\App\Http\Controllers\Admin\InventoryScannerController::class, 'index'])->name('inventory.scan-in');
    Route::post('/inventory/scan-in', [\App\Http\Controllers\Admin\InventoryScannerController::class, 'restock']);
    Route::get('/sales/pos', [\App\Http\Controllers\Admin\POSController::class, 'create'])->name('sales.pos');
    Route::post('/sales/pos', [\App\Http\Controllers\Admin\POSController::class, 'store']);
    
    // API Route for admin scanning lookups
    Route::get('/api/scan/{sku}', [\App\Http\Controllers\ScannerController::class, 'lookup'])->name('api.scan');
    
    // Storefront Settings
    Route::get('/settings/{page?}', [\App\Http\Controllers\Admin\SettingsController::class, 'showPage'])->name('settings.page');
    Route::post('/settings/global-promotion', [\App\Http\Controllers\Admin\SettingsController::class, 'globalPromotion'])->name('settings.globalPromotion');
    Route::post('/settings/global-promotion/end', [\App\Http\Controllers\Admin\SettingsController::class, 'endGlobalSale'])->name('settings.endGlobalSale');
    Route::post('/settings/promotion/remove/{product}', [\App\Http\Controllers\Admin\SettingsController::class, 'removeProductPromotion'])->name('settings.removeProductPromotion');
    Route::get('/api/products/search', [\App\Http\Controllers\Admin\SettingsController::class, 'searchProducts'])->name('api.products.search');
    Route::post('/settings/{page}', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePage'])->name('settings.page.update');
    
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

Route::middleware(['auth', 'verified', 'role:reseller'])->prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/goal', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'updateGoal'])->name('dashboard.goal');
    Route::resource('sales', \App\Http\Controllers\SaleController::class)->only(['index', 'create', 'store']);
    Route::resource('orders', \App\Http\Controllers\Reseller\OrderController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('orders/{order}/payment', [\App\Http\Controllers\Reseller\OrderController::class, 'payment'])->name('orders.payment');
    Route::post('orders/{order}/callback', [\App\Http\Controllers\Reseller\OrderController::class, 'callback'])->name('orders.callback');
    Route::get('orders/{order}/invoice', [\App\Http\Controllers\Reseller\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/stock', [\App\Http\Controllers\Reseller\StockController::class, 'index'])->name('stock.index');
});

// ── Buyer Account ──────────────────────────────────────────────────
Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('account.index');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/addresses', [AccountController::class, 'storeAddress'])->name('account.addresses.store');
    Route::delete('/addresses/{address}', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');
    Route::get('/settings', [AccountController::class, 'settings'])->name('account.settings');
    Route::post('/orders/{order}/cancel', [AccountController::class, 'cancelOrder'])->name('account.orders.cancel');
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('account.wishlist');
    Route::post('/wishlist/toggle/{product}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications API (used by frontend polling)
    Route::prefix('notifications')->name('notifications.')->group(function () {
        // Line added to avoid confusion
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/read-all', [NotificationController::class, 'markAllRead'])->name('readAll');
        Route::post('/{notification}/read', [NotificationController::class, 'markRead'])->name('read');
    });
});

require __DIR__.'/auth.php';
