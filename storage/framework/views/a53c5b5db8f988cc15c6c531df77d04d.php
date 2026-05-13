<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Wholesale Orders']); ?>

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">B2B Order Stream Active</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Wholesale Orders</h1>
            <p class="text-xs text-gray-400 mt-1">Review B2B purchase orders, transaction values, and partner fulfillment metrics.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <a href="<?php echo e(route('admin.orders.export')); ?>"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Orders Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative mb-12">
        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Order Ledger</h2>
        </div>

        <div id="table-container">
            <?php echo $__env->make('admin.orders.partials.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <script>
        function initOrdersLedger() {
            const tableContainer = document.getElementById('table-container');

            if (tableContainer) {
                tableContainer.addEventListener('click', function(e) {
                    const btnLoadMore = e.target.closest('#btn-admin-load-more');
                    if (!btnLoadMore) return;

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
                        
                        const tbody = document.getElementById('admin-orders-tbody');
                        const newRows = doc.querySelectorAll('#admin-orders-tbody tr');
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

                        const wrapper = document.getElementById('admin-load-more-wrapper');
                        const newBtn = doc.getElementById('btn-admin-load-more');
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
            document.addEventListener('DOMContentLoaded', initOrdersLedger);
        } else {
            initOrdersLedger();
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>