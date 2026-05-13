<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'My Performance Reports']); ?>
    <div class="relative animate-fade-in">
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Performance Ledger Live</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Performance Reports</h1>
                <p class="text-xs text-gray-400 mt-1">Analyze wholesale investments, shelf-stock valuations, profit margins, and procurement scaling trends.</p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm flex items-center gap-2 text-xs font-bold text-gray-600">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Partner Analytics Suite</span>
                </div>
                
                <a href="<?php echo e(route('reseller.reports.pdf')); ?>" 
                   data-no-spa
                   download
                   class="inline-flex items-center gap-2 px-5 py-3 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate PDF Report
                </a>
            </div>
        </div>

        <!-- Row 1: Procurement / Expense KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Sourced Invested -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Wholesale Investment</span>
                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-800 group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($totalProcurementSpend, 2)); ?></h3>
                    <div class="flex items-baseline justify-between gap-2 mt-2 leading-none">
                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">Total spent across <?php echo e($totalSourcedOrders); ?> restocks</p>
                    </div>
                </div>
            </div>

            <!-- Average Restock Value -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Average Sourced Value</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($averageOrderValue, 2)); ?></h3>
                    <p class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider mt-2.5 leading-none">Average investment size per restock</p>
                </div>
            </div>

            <!-- Goal Tracking KPI -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monthly Sourcing Target</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate">
                        <?php echo e($goalProgress); ?>%
                    </h3>
                    <div class="mt-3.5 shrink-0">
                        <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: <?php echo e($goalProgress); ?>%"></div>
                        </div>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-1 block leading-none">
                            Spent RM<?php echo e(number_format($currentMonthSpend, 2)); ?> of RM<?php echo e(number_format($monthlyGoal ?: 1000, 2)); ?> Goal
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Shelf Inventory Wealth & Profit Margins -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Sourced Stock Units -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Current Stock Held</span>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate"><?php echo e(number_format($totalStockUnits)); ?> Bottles</h3>
                    <p class="text-[9px] text-blue-600 font-bold uppercase tracking-wider mt-2.5 leading-none">Total units sitting on reseller shelves</p>
                </div>
            </div>

            <!-- Cost vs Retail Valuation -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Shelf Valuation</span>
                    <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 group-hover:bg-violet-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
                <div>
                    <div class="space-y-1">
                        <div class="flex items-baseline justify-between">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Cost (COGS):</span>
                            <span class="text-sm font-black text-gray-900 tabular-nums">RM<?php echo e(number_format($stockValuationCost, 2)); ?></span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Retail (RSP):</span>
                            <span class="text-sm font-black text-indigo-600 tabular-nums">RM<?php echo e(number_format($stockValuationRetail, 2)); ?></span>
                        </div>
                    </div>
                    <p class="text-[8px] text-gray-400 font-bold uppercase tracking-wider mt-2.5 leading-none">Capital investment vs gross sales potential</p>
                </div>
            </div>

            <!-- Potential Earnings Margin -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Potential Profits</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-rose-600 tracking-tight tabular-nums truncate">
                        +RM<?php echo e(number_format($potentialProfitMargin, 2)); ?>

                    </h3>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="px-1.5 py-0.5 rounded bg-rose-50 border border-rose-100 text-[8px] font-black text-rose-600 uppercase tracking-wider leading-none">
                            <?php echo e(number_format($averageMarginPercentage, 1)); ?>% Average Margin
                        </span>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest leading-none">At Full Retail RSP</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Graphic Visualizations -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8 items-stretch">
            <!-- Spend Trend Line Chart (66%) -->
            <div class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="mb-6">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-black"></span>
                        Procurement Expenditure Trend
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Replenishment spend trends over the last 6 months</p>
                </div>
                <div class="h-[200px] md:h-[240px] lg:h-[280px] min-h-[200px] relative">
                    <?php if($monthlyTrend->isEmpty()): ?>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">No procurement trend data</p>
                            <p class="text-[10px] text-gray-300 mt-0.5">Expenditure graphs will generate as you restock.</p>
                        </div>
                    <?php else: ?>
                        <canvas id="procurementTrendChart"></canvas>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Order Status breakdown Doughnut Chart (33%) -->
            <div class="lg:col-span-4 bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="mb-6">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        Order Status Breakdown
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Replenishment request tracking and volumes</p>
                </div>
                <div class="h-[150px] md:h-[180px] lg:h-[200px] relative flex items-center justify-center">
                    <?php if(collect($orderStats)->sum('count') === 0): ?>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">No orders recorded</p>
                        </div>
                    <?php else: ?>
                        <canvas id="orderStatusBreakdownChart"></canvas>
                    <?php endif; ?>
                </div>
                <div class="mt-4 border-t border-gray-50 pt-4 flex flex-wrap gap-x-4 gap-y-1 items-center justify-center text-[9px] font-black uppercase tracking-widest text-gray-500">
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Pending</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Processing</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Paid / Delivered</div>
                    <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Cancelled</div>
                </div>
            </div>
        </div>

        <!-- Row 4: Top Sourced Products (Sourcing Intelligence) -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-violet-600"></span>
                        Top Sourced Fragrances
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Wholesale acquisitions ranked by restocked quantities</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50/30 text-[9px] font-black uppercase tracking-wider text-gray-400">
                            <th class="py-4 px-6">Product details</th>
                            <th class="py-4 px-4 text-right">Units Sourced</th>
                            <th class="py-4 px-4 text-right">Wholesale Cost (WSP)</th>
                            <th class="py-4 px-4 text-right">Retail RSP / Unit</th>
                            <th class="py-4 px-4 text-right">Potential Margin / Unit</th>
                            <th class="py-4 px-6 text-right">Wholesale Sourced Investment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        <?php $__empty_1 = true; $__currentLoopData = $topSourcedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($item->product): ?>
                                <?php
                                    $unitProfit = $item->product->retail_price - $item->product->wholesale_price;
                                    $unitProfitPercent = $item->product->retail_price > 0 ? ($unitProfit / $item->product->retail_price) * 100 : 0;
                                ?>
                                <tr class="hover:bg-gray-50/60 transition-colors">
                                    <!-- Product -->
                                    <td class="py-4 px-6 flex items-center gap-3">
                                        <div class="w-10 h-12 bg-gray-50 border border-gray-100 rounded-lg overflow-hidden shrink-0 relative shadow-sm">
                                            <?php if($item->product->primaryImage): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->product->primaryImage->image_path)); ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="min-w-0">
                                            <a href="<?php echo e(route('reseller.products.show', $item->product->slug)); ?>" class="font-bold text-gray-900 hover:text-indigo-600 hover:underline transition-colors block truncate"><?php echo e($item->product->name); ?></a>
                                            <div class="flex items-center gap-1.5 text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">
                                                <span><?php echo e($item->product->volume_ml); ?>ml</span>
                                                <span>&middot;</span>
                                                <span><?php echo e(optional($item->product->category)->name ?? 'No Category'); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Units -->
                                    <td class="py-4 px-4 text-right font-bold text-gray-900 tabular-nums">
                                        <?php echo e(number_format($item->total_qty)); ?> units
                                    </td>
                                    <!-- WSP -->
                                    <td class="py-4 px-4 text-right text-gray-500 tabular-nums font-semibold">
                                        RM<?php echo e(number_format($item->product->wholesale_price, 2)); ?>

                                    </td>
                                    <!-- RSP -->
                                    <td class="py-4 px-4 text-right text-indigo-600 tabular-nums font-semibold">
                                        RM<?php echo e(number_format($item->product->retail_price, 2)); ?>

                                    </td>
                                    <!-- Profit Margin -->
                                    <td class="py-4 px-4 text-right tabular-nums font-bold text-emerald-600">
                                        +RM<?php echo e(number_format($unitProfit, 2)); ?>

                                        <span class="block text-[8px] font-black text-emerald-500 uppercase tracking-wider leading-none mt-1">
                                            <?php echo e(number_format($unitProfitPercent, 1)); ?>% Margin
                                        </span>
                                    </td>
                                    <!-- Sourced investment -->
                                    <td class="py-4 px-6 text-right font-black text-gray-900 tabular-nums">
                                        RM<?php echo e(number_format($item->total_spend, 2)); ?>

                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400 font-bold uppercase tracking-widest text-xs bg-gray-50/20">
                                    No products sourced yet. Complete checkout from the wholesale store to build sourcing intelligence logs.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Chart Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        // 1. Procurement Expenditure Trend Chart (Line Chart)
        const lineCtx = document.getElementById('procurementTrendChart');
        if (lineCtx) {
            const trendLabels = <?php echo json_encode($monthlyTrend->pluck('month_name'), 15, 512) ?>;
            const trendData = <?php echo json_encode($monthlyTrend->pluck('total_spend'), 15, 512) ?>;

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Replenishment Investment (RM)',
                        data: trendData,
                        borderColor: '#6366f1',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#6366f1',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.35,
                        fill: true,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(99, 102, 241, 0.22)');
                            gradient.addColorStop(1, 'rgba(99, 102, 241, 0.01)');
                            return gradient;
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            titleFont: { weight: 'black', size: 12 },
                            bodyFont: { weight: 'bold', size: 11 },
                            callbacks: {
                                label: function(context) {
                                    return ' Invested: RM' + context.raw.toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { weight: 'bold', size: 10 }, color: '#1e293b' }
                        },
                        y: {
                            grid: { color: '#f8fafc' },
                            border: { display: false },
                            ticks: { 
                                font: { weight: 'bold' },
                                callback: function(value) { return 'RM' + value; }
                            }
                        }
                    }
                }
            });
        }

        // 2. Order Status Breakdown Doughnut Chart
        const doughnutCtx = document.getElementById('orderStatusBreakdownChart');
        if (doughnutCtx) {
            const rawStats = <?php echo json_encode($orderStats, 15, 512) ?>;
            const statusLabels = [];
            const statusCounts = [];
            
            // Humanize statuses
            const humanizeMap = {
                'pending': 'Pending Sourcing',
                'paid': 'Paid Fulfilled',
                'processing': 'Processing Sourcing',
                'shipped': 'Shipped Sourcing',
                'delivered': 'Delivered / Completed',
                'cancelled': 'Cancelled'
            };

            const colorsMap = {
                'pending': '#f59e0b', // Amber
                'processing': '#6366f1', // Indigo
                'shipped': '#3b82f6', // Blue
                'delivered': '#10b981', // Emerald
                'paid': '#06b6d4', // Cyan
                'cancelled': '#ef4444' // Rose
            };

            const chartColors = [];

            Object.keys(rawStats).forEach(key => {
                const count = rawStats[key].count;
                if (count > 0) {
                    statusLabels.push(humanizeMap[key] || key);
                    statusCounts.push(count);
                    chartColors.push(colorsMap[key] || '#94a3b8');
                }
            });

            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusCounts,
                        backgroundColor: chartColors,
                        borderWidth: 0,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: 'rgba(0, 0, 0, 0.85)',
                            titleFont: { weight: 'black', size: 11 },
                            bodyFont: { weight: 'bold', size: 10 },
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + ' orders';
                                }
                            }
                        }
                    }
                }
            });
        }
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/reports/index.blade.php ENDPATH**/ ?>