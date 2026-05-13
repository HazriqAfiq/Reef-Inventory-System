<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Reseller Dashboard']); ?>
    <div class="relative">
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Reseller Ledger Live</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Reseller Dashboard</h1>
                <p class="text-xs text-gray-400 mt-1">Verify physical shelf inventories, track active stock valuations, and coordinate restock requests.</p>
            </div>
        </div>

        <!-- Top Row (KPIs) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stock Asset Value -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Stock Asset Value</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM<?php echo e(number_format($totalAssetValuation, 2)); ?></h3>
                    <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2.5 leading-none">Total retail asset sitting on shelf</p>
                </div>
            </div>

            <!-- Total Units on Hand -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Units on Hand</span>
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate"><?php echo e(number_format($totalUnitsHeld)); ?> Units</h3>
                    <p class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider mt-2.5 leading-none">Physical bottle count verified locally</p>
                </div>
            </div>

            <!-- Audit Health -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Audit Health</span>
                    <div class="w-10 h-10 rounded-xl <?php echo e($auditHealthPercentage >= 80 ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white' : 'bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white'); ?> flex items-center justify-center transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2.5xl font-black text-gray-900 tracking-tight tabular-nums truncate"><?php echo e($auditHealthPercentage); ?>%</h3>
                    <div class="mt-3.5 shrink-0">
                        <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full <?php echo e($auditHealthPercentage >= 80 ? 'bg-emerald-500' : 'bg-amber-500'); ?> rounded-full transition-all duration-500" style="width: <?php echo e($auditHealthPercentage); ?>%"></div>
                        </div>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest mt-1 block leading-none">Percentage of products verified this week</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Area: Stock Status (Bar Chart) -->
        <div class="mb-8">
            
            <!-- Stock Status (Bar Chart) -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col h-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 shrink-0">
                    <div>
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-black"></span>
                            Verified Stock Distribution
                        </h2>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Physical counts of each perfume on hand</p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[10px] font-black uppercase tracking-widest text-gray-400 shrink-0 select-none">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-gray-900">Healthy (&ge;15)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="text-gray-900">Low (&lt;15)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            <span class="text-gray-900">Out of Stock</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1 min-h-[200px] h-[200px] md:h-[260px] md:min-h-[260px]">
                    <canvas id="stockDistributionChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottom Row: Needs Attention (33%) & Recommendations (33%) & Shipments (33%) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10 items-stretch">
            
            <!-- Needs Attention / Shelf Audit List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3 shrink-0">
                    <div>
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            Needs Shelf Verification
                        </h2>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Items needing manual verification or currently low count</p>
                    </div>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto max-h-[350px] divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $needsAttentionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between py-3.5 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-gray-900 truncate"><?php echo e($stock->product?->name); ?></h4>
                                <div class="flex items-center gap-1.5 mt-1 text-[9px] text-gray-400 font-bold uppercase tracking-wider">
                                    <span>Shelf Level: <?php echo e($stock->quantity); ?> units</span>
                                    <span>&middot;</span>
                                    <span>Last Verified: <?php echo e($stock->updated_at ? $stock->updated_at->diffForHumans() : 'Never'); ?></span>
                                </div>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border <?php echo e($stock->freshness_badge_color); ?>">
                                    <?php echo e($stock->days_since_audit > 7 ? 'Stale Audit' : 'Low Stock'); ?>

                                </span>
                                <a href="<?php echo e(route('reseller.audit.index')); ?>" class="text-[9px] font-black uppercase tracking-wider text-black border border-gray-150 px-2.5 py-1.5 rounded-lg hover:bg-gray-50">Count</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mb-3">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Inventory is flawless</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">All products verified and holding secure stock margins.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Restock Recommendations -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        Restock Intelligence Suggestions
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Recommended wholesale restock acquisitions</p>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto max-h-[350px] space-y-4">
                    <!-- Recommendations Table List -->
                    <div class="space-y-2.5">
                        <?php $__empty_1 = true; $__currentLoopData = $restockRecommendations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-3 bg-gray-50/50 border border-gray-100 rounded-xl flex items-center justify-between gap-3">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-900 truncate"><?php echo e($rec['product']->name); ?></h4>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Recommend buying: <?php echo e($rec['recommended_qty']); ?> units &middot; <?php echo e($rec['reason']); ?></p>
                                </div>
                                <a href="<?php echo e(route('reseller.orders.create')); ?>" class="px-3 py-1.5 bg-black text-white text-[9px] font-black uppercase tracking-wider rounded-lg hover:bg-gray-800 shrink-0 shadow-sm">Buy Now</a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="flex flex-col items-center justify-center py-6 text-center">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No Procurement Recommends</p>
                                <p class="text-[9px] text-gray-400 mt-0.5">All warehouse capacities are completely sufficient.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Active Incoming Shipments -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3 shrink-0">
                    <div>
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            Active Incoming Shipments
                        </h2>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Real-time procurement tracking & statuses</p>
                    </div>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto max-h-[350px] divide-y divide-gray-50">
                    <?php $__empty_1 = true; $__currentLoopData = $myRecentOrders->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $status = strtolower($order->status);
                            if ($status === 'paid' || $status === 'completed' || $status === 'success') {
                                $statusBadge = 'bg-emerald-50 text-emerald-600 border-emerald-100/40';
                            } elseif ($status === 'pending' || $status === 'unpaid') {
                                $statusBadge = 'bg-amber-50 text-amber-600 border-amber-100/40';
                            } else {
                                $statusBadge = 'bg-gray-50 text-gray-500 border-gray-100';
                            }
                        ?>
                        <div class="flex items-center justify-between py-3.5 first:pt-0 last:pb-0">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-gray-900">Order #<?php echo e(substr($order->billplz_id ?? $order->id, 0, 8)); ?></span>
                                <div class="flex items-center gap-1.5 mt-1 text-[9px] text-gray-400 font-bold uppercase tracking-wider">
                                    <span>Total: RM<?php echo e(number_format($order->total_price, 2)); ?></span>
                                    <span>&middot;</span>
                                    <span><?php echo e($order->created_at ? $order->created_at->diffForHumans() : 'Recently'); ?></span>
                                </div>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border <?php echo e($statusBadge); ?>">
                                    <?php echo e($order->status); ?>

                                </span>
                                <a href="<?php echo e(route('reseller.orders.show', $order)); ?>" class="text-[9px] font-black uppercase tracking-wider text-black border border-gray-150 px-2.5 py-1.5 rounded-lg hover:bg-gray-50">Track</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="flex flex-col items-center justify-center py-12 text-center h-full">
                            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-3 border border-blue-100/50 animate-pulse">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">No Active Shipments</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">All procurement shipments are current and complete.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>



    </div>

    <!-- Chart Configuration -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        // Verified Stock Status (Horizontal Bar Chart)
        const barCtx = document.getElementById('stockDistributionChart');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($stockLabels, 15, 512) ?>,
                    datasets: [{
                        label: 'Physical Count',
                        data: <?php echo json_encode($stockCounts, 15, 512) ?>,
                        backgroundColor: <?php echo json_encode($stockCounts, 15, 512) ?>.map(qty => {
                            if (qty === 0) return '#ef4444'; // Out of Stock (Red)
                            if (qty < 15) return '#f59e0b';  // Low Stock (Amber)
                            return '#10b981';                // Healthy (Emerald)
                        }),
                        borderRadius: 8,
                        borderWidth: 0,
                        barThickness: window.innerWidth < 768 ? 8 : (window.innerWidth < 1024 ? 16 : undefined),
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            padding: 12,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { weight: 'black', size: 12 },
                            bodyFont: { weight: 'bold', size: 11 },
                            callbacks: {
                                label: function(context) {
                                    return ' Verified Count: ' + context.raw + ' units';
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
                            grid: { color: '#f1f5f9' },
                            border: { display: false },
                            ticks: { font: { weight: 'bold' } }
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/dashboard.blade.php ENDPATH**/ ?>