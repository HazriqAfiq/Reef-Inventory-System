<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reports & Analytics']); ?>
    <div x-data="{ activeTab: 'sales' }">
        <!-- Page Header & Export Actions -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4 print:hidden">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Reports Live</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Reports & Analytics</h1>
                <p class="text-xs text-gray-400 mt-1">Deep-dive performance logs, product traction, and reseller engagement matrices.</p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <a href="<?php echo e(route('admin.reports.pdf')); ?>" 
                   data-no-spa
                   download
                   class="inline-flex items-center gap-2 px-5 py-3 bg-black hover:bg-gray-800 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Generate PDF Report</span>
                </a>
            </div>
        </div>

        <!-- Custom Document Header for Physical Prints -->
        <div class="hidden print:block mb-8 border-b-2 border-black pb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-black uppercase tracking-tight text-gray-900">REEF STORE</h1>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Wholesale Inventory & Sales Report</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">Generated: <?php echo e(now()->format('d M Y - H:i:s')); ?></p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-black uppercase tracking-widest bg-black text-white px-3 py-1.5 rounded">CONFIDENTIAL</span>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs (Interactive Segment Control) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 print:hidden">
            <div class="inline-flex bg-gray-100 p-1 rounded-xl shadow-inner shrink-0">
                <button @click="activeTab = 'sales'" :class="activeTab === 'sales' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150 focus:outline-none">
                    Sales & Revenue
                </button>
                <button @click="activeTab = 'fragrances'" :class="activeTab === 'fragrances' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150 focus:outline-none">
                    Fragrances
                </button>
                <button @click="activeTab = 'resellers'" :class="activeTab === 'resellers' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150 focus:outline-none">
                    Resellers
                </button>
                <button @click="activeTab = 'inventory'" :class="activeTab === 'inventory' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150 focus:outline-none flex items-center gap-1.5">
                    Inventory Alerts
                    <?php if($outOfStock->count() > 0 || $lowStock->count() > 0): ?>
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                    <?php endif; ?>
                </button>
            </div>
        </div>

        <!-- TAB CONTENT WORKSPACE -->
        <div class="space-y-8">
            
            <!-- ── TAB 1: SALES & PERFORMANCE ── -->
            <div x-show="activeTab === 'sales'" x-cloak class="space-y-8 print:block">
                <!-- KPI Performance Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <!-- Card 1: Total Sales Revenue -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Sales Revenue</span>
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($totalPaidRevenue, 2)); ?></h3>
                        </div>
                        <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 leading-none">Accumulated paid sales orders</p>
                    </div>

                    <!-- Card 2: Average Order Value -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Average Order Value</span>
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($averageOrderValue, 2)); ?></h3>
                        </div>
                        <p class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider mt-2 leading-none">Mean checkout cart value</p>
                    </div>

                    <!-- Card 3: Monthly Velocity -->
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monthly Velocity</span>
                                <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($currentMonthRevenue, 2)); ?></h3>
                        </div>
                        <p class="text-[9px] text-rose-600 font-bold uppercase tracking-wider mt-2 leading-none">Current cycle (<?php echo e($currentMonthOrders); ?> orders)</p>
                    </div>
                </div>

                <!-- Order Status Matrix Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                Wholesale Operational Matrix
                            </h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Distribution breakdown of all system order pipelines</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Bracket</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Active Pipelines</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Value Weighted</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                                <?php $__currentLoopData = $orderStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <?php
                                                $statusColors = [
                                                    'pending'    => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'paid'       => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    'shipped'    => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                                    'delivered'  => 'bg-teal-50 text-teal-600 border-teal-100',
                                                    'cancelled'  => 'bg-gray-50 text-gray-500 border-gray-100',
                                                ];
                                                $badgeStyle = $statusColors[strtolower($status)] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                            ?>
                                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border <?php echo e($badgeStyle); ?>">
                                                <?php echo e($status); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums"><?php echo e($data['count']); ?></td>
                                        <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">RM<?php echo e(number_format($data['total'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ── TAB 2: FRAGRANCE LEADERBOARD ── -->
            <div x-show="activeTab === 'fragrances'" x-cloak class="space-y-8 print:block">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                                Top Selling Perfume Profiles
                            </h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Ranked by physical unit volumes sold in paid orders</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Perfume SKU / Name</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Stock Available</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Units Sold</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Revenue Generated</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Market Share</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $bestSellingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <span class="text-[10px] font-black text-gray-400">#<?php echo e($index + 1); ?></span>
                                                <div>
                                                    <div class="font-bold text-gray-900"><?php echo e($prod->name); ?></div>
                                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5 font-mono"><?php echo e($prod->sku); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <?php if($prod->stock == 0): ?>
                                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-rose-50 text-rose-600 border-rose-100">Out of Stock</span>
                                            <?php elseif($prod->stock < 50): ?>
                                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-amber-50 text-amber-600 border-amber-100 font-mono"><?php echo e($prod->stock); ?> left</span>
                                            <?php else: ?>
                                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-emerald-50 text-emerald-600 border-emerald-100 font-mono"><?php echo e($prod->stock); ?> units</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums"><?php echo e($prod->total_qty_sold ?? 0); ?></td>
                                        <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">RM<?php echo e(number_format($prod->total_revenue ?? 0, 2)); ?></td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <div class="w-16 bg-gray-100 rounded h-1.5 overflow-hidden print:hidden border border-gray-150">
                                                    <div class="bg-black h-full" style="width: <?php echo e($prod->revenue_share); ?>%"></div>
                                                </div>
                                                <span class="font-bold text-gray-900 text-[10px] font-mono"><?php echo e(number_format($prod->revenue_share, 1)); ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-400">No wholesale product sales cataloged yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ── TAB 3: RESELLER LEDGER ── -->
            <div x-show="activeTab === 'resellers'" x-cloak class="space-y-8 print:block">
                <!-- Resellers Ranking -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                                Reseller Engagement Ledger
                            </h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Resellers ranked by total purchase spending volumes</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Reseller Details</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Wholesale Orders</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Target Goal</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Procured Spend</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $topResellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900"><?php echo e($reseller->name); ?></div>
                                            <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5 font-mono truncate max-w-[200px]"><?php echo e($reseller->email); ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums"><?php echo e($reseller->orders_count); ?></td>
                                        <td class="px-6 py-4 text-right">
                                            <?php if($reseller->monthly_goal): ?>
                                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-gray-50 text-gray-600 border-gray-100 font-mono"><?php echo e($reseller->monthly_goal); ?> Units</span>
                                            <?php else: ?>
                                                <span class="text-gray-400 text-[10px]">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">RM<?php echo e(number_format($reseller->total_spend ?? 0, 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">No active reseller partners registered.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Dormant Resellers Matrix (Last 60 Days Inactive) -->
                <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-rose-100 bg-rose-50/10 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-rose-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                                Inactive / Dormant Partners (60 Days)
                            </h2>
                            <p class="text-[10px] text-rose-500 uppercase tracking-wider mt-0.5">Partners who have not placed procurement orders in over 2 months</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-rose-50/50 border-b border-rose-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-rose-400 uppercase tracking-widest">Reseller Name</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-rose-400 uppercase tracking-widest text-center">Dormant Period</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-rose-400 uppercase tracking-widest text-right">Last Purchase Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-100 text-xs font-medium text-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $dormantResellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-6 py-4 font-bold text-gray-900"><?php echo e($reseller->name); ?></td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-rose-50 text-rose-600 border-rose-100">
                                                <?php if($reseller->last_order_date): ?>
                                                    <?php echo e(now()->diffInDays(\Carbon\Carbon::parse($reseller->last_order_date))); ?> days inactive
                                                <?php else: ?>
                                                    All-time
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-gray-500 font-mono">
                                            <?php echo e($reseller->last_order_date ? \Carbon\Carbon::parse($reseller->last_order_date)->format('d M Y') : 'Never'); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-emerald-600 font-bold bg-emerald-50/10 uppercase tracking-widest">No dormant resellers found! All partners are active.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ── TAB 4: INVENTORY ALERTS ── -->
            <div x-show="activeTab === 'inventory'" x-cloak class="space-y-8 print:block">
                <!-- Out of Stock Warnings -->
                <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-rose-100 bg-rose-50/10 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-rose-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-pulse"></span>
                                Critically Out of Stock (0 units)
                            </h2>
                            <p class="text-[10px] text-rose-500 uppercase tracking-wider mt-0.5">Wholesale catalog items requiring immediate inventory restock</p>
                        </div>
                        <span class="text-[9px] font-black text-rose-600 bg-rose-50 border border-rose-100/50 px-2.5 py-1 rounded-lg uppercase tracking-widest font-mono"><?php echo e($outOfStock->count()); ?> SKUs</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-rose-50/50 border-b border-rose-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-rose-400 uppercase tracking-widest">SKU / Product Profile</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-rose-400 uppercase tracking-widest text-right">Action Needed</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-100 text-xs font-medium text-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $outOfStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-rose-50/20 transition-colors">
                                        <td class="px-6 py-4 text-gray-900">
                                            <span class="font-mono text-rose-500 font-black mr-2"><?php echo e($item->sku); ?></span> <span class="font-bold"><?php echo e($item->name); ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="<?php echo e(route('admin.products.index')); ?>" class="text-[10px] font-black uppercase tracking-wider text-black hover:opacity-75 transition-opacity px-2.5 py-1.5 bg-white border border-gray-150 rounded-lg shadow-sm">Replenish Stock</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="2" class="px-6 py-10 text-center text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50/5">All products are healthy and in stock.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Low Stock Warnings -->
                <div class="bg-white rounded-2xl border border-amber-100 shadow-sm overflow-hidden flex flex-col mb-10">
                    <div class="px-6 py-4 border-b border-amber-100 bg-amber-50/10 shrink-0 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-amber-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Low Stock Alert Area (&lt; 50 units)
                            </h2>
                            <p class="text-[10px] text-amber-600 uppercase tracking-wider mt-0.5">Wholesale catalog items matching warning replenishment levels</p>
                        </div>
                        <span class="text-[9px] font-black text-amber-600 bg-amber-50 border border-amber-100/50 px-2.5 py-1 rounded-lg uppercase tracking-widest font-mono"><?php echo e($lowStock->count()); ?> SKUs</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-amber-50/50 border-b border-amber-100">
                                    <th class="px-6 py-4 text-[10px] font-black text-amber-500 uppercase tracking-widest">SKU / Product Profile</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-amber-500 uppercase tracking-widest text-center">Current Stock</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-amber-500 uppercase tracking-widest text-right">Replenishment Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-amber-100 text-xs font-medium text-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $lowStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-amber-50/20 transition-colors">
                                        <td class="px-6 py-4 text-gray-900">
                                            <span class="font-mono text-amber-600 font-black mr-2"><?php echo e($item->sku); ?></span> <span class="font-bold"><?php echo e($item->name); ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-gray-900 font-mono"><?php echo e($item->stock); ?> units</td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border bg-amber-50 text-amber-600 border-amber-100">Under Threshold</span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-[10px] font-bold text-emerald-600 uppercase tracking-widest bg-emerald-50/5">No low stock warnings recorded.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Printable Stylings Document Overrides -->
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
                font-size: 10pt !important;
            }
            .print\:hidden {
                display: none !important;
            }
            .print\:block {
                display: block !important;
            }
            /* Reset wrappers & containers to full width */
            main, .max-w-7xl, .container, .p-4, .p-6, .py-8 {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
                background: transparent !important;
            }
            /* Format shadow cards as standard table boxes */
            .bg-white {
                background: white !important;
                border: 1px solid #e5e7eb !important;
                box-shadow: none !important;
                margin-bottom: 20px !important;
                page-break-inside: avoid !important;
            }
            /* Layout corrections for sidebars */
            aside, header, nav, footer {
                display: none !important;
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>