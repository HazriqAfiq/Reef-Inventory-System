<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
        <p class="text-sm text-gray-500 mt-1">Real-time performance analytics across your storefront and reseller network.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Revenue -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Revenue</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM<?php echo e(number_format($totalNetIncome + $networkVolume, 0)); ?></h3>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">+12%</span>
            </div>
        </div>

        <!-- Storefront -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Direct Sales</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM<?php echo e(number_format($storefrontRevenue, 0)); ?></h3>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">+8%</span>
            </div>
        </div>

        <!-- Resellers -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Network</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM<?php echo e(number_format($networkVolume, 0)); ?></h3>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">+15%</span>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Earnings</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM<?php echo e(number_format($totalNetIncome, 0)); ?></h3>
                <?php if($incomeChange !== null): ?>
                    <span class="text-[10px] font-bold <?php echo e($incomeChange >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50'); ?> px-2 py-1 rounded-lg">
                        <?php echo e($incomeChange >= 0 ? '+' : ''); ?><?php echo e($incomeChange); ?>%
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Sales Chart -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm mb-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Sales Trajectory</h2>
                <p class="text-xs text-gray-400 mt-1">Daily revenue trends across channels</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Direct</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Network</span>
                </div>
            </div>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="mainSalesChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Top Products -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Product Performance</h2>
            <div class="h-[300px]">
                <canvas id="topProductsBarChart"></canvas>
            </div>
        </div>

        <!-- Channel Performance -->
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Channel Performance</h2>
            <div class="h-[200px] relative flex items-center justify-center">
                <canvas id="channelShareChart"></canvas>
                <div class="absolute flex flex-col items-center pointer-events-none">
                    <span class="text-xl font-bold text-gray-900">RM<?php echo e(number_format($storefrontRevenue + $networkVolume, 0)); ?></span>
                    <span class="text-[10px] text-gray-400 uppercase">Total Revenue</span>
                </div>
            </div>
            <div class="mt-8 space-y-3">
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        <span class="text-gray-500">Direct Storefront</span>
                    </div>
                    <span class="font-bold text-gray-900">RM<?php echo e(number_format($storefrontRevenue, 0)); ?></span>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                        <span class="text-gray-500">Reseller Network</span>
                    </div>
                    <span class="font-bold text-gray-900">RM<?php echo e(number_format($networkVolume, 0)); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Context -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
        <!-- Alerts -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Operational Alerts</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Growth Spike</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">+18% Velocity Identified</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Restock Alert</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($lowStockCount); ?> SKUs Below Threshold</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Partner Lead</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Top Performer Found</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Storefront -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Recent Direct Sales</h2>
            </div>
            <div class="divide-y divide-gray-50">
                <?php $__currentLoopData = $recentStorefrontSales->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                        <div>
                            <p class="text-xs font-bold text-gray-900 truncate w-32"><?php echo e($sale->product->name); ?></p>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($sale->created_at->diffForHumans()); ?></p>
                        </div>
                        <span class="text-xs font-bold text-gray-900">RM<?php echo e(number_format($sale->total_price, 0)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Recent Network -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Network Orders</h2>
            </div>
            <div class="divide-y divide-gray-50">
                <?php $__currentLoopData = $recentResellerSales->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                        <div>
                            <p class="text-xs font-bold text-gray-900 truncate w-32"><?php echo e($sale->user->name); ?></p>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($sale->created_at->diffForHumans()); ?></p>
                        </div>
                        <span class="text-xs font-bold text-gray-900">RM<?php echo e(number_format($sale->total_price, 0)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Performance Ledger -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Performance Index</h2>
            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Top Performers</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/10">
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Asset</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Volume</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Revenue</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Stock Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php $__currentLoopData = $topProductsChart->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50/30 transition-all">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 p-1 shrink-0 overflow-hidden">
                                        <?php if($product->primaryImage): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->primaryImage->image_path)); ?>" class="w-full h-full object-contain">
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900"><?php echo e($product->name); ?></p>
                                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($product->category?->name ?? 'Series'); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center text-xs font-bold text-gray-900">
                                <?php echo e(number_format($product->sales_sum_quantity ?? 0)); ?>

                            </td>
                            <td class="px-8 py-5 text-right text-xs font-bold text-gray-900">
                                RM<?php echo e(number_format($product->sales_sum_total_price ?? 0, 0)); ?>

                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest <?php echo e($product->stock > 50 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'); ?>">
                                    <?php echo e($product->stock > 50 ? 'In Stock' : 'Low Stock'); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        };

        // Main Sales Chart
        new Chart(document.getElementById('mainSalesChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($trendLabels, 15, 512) ?>,
                datasets: [
                    {
                        data: <?php echo json_encode($trendStorefront, 15, 512) ?>,
                        borderColor: '#6366f1',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3
                    },
                    {
                        data: <?php echo json_encode($trendNetwork, 15, 512) ?>,
                        borderColor: '#8b5cf6',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3
                    }
                ]
            },
            options: commonOptions
        });

        // Top Products Bar
        new Chart(document.getElementById('topProductsBarChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($topProductLabels->take(5), 15, 512) ?>,
                datasets: [{
                    data: <?php echo json_encode($topProductData->take(5), 15, 512) ?>,
                    backgroundColor: '#6366f1',
                    borderRadius: 4,
                    barThickness: 16
                }]
            },
            options: {
                indexAxis: 'y',
                ...commonOptions,
                scales: {
                    x: { grid: { display: false }, ticks: { display: false } },
                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' }, color: '#1f2937' } }
                }
            }
        });

        // Channel Performance Donut
        new Chart(document.getElementById('channelShareChart'), {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Network'],
                datasets: [{
                    data: [<?php echo e($storefrontRevenue); ?>, <?php echo e($networkVolume); ?>],
                    backgroundColor: ['#6366f1', '#8b5cf6'],
                    borderWidth: 0,
                    cutout: '85%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    </script>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>