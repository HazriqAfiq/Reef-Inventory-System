<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Product Inventory']); ?>

    
    <?php if(session('success')): ?>
        <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 animate-fade-in-up">
            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-xs font-bold text-emerald-700 uppercase tracking-wider"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Product Inventory</h1>
            <p class="text-sm text-gray-500 mt-1">Manage full product catalog and ecosystem stock levels.</p>
        </div>
        <a href="<?php echo e(route('admin.products.create')); ?>"
           class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Product
        </a>
    </div>

    <!-- Inventory KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total SKUs</p>
                <p class="text-2xl font-bold text-gray-900 leading-none"><?php echo e($totalProducts); ?></p>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Ecosystem Stock</p>
                <p class="text-2xl font-bold text-gray-900 leading-none"><?php echo e(number_format($totalStock)); ?></p>
                <p class="text-[9px] font-bold text-gray-400 mt-2 uppercase tracking-tight">
                    <?php echo e(number_format($adminStock)); ?> ADM · <?php echo e(number_format($resellerStock)); ?> RES
                </p>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Low Stock</p>
                <div class="flex items-center gap-2">
                    <p class="text-2xl font-bold <?php echo e($lowStockCount > 0 ? 'text-amber-600' : 'text-gray-900'); ?> leading-none"><?php echo e($lowStockCount); ?></p>
                </div>
            </div>
        </div>

        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 shrink-0 border border-gray-100">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Out of Stock</p>
                <p class="text-2xl font-bold <?php echo e($outOfStock > 0 ? 'text-rose-600' : 'text-gray-900'); ?> leading-none"><?php echo e($outOfStock); ?></p>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-6">
        <form id="filter-form" method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="flex flex-col lg:flex-row gap-4">
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="search-input" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Search catalog…" autocomplete="off"
                       class="w-full pl-10 pr-4 py-2.5 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
            </div>

            <select name="stock" class="px-4 py-2.5 text-[11px] font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer">
                <option value="">Stock Level</option>
                <option value="high" <?php echo e(request('stock') === 'high' ? 'selected' : ''); ?>>High (> 100)</option>
                <option value="medium" <?php echo e(request('stock') === 'medium' ? 'selected' : ''); ?>>Medium (50–100)</option>
                <option value="low" <?php echo e(request('stock') === 'low' ? 'selected' : ''); ?>>Low (1–49)</option>
                <option value="out" <?php echo e(request('stock') === 'out' ? 'selected' : ''); ?>>Out of Stock</option>
            </select>

            <select name="volume" class="px-4 py-2.5 text-[11px] font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer">
                <option value="">Volume</option>
                <?php $__currentLoopData = $volumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vol); ?>" <?php echo e(request('volume') == $vol ? 'selected' : ''); ?>><?php echo e($vol); ?>ml</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="sort" class="px-4 py-2.5 text-[11px] font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer">
                <option value="name" <?php echo e(request('sort', 'name') === 'name' ? 'selected' : ''); ?>>Name A–Z</option>
                <option value="retail_price" <?php echo e(request('sort') === 'retail_price' ? 'selected' : ''); ?>>Retail ↓</option>
                <option value="wholesale_price" <?php echo e(request('sort') === 'wholesale_price' ? 'selected' : ''); ?>>Wholesale ↓</option>
                <option value="stock" <?php echo e(request('sort') === 'stock' ? 'selected' : ''); ?>>Stock ↑</option>
            </select>

            <button type="submit" class="px-8 py-2.5 bg-black text-white text-[11px] font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all">Filter</button>
            
            <?php if(request()->hasAny(['search', 'stock', 'volume', 'sort'])): ?>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="px-6 py-2.5 text-[11px] font-bold text-gray-400 hover:text-black bg-white border border-gray-100 rounded-xl text-center uppercase tracking-widest">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Product Table Container -->
    <div x-data="{ 
            loading: false,
            async fetchProducts(url = null) {
                this.loading = true;
                const form = document.getElementById('filter-form');
                const params = new URLSearchParams(new FormData(form));
                let targetUrl = url || `<?php echo e(route('admin.products.index')); ?>?${params.toString()}`;
                
                try {
                    const response = await fetch(targetUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    document.getElementById('table-container').innerHTML = await response.text();
                    window.history.pushState({}, '', targetUrl);
                } catch (error) { console.error(error); } finally { this.loading = false; }
            }
         }"
         @submit.prevent="fetchProducts()"
         @change="if($event.target.tagName === 'SELECT') fetchProducts()"
         @click="if($event.target.closest('.pagination a')) { $event.preventDefault(); fetchProducts($event.target.closest('.pagination a').href); }"
         class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative mb-12">
        
        <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-50 flex items-center justify-center rounded-2xl">
            <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin"></div>
        </div>

        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Product Catalog</h2>
        </div>

        <div id="table-container">
            <?php echo $__env->make('admin.products.partials.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 transform scale-95 transition-transform duration-300" id="delete-modal-content">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-4 border border-red-100">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Delete Product?</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to delete <span id="delete-name" class="font-bold text-gray-900"></span>? This action cannot be undone.</p>
            </div>
            
            <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center mb-2">Type product name to confirm</p>
                <input autocomplete="off" type="text" id="delete-confirm-input" class="w-full text-center py-3 text-sm font-bold text-gray-900 bg-white border border-gray-200 rounded-xl focus:border-red-500 focus:ring-0">
            </div>

            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3 text-sm font-bold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
                <form id="delete-form" method="POST" class="flex-1">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" id="delete-confirm-btn" disabled class="w-full py-3 text-sm font-bold text-white bg-red-600 rounded-xl opacity-50 cursor-not-allowed transition-all">Delete Product</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let expectedDeleteName = '';
        function confirmDelete(url, name) {
            expectedDeleteName = name;
            document.getElementById('delete-name').textContent = name;
            document.getElementById('delete-form').action = url;
            const input = document.getElementById('delete-confirm-input');
            const btn = document.getElementById('delete-confirm-btn');
            input.value = '';
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            const modal = document.getElementById('delete-modal');
            const content = document.getElementById('delete-modal-content');
            modal.classList.remove('hidden');
            setTimeout(() => { modal.classList.add('opacity-100'); content.classList.add('scale-100'); input.focus(); }, 10);
        }
        document.getElementById('delete-confirm-input').addEventListener('input', function(e) {
            const btn = document.getElementById('delete-confirm-btn');
            const matches = e.target.value === expectedDeleteName;
            btn.disabled = !matches;
            btn.classList.toggle('opacity-50', !matches);
            btn.classList.toggle('cursor-not-allowed', !matches);
        });
        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.remove('opacity-100');
            setTimeout(() => modal.classList.add('hidden'), 300);
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/products/index.blade.php ENDPATH**/ ?>