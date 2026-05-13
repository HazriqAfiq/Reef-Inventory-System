<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'My Orders']); ?>
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Order Pipeline Syncing</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">My Orders</h1>
            <p class="text-xs text-gray-400 mt-1">Review your past stock purchases from Headquarters.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <a href="<?php echo e(route('reseller.orders.create')); ?>"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Order Stock
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Wholesale Purchases Directory</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Order Ref</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Date & Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Shipping Info</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Units</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Value</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody id="orders-tbody" class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="<?php echo e(route('reseller.orders.show', $order)); ?>" class="font-black text-black hover:underline">
                                    #<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?>

                                </a>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5"><?php echo e($order->created_at->diffForHumans()); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900 leading-none"><?php echo e($order->created_at->format('d M, Y')); ?></p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1"><?php echo e($order->created_at->format('h:i A')); ?></p>
                            </td>
                            <td class="px-6 py-4 text-left whitespace-nowrap">
                                <?php if($order->shippingAddress): ?>
                                    <?php $address = $order->shippingAddress; ?>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none"><?php echo e($address->full_name); ?></p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1 truncate max-w-[200px]" title="<?php echo e($address->address); ?>, <?php echo e($address->postcode); ?> <?php echo e($address->city); ?>, <?php echo e($address->state); ?>">
                                            <?php echo e($address->city); ?>, <?php echo e($address->state); ?>

                                        </p>
                                    </div>
                                <?php else: ?>
                                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-0.5 bg-gray-50 border border-gray-100 rounded text-[9px] font-black text-gray-500 tabular-nums">
                                    <?php echo e($order->items->sum('quantity')); ?> items
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                                RM<?php echo e(number_format($order->total_price, 2)); ?>

                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2 flex-wrap">
                                    <?php if($order->status === 'paid'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-emerald-600 bg-emerald-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-emerald-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Paid
                                        </span>
                                    <?php elseif($order->status === 'processing'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-blue-600 bg-blue-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-blue-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                            Processing
                                        </span>
                                    <?php elseif($order->status === 'shipped'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-indigo-600 bg-indigo-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-indigo-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                            Shipped
                                        </span>
                                    <?php elseif($order->status === 'delivered'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-emerald-700 bg-emerald-100/30 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-emerald-200/50">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                            Delivered
                                        </span>
                                    <?php elseif($order->status === 'cancelled'): ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-rose-600 bg-rose-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-rose-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Cancelled
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-amber-600 bg-amber-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-amber-100/40">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    <?php endif; ?>

                                    
                                    <?php if($order->status === 'pending'): ?>
                                        <a href="<?php echo e(route('reseller.orders.payment', $order)); ?>" 
                                           class="inline-flex items-center gap-1 px-3 py-1 bg-black hover:bg-gray-800 text-white text-[9px] font-black uppercase tracking-widest rounded-lg transition-all hover:scale-105 active:scale-95 shadow-sm shrink-0">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Make Payment
                                        </a>
                                    <?php elseif(in_array($order->status, ['shipped', 'delivered']) && $order->tracking_number): ?>
                                        <a href="<?php echo e($order->tracking_url); ?>" target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-indigo-50/60 hover:bg-indigo-100 text-indigo-700 text-[9px] font-black uppercase tracking-widest rounded-lg transition-all hover:scale-105 active:scale-95 border border-indigo-100/50 shadow-xs shrink-0"
                                           title="Courier: <?php echo e($order->courier_name); ?>">
                                            <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"/>
                                            </svg>
                                            Track (<?php echo e($order->tracking_number); ?>)
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?php echo e(route('reseller.orders.show', $order)); ?>" 
                                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
                                        Order Details
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No wholesale orders found</p>
                                    <p class="text-xs text-gray-400 mt-1">Initiate a restock purchase order with HQ to purchase product inventory.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($orders->nextPageUrl()): ?>
            <div id="load-more-wrapper" class="px-6 py-5 border-t border-gray-50 flex justify-center">
                <button id="btn-load-more" 
                        data-next-url="<?php echo e($orders->nextPageUrl()); ?>" 
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-xs font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
                    <span>Show More</span>
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function initResellerOrders() {
            const btnLoadMore = document.getElementById('btn-load-more');
            const tbody = document.getElementById('orders-tbody');
            const wrapper = document.getElementById('load-more-wrapper');

            if (btnLoadMore && tbody) {
                btnLoadMore.addEventListener('click', function() {
                    const nextUrl = btnLoadMore.getAttribute('data-next-url');
                    if (!nextUrl) return;

                    btnLoadMore.disabled = true;
                    btnLoadMore.classList.add('opacity-75');
                    btnLoadMore.innerHTML = `
                        <svg class="animate-spin h-3.5 w-3.5 text-current" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Syncing Ledger...</span>
                    `;

                    fetch(nextUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Extract rows
                        const newRows = doc.querySelectorAll('#orders-tbody tr');
                        newRows.forEach(row => {
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(8px)';
                            row.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                            tbody.appendChild(row);
                            
                            setTimeout(() => {
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, 50);
                        });

                        // Check for next page link from the new page
                        const newBtn = doc.getElementById('btn-load-more');
                        if (newBtn) {
                            const newUrl = newBtn.getAttribute('data-next-url');
                            btnLoadMore.setAttribute('data-next-url', newUrl);
                            btnLoadMore.disabled = false;
                            btnLoadMore.classList.remove('opacity-75');
                            btnLoadMore.innerHTML = `
                                <span>Show More</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/>
                                </svg>
                            `;
                        } else {
                            if (wrapper) wrapper.remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more orders:', error);
                        btnLoadMore.disabled = false;
                        btnLoadMore.classList.remove('opacity-75');
                        btnLoadMore.innerHTML = `<span>Error - Retry</span>`;
                    });
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initResellerOrders);
        } else {
            initResellerOrders();
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/orders/index.blade.php ENDPATH**/ ?>