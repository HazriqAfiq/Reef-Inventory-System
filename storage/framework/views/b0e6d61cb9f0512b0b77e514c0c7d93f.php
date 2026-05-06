<?php if(request()->ajax()): ?>
    <title><?php echo e(isset($title) ? $title . ' — ' : ''); ?>Laman Store · RPIMS</title>
    <main id="main-content">
        <?php if(session('success')): ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 animate-bounce">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-emerald-900 uppercase tracking-wider">Success</p>
                        <p class="text-xs text-emerald-700 mt-0.5 font-medium"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-rose-900 uppercase tracking-wider">Error</p>
                        <p class="text-xs text-rose-700 mt-0.5 font-medium"><?php echo e(session('error')); ?></p>
                    </div>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" 
                 class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-rose-900 uppercase tracking-wider">Validation Error</p>
                        <ul class="list-disc list-inside text-xs text-rose-700 mt-1 space-y-0.5 font-medium">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        <?php endif; ?>

        <?php echo e($slot); ?>

    </main>
<?php else: ?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(isset($title) ? $title . ' — ' : ''); ?>Laman Store · RPIMS</title>

    <!-- Inter Font (full weight range) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
        }


        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900">


<div id="sidebar-overlay"
     class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300 opacity-0 lg:hidden"
     onclick="closeSidebar()">
</div>

<div class="flex h-screen overflow-hidden">

    
    <aside id="sidebar"
           class="fixed lg:relative top-0 left-0 h-screen w-72 lg:w-64 bg-white border-r border-gray-200
                  flex flex-col shrink-0 overflow-hidden z-50 lg:z-20 group/sidebar
                  -translate-x-full lg:translate-x-0 transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]">

        <!-- Logo + Mobile Close -->
        <div class="h-16 lg:h-24 flex items-center justify-center px-5 lg:px-7 border-b border-gray-50 shrink-0 relative z-10">
            <a href="<?php echo e(Auth::check() && Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::check() ? route('reseller.dashboard') : '/')); ?>"
               class="flex items-center gap-3 transition-transform hover:scale-[1.02]">
                <?php
                    $logoPath = \App\Models\Setting::getValue('brand_logo');
                    $brandName = \App\Models\Setting::getValue('brand_name', 'Laman Store');
                ?>
                <?php if($logoPath && Storage::disk('public')->exists($logoPath)): ?>
                    <img src="<?php echo e(asset('storage/' . $logoPath)); ?>" 
                         alt="<?php echo e($brandName); ?>" 
                         class="max-h-10 w-auto object-contain">
                <?php else: ?>
                    <div class="w-9 h-9 rounded-xl bg-black shadow-lg shadow-black/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <div class="min-w-0">
                    <?php
                        $parts = explode(' ', $brandName, 2);
                        $part1 = $parts[0] ?? 'LAMAN';
                        $part2 = $parts[1] ?? 'STORE';
                    ?>
                    <p class="text-[14px] font-black text-gray-900 leading-none tracking-tight uppercase truncate"><?php echo e($part1); ?></p>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] leading-none mt-1.5 truncate"><?php echo e($part2); ?></p>
                </div>
            </a>
            <!-- Close button (mobile only) — absolute so it doesn't affect logo centering -->
            <button onclick="closeSidebar()" class="lg:hidden absolute right-4 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto pt-2 pb-6 px-3 lg:px-4 space-y-1 relative z-10 scrollbar-hide">

            <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->isAdmin()): ?>
                    <p class="px-3 pt-2 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Overview</p>

                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Operations</p>

                    <a href="<?php echo e(route('admin.sales.pos')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.sales.pos') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Counter Sales
                    </a>

                    <a href="<?php echo e(route('admin.inventory.scan-in')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.inventory.scan-in') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        Scan & Restock
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Management</p>

                    <a href="<?php echo e(route('admin.products.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Products
                    </a>

                    <a href="<?php echo e(route('admin.orders.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Wholesale Orders
                    </a>

                    <a href="<?php echo e(route('admin.settings.page', ['page' => 'promotion'])); ?>"
                       class="sidebar-link group <?php echo e(request()->is('admin/settings/promotion') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Promotions
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Sales & Analytics</p>

                    <a href="<?php echo e(route('admin.sales.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.sales.index') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Global Sales
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Partnerships</p>

                    <a href="<?php echo e(route('admin.resellers.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('admin.resellers.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Resellers
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Storefront UI</p>

                    <a href="<?php echo e(route('admin.settings.page', ['page' => 'brand'])); ?>"
                       class="sidebar-link group <?php echo e(request()->is('admin/settings/brand') || request()->is('admin/settings') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-2.066 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946 2.066 3.42 3.42 0 013.139 3.139 3.42 3.42 0 002.066 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-2.066 1.946 3.42 3.42 0 01-3.139 3.139 3.42 3.42 0 00-1.946 2.066 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-2.066 3.42 3.42 0 01-3.139-3.139 3.42 3.42 0 00-2.066-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 002.066-1.946 3.42 3.42 0 013.139-3.139z"/></svg>
                        Brand
                    </a>

                    <a href="<?php echo e(route('admin.settings.page', ['page' => 'layout'])); ?>"
                       class="sidebar-link group <?php echo e(request()->is('admin/settings/layout') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        Layout
                    </a>

                    <a href="<?php echo e(route('admin.settings.page', ['page' => 'experience'])); ?>"
                       class="sidebar-link group <?php echo e(request()->is('admin/settings/experience') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                        Experience
                    </a>

                    <a href="<?php echo e(route('admin.settings.page', ['page' => 'system'])); ?>"
                       class="sidebar-link group <?php echo e(request()->is('admin/settings/system') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        System
                    </a>


                <?php elseif(Auth::user()->isReseller()): ?>
                    <p class="px-3 pt-2 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Main</p>

                    <a href="<?php echo e(route('reseller.dashboard')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('reseller.dashboard') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">Inventory</p>

                    <a href="<?php echo e(route('reseller.stock.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('reseller.stock.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        My Stock
                    </a>

                    <a href="<?php echo e(route('reseller.orders.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('reseller.orders.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Restock / Orders
                    </a>

                    <p class="px-3 pt-6 pb-2 text-[10px] font-black text-gray-400 uppercase tracking-[0.15em]">System</p>

                    <a href="<?php echo e(route('reseller.sales.create')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('reseller.sales.create') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Record Sale
                    </a>

                    <a href="<?php echo e(route('reseller.sales.index')); ?>"
                       class="sidebar-link group <?php echo e(request()->routeIs('reseller.sales.index') ? 'active' : ''); ?>" onclick="closeSidebar()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        My Sales History
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <!-- User Profile Footer -->
        <?php if(auth()->guard()->check()): ?>
        <div class="border-t border-gray-100 p-3 lg:p-4 bg-white/50 backdrop-blur-sm shrink-0 relative z-10 transition-colors hover:bg-white/80">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-black flex items-center justify-center text-white font-black text-[11px] shrink-0 shadow-lg shadow-black/10 transition-transform hover:scale-105">
                    <?php echo e(strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-black text-gray-900 truncate tracking-tight"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-[9px] font-black text-gray-400 truncate uppercase tracking-[0.1em] mt-0.5"><?php echo e(Auth::user()->role); ?></p>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <a href="<?php echo e(route('profile.edit')); ?>"
                   class="flex-1 py-2 bg-white flex justify-center items-center rounded-lg text-gray-400 hover:text-black hover:border-black transition-all border border-gray-100 shadow-sm hover:shadow-md group/btn"
                   title="Profile Settings" onclick="closeSidebar()">
                    <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924-1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="flex-1">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full h-full py-2 bg-white flex justify-center items-center rounded-lg text-red-400 hover:text-white hover:bg-black transition-all border border-gray-100 shadow-sm hover:shadow-md group/logout" title="Sign Out">
                        <svg class="w-3.5 h-3.5 transition-transform group-hover/logout:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </aside>

    
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 min-w-0">

        
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 shrink-0 relative">
            <div class="flex items-center gap-3">
                
                <button id="sidebar-toggle"
                        onclick="openSidebar()"
                        class="lg:hidden w-9 h-9 flex items-center justify-center rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors -ml-1">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <?php if(isset($title)): ?>
                    <div class="w-1.5 h-1.5 rounded-full bg-black shadow-[0_0_6px_rgba(0,0,0,0.2)] hidden sm:block"></div>
                    <h1 class="text-xs sm:text-sm font-bold tracking-wider uppercase text-gray-900 truncate"><?php echo e($title); ?></h1>
                <?php endif; ?>
            </div>

            
            <a href="<?php echo e(Auth::check() && Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::check() ? route('reseller.dashboard') : '/')); ?>"
               class="lg:hidden absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex items-center gap-2">
                <?php
                    $logoPath = \App\Models\Setting::getValue('brand_logo');
                    $brandName = \App\Models\Setting::getValue('brand_name', 'Laman Store');
                ?>
                <?php if($logoPath && Storage::disk('public')->exists($logoPath)): ?>
                    <img src="<?php echo e(asset('storage/' . $logoPath)); ?>"
                         alt="<?php echo e($brandName); ?>"
                         class="h-8 w-auto object-contain drop-shadow-sm">
                <?php else: ?>
                    <div class="w-7 h-7 rounded-lg bg-black flex items-center justify-center shadow-lg shadow-black/10 shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                <?php endif; ?>
                <span class="text-[13px] font-black text-gray-900 tracking-tight uppercase truncate max-w-[120px]"><?php echo e($brandName); ?></span>
            </a>

            <div class="flex items-center gap-2 md:gap-4">

                
                
                
                <?php if(auth()->guard()->check()): ?>
                <div
                    id="notif-root"
                    class="relative"
                    x-data="notificationCenter()"
                    x-init="init()"
                >
                    
                    <button
                        id="notif-bell-btn"
                        @click="toggle()"
                        class="relative w-9 h-9 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 hover:text-black hover:bg-gray-100 hover:border-black transition-all duration-200 focus:outline-none"
                        aria-label="Notifications"
                    >
                        
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                   6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
                                   6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3
                                   0 11-6 0v-1m6 0H9" />
                        </svg>

                        
                        <span
                            x-show="unreadCount > 0"
                            x-cloak
                            x-text="unreadCount > 99 ? '99+' : unreadCount"
                            class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full
                                   bg-red-500 text-white text-[10px] font-black flex items-center
                                   justify-center border-2 border-white shadow-sm
                                   animate-pulse"
                        ></span>
                    </button>

                    
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        @click.outside="open = false"
                        id="notif-panel"
                        class="absolute right-0 top-[calc(100%+10px)] w-[380px] max-h-[520px]
                               bg-white rounded-2xl shadow-[0_8px_40px_rgba(0,0,0,0.12)]
                               border border-gray-100 z-[999] flex flex-col overflow-hidden"
                    >
                        
                        <div class="flex items-center justify-between px-4 py-3.5 border-b border-gray-100 shrink-0">
                            <div class="flex items-center gap-2">
                                <span class="text-[13px] font-black text-gray-900 tracking-tight">Notifications</span>
                                <span
                                    x-show="unreadCount > 0"
                                    x-cloak
                                    x-text="unreadCount"
                                    class="text-[10px] font-black bg-black text-white rounded-full px-2 py-0.5"
                                ></span>
                            </div>
                            <button
                                @click="markAllRead()"
                                x-show="unreadCount > 0"
                                x-cloak
                                class="text-[11px] font-black uppercase tracking-widest text-black hover:opacity-70 transition-colors px-2 py-1 rounded-md"
                            >Mark all read</button>
                        </div>

                        
                        <div class="overflow-y-auto flex-1 divide-y divide-gray-50" id="notif-list">
                            
                            <div x-show="notifications.length === 0" class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                </div>
                                <p class="text-[12px] font-bold text-gray-400">You're all caught up!</p>
                                <p class="text-[11px] text-gray-300 mt-1">No notifications yet.</p>
                            </div>

                            
                            <template x-for="notif in notifications" :key="notif.id">
                                <div
                                    @click="handleClick(notif)"
                                    class="flex items-start gap-3 px-4 py-3.5 cursor-pointer transition-colors duration-150"
                                    :class="notif.is_read ? 'bg-white hover:bg-gray-50' : 'bg-gray-50 hover:bg-gray-100'"
                                >
                                    
                                    <div
                                        class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                                        :class="iconBg(notif.type)"
                                    >
                                        <span x-html="iconSvg(notif.type)" class="w-4 h-4 block"></span>
                                    </div>

                                    
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <p
                                                class="text-[12px] font-bold leading-snug truncate"
                                                :class="notif.is_read ? 'text-gray-600' : 'text-gray-900'"
                                                x-text="notif.title"
                                            ></p>
                                            <span class="text-[10px] text-gray-400 shrink-0 mt-0.5 font-medium" x-text="timeAgo(notif.created_at)"></span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 leading-relaxed mt-0.5 line-clamp-2" x-text="notif.message"></p>
                                    </div>

                                    
                                    <div x-show="!notif.is_read" class="w-2 h-2 rounded-full bg-black shrink-0 mt-2"></div>
                                </div>
                            </template>
                        </div>

                        
                        <div class="px-4 py-2.5 border-t border-gray-100 shrink-0">
                            <p class="text-[10px] text-gray-400 text-center font-medium">Refreshes every 30 seconds · Last 20 notifications</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>

                
                <div class="hidden sm:flex items-center gap-2 text-gray-500">
                    <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[12px] font-black text-gray-900 tracking-widest uppercase"><?php echo e(now()->format('d M Y')); ?></span>
                </div>
            </div>
        </header>

        
        <main id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">
            <?php if(session('success')): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                     class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 animate-bounce">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-emerald-900 uppercase tracking-wider">Success</p>
                            <p class="text-xs text-emerald-700 mt-0.5 font-medium"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-rose-900 uppercase tracking-wider">Error</p>
                            <p class="text-xs text-rose-700 mt-0.5 font-medium"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)" 
                     class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-center justify-between gap-3 animate-fade-in-up shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-rose-900 uppercase tracking-wider">Validation Error</p>
                            <ul class="list-disc list-inside text-xs text-rose-700 mt-1 space-y-0.5 font-medium">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            <?php endif; ?>

            <?php echo e($slot); ?>

        </main>
    </div>

</div>


<script>
document.addEventListener('click', async (e) => {
    const link = e.target.closest('a');
    if (!link) return;
    
    // Only handle internal admin/reseller links, skip logout/profile/external
    const url = new URL(link.href, window.location.origin);
    const isInternal = url.origin === window.location.origin;
    const isDashboardLink = url.pathname.includes('/admin') || url.pathname.includes('/reseller');
    const isLogout = url.pathname.includes('/logout');
    
    // Skip if it's not internal, not an admin/reseller link, or is logout
    if (!isInternal || !isDashboardLink || isLogout || e.ctrlKey || e.metaKey) return;

    e.preventDefault();
    navigateTo(link.href);
});

window.addEventListener('popstate', () => {
    navigateTo(window.location.href, false);
});

document.addEventListener('submit', async (e) => {
    const form = e.target;
    // Handle both /admin and /reseller forms
    const isDashboardForm = form.action.includes('/admin') || form.action.includes('/reseller');
    if (!isDashboardForm || form.method.toLowerCase() !== 'post') return;
    
    if (form.action.includes('/logout')) return;

    e.preventDefault();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn ? submitBtn.innerHTML : '';
    const mainContent = document.getElementById('main-content');

    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
    }

    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'X-SPA': 'true'
            }
        });

        if (response.redirected) {
            const html = await response.text();
            
            if (html.includes('<main')) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                mainContent.innerHTML = doc.querySelector('main').innerHTML;
                const newTitle = doc.querySelector('title');
                if (newTitle) document.title = newTitle.innerText;
            } else {
                mainContent.innerHTML = html;
            }

            await executeScripts(mainContent);
            window.history.pushState({}, '', response.url);
            updateSidebarActive(response.url);
            mainContent.scrollTop = 0;
            return;
        }

        const html = await response.text();
        
        if (html.includes('<main')) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            mainContent.innerHTML = doc.querySelector('main').innerHTML;
            // Update title if needed
            const newTitle = doc.querySelector('title');
            if (newTitle) document.title = newTitle.innerText;
        } else {
            mainContent.innerHTML = html;
        }

        await executeScripts(mainContent);
        
    } catch (error) {
        console.error('Form submission failed:', error);
        form.submit(); // Fallback
    } finally {
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    }
});

async function navigateTo(url, push = true, resetScroll = true) {
    const mainContent = document.getElementById('main-content');
    
    // Create or get progress bar
    let progressBar = document.getElementById('nav-progress');
    if (!progressBar) {
        progressBar = document.createElement('div');
        progressBar.id = 'nav-progress';
        progressBar.className = 'fixed top-0 left-0 h-0.5 bg-black z-[100] transition-all duration-300 ease-out';
        progressBar.style.width = '0%';
        document.body.appendChild(progressBar);
    }
    
    setTimeout(() => progressBar.style.width = '30%', 0);
    mainContent.style.opacity = '0.5';
    
    try {
        const response = await fetch(url, {
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'X-SPA': 'true'
            }
        });
        
        progressBar.style.width = '70%';
        if (!response.ok) throw new Error('Network response was not ok');
        
        const html = await response.text();
        
        if (html.includes('<main')) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            mainContent.innerHTML = doc.querySelector('main').innerHTML;
            const newTitle = doc.querySelector('title');
            if (newTitle) document.title = newTitle.innerText;
            
            updateSidebarActive(url);
        } else {
            mainContent.innerHTML = html;
        }
        
        await executeScripts(mainContent);

        if (push) window.history.pushState({}, '', url);
        if (resetScroll) mainContent.scrollTop = 0;
        
        progressBar.style.width = '100%';
        
    } catch (error) {
        console.error('Navigation failed:', error);
        if (push) window.location.href = url;
    } finally {
        mainContent.style.opacity = '1';
        setTimeout(() => {
            if (progressBar) progressBar.style.width = '0%';
        }, 300);
    }
}

async function executeScripts(container) {
    // Destroy any existing Chart.js instances to prevent "Canvas is already in use" errors
    if (typeof Chart !== 'undefined' && Chart.instances) {
        Object.values(Chart.instances).forEach(c => { try { c.destroy(); } catch(e) {} });
    }

    // Clean up previously injected SPA scripts from body
    document.querySelectorAll('script[data-spa-injected]').forEach(s => s.remove());

    const scripts = Array.from(container.querySelectorAll('script'));
    for (const oldScript of scripts) {
        await new Promise((resolve) => {
            const newScript = document.createElement('script');
            newScript.setAttribute('data-spa-injected', 'true');
            
            // Copy attributes
            Array.from(oldScript.attributes).forEach(attr => {
                newScript.setAttribute(attr.name, attr.value);
            });
            
            if (oldScript.src) {
                // External script: skip if already loaded globally
                const alreadyLoaded = document.querySelector(`head script[src="${oldScript.src}"]`);
                if (alreadyLoaded) { oldScript.remove(); resolve(); return; }
                newScript.onload = resolve;
                newScript.onerror = resolve;
                oldScript.remove();
                document.head.appendChild(newScript);
            } else {
                // Inline script: wrap in IIFE to avoid const/let redeclaration errors
                newScript.textContent = `(function(){${oldScript.textContent}})();`;
                oldScript.remove();
                document.body.appendChild(newScript);
                requestAnimationFrame(() => setTimeout(resolve, 0));
            }
        });
    }
}

function updateSidebarActive(currentUrl) {
    const path = new URL(currentUrl, window.location.origin).pathname;
    
    // Handle main links
    document.querySelectorAll('.sidebar-link').forEach(link => {
        if (link.tagName === 'A') {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            link.classList.toggle('active', linkPath === path);
        }
    });

    // Handle sub-links
    document.querySelectorAll('nav a:not(.sidebar-link)').forEach(link => {
        const linkPath = new URL(link.href, window.location.origin).pathname;
        if (linkPath === path) {
            link.classList.replace('text-gray-400', 'text-black');
            link.classList.add('font-black');
        } else {
            link.classList.replace('text-black', 'text-gray-400');
            link.classList.remove('font-black');
        }
    });
}
</script>


<script>
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden', 'opacity-0');
        overlay.classList.add('opacity-100');
        document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('opacity-0');
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.classList.remove('opacity-100');
        }, 300);
        document.body.classList.remove('overflow-hidden');
    }

    // Close sidebar on window resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) closeSidebar();
    });
</script>


<?php if(auth()->guard()->check()): ?>
<script>
function notificationCenter() {
    return {
        open: false,
        notifications: [],
        unreadCount: 0,
        pollTimer: null,

        init() {
            this.fetchNotifications();
            // Poll every 30 seconds
            this.pollTimer = setInterval(() => this.fetchNotifications(), 30000);
        },

        toggle() {
            this.open = !this.open;
        },

        async fetchNotifications() {
            try {
                const resp = await fetch('<?php echo e(route('notifications.index')); ?>', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!resp.ok) return;
                const data = await resp.json();
                this.notifications = data.notifications;
                this.unreadCount   = data.unread_count;
            } catch (e) {
                // silently fail — network may be temporarily unavailable
            }
        },

        async markRead(notif) {
            if (notif.is_read) return;
            try {
                await fetch(`/notifications/${notif.id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                notif.is_read = true;
                this.unreadCount = Math.max(0, this.unreadCount - 1);
            } catch (e) {}
        },

        async markAllRead() {
            try {
                await fetch('<?php echo e(route('notifications.readAll')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
            } catch (e) {}
        },

        handleClick(notif) {
            this.markRead(notif);
            const url = notif.data && notif.data.action_url;
            if (url) {
                window.location.href = url;
            }
        },

        timeAgo(isoString) {
            const now  = new Date();
            const date = new Date(isoString);
            const diff = Math.floor((now - date) / 1000);
            if (diff < 60)            return 'Just now';
            if (diff < 3600)          return Math.floor(diff / 60) + 'm ago';
            if (diff < 86400)         return Math.floor(diff / 3600) + 'h ago';
            if (diff < 86400 * 7)     return Math.floor(diff / 86400) + 'd ago';
            return date.toLocaleDateString('en-MY', { day: 'numeric', month: 'short' });
        },

        iconBg(type) {
            return 'bg-black text-white shadow-lg shadow-black/10';
        },

        iconSvg(type) {
            const icons = {
                inventory_low: `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
                inventory_out: `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>`,
                new_sale:      `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                new_order:     `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>`,
                order_approved:`<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
                new_reseller:  `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>`,
            };
            return icons[type] || `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
        },
    };
}
</script>
<?php endif; ?>

</body>
</html>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/layouts/app.blade.php ENDPATH**/ ?>