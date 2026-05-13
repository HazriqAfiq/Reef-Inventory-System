<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

// ── Root Redirect ───────────────────────────────────────────────────
Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->isReseller()) {
        return redirect()->route('reseller.dashboard');
    }

    abort(403, 'Unauthorized access.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Management
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('resellers', \App\Http\Controllers\Admin\ResellerController::class);
    
    
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('index');
        Route::get('/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('export');
        Route::get('/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('show');
        Route::get('/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('invoice');
        Route::patch('/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('update');
    });

    // Settings
    Route::get('/settings/{page?}', [\App\Http\Controllers\Admin\SettingsController::class, 'showPage'])->name('settings.page');
    Route::post('/settings/{page}', [\App\Http\Controllers\Admin\SettingsController::class, 'updatePage'])->name('settings.page.update');
    
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'exportPdf'])->name('reports.pdf');
});

Route::middleware(['auth', 'verified', 'role:reseller'])->prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/audit', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'auditPage'])->name('audit.index');
    Route::get('/reports', [\App\Http\Controllers\Reseller\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [\App\Http\Controllers\Reseller\ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::post('/dashboard/goal', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'updateGoal'])->name('dashboard.goal');
    Route::post('/dashboard/audit', [\App\Http\Controllers\Reseller\ResellerDashboardController::class, 'auditStock'])->name('dashboard.audit');
    Route::resource('orders', \App\Http\Controllers\Reseller\OrderController::class)->only(['index', 'show']);
    Route::get('restock', [\App\Http\Controllers\Reseller\OrderController::class, 'create'])->name('orders.create');
    Route::post('restock', [\App\Http\Controllers\Reseller\OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}/checkout', [\App\Http\Controllers\Reseller\OrderController::class, 'payment'])->name('orders.payment');
    Route::post('orders/{order}/callback', [\App\Http\Controllers\Reseller\OrderController::class, 'callback'])->name('orders.callback');
    Route::get('orders/{order}/invoice', [\App\Http\Controllers\Reseller\OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/stock', [\App\Http\Controllers\Reseller\StockController::class, 'index'])->name('stock.index');
    Route::get('products/{product:slug}', [\App\Http\Controllers\Reseller\OrderController::class, 'showProduct'])->name('products.show');
    Route::post('/cart/update', [\App\Http\Controllers\Reseller\OrderController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/clear', [\App\Http\Controllers\Reseller\OrderController::class, 'clearCart'])->name('cart.clear');

    // Address management
    Route::post('/addresses', [\App\Http\Controllers\ProfileController::class, 'storeAddress'])->name('addresses.store');
    Route::post('/addresses/{address}/default', [\App\Http\Controllers\ProfileController::class, 'setDefaultAddress'])->name('addresses.default');
    Route::delete('/addresses/{address}', [\App\Http\Controllers\ProfileController::class, 'destroyAddress'])->name('addresses.destroy');
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

// ── EasyParcel Webhooks ──────────────────────────────────────────────
Route::post('/webhooks/easyparcel', [\App\Http\Controllers\EasyParcelWebhookController::class, 'handleStatusUpdate'])->name('webhooks.easyparcel');

require __DIR__.'/auth.php';
