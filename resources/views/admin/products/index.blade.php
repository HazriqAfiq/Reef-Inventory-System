<x-app-layout title="Product Inventory">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Ecosystem Stock Live</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Product Catalog</h1>
            <p class="text-xs text-gray-400 mt-1">Manage full product catalog, retail pricing thresholds, and global partner inventory.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm flex items-center gap-2 text-xs font-bold text-gray-600">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>Ecosystem Inventory</span>
            </div>
            
            <a href="{{ route('admin.products.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add Product
            </a>
        </div>
    </div>

    <!-- Inventory KPIs -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Card 1: Total Catalog Products -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Catalog Products</span>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 group-hover:bg-black group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($totalProducts) }}</h3>
            </div>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-2 leading-none">Total products in catalog</p>
        </div>

        <!-- Card 2: Ecosystem Stock -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Ecosystem Stock</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($totalStock) }}</h3>
            </div>
            <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 leading-none">
                <span class="text-gray-950 font-black">{{ number_format($adminStock) }}</span> ADM &middot; <span class="text-gray-950 font-black">{{ number_format($resellerStock) }}</span> RES
            </p>
        </div>

        <!-- Card 3: Low Stock Items -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Low Stock Items</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($lowStockCount) }}</h3>
            </div>
            <p class="text-[9px] text-amber-600 font-bold uppercase tracking-wider mt-2 leading-none">Products needing restock</p>
        </div>

        <!-- Card 4: Out of Stock Items -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Out of Stock Items</span>
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($outOfStock) }}</h3>
            </div>
            <p class="text-[9px] text-red-600 font-bold uppercase tracking-wider mt-2 leading-none">Products completely out</p>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-8">
        <form id="filter-form" method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col lg:flex-row gap-4">
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="search-input" name="search" value="{{ request('search') }}"
                       placeholder="Search product name, Product Code..." autocomplete="off"
                       class="w-full pl-11 pr-4 py-3 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder:text-gray-400">
            </div>

            <select name="stock" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="">Stock Level</option>
                <option value="high" {{ request('stock') === 'high' ? 'selected' : '' }}>High (> 100)</option>
                <option value="medium" {{ request('stock') === 'medium' ? 'selected' : '' }}>Medium (50–100)</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low (1–49)</option>
                <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
            </select>

            <select name="volume" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="">Volume</option>
                @foreach($volumes as $vol)
                    <option value="{{ $vol }}" {{ request('volume') == $vol ? 'selected' : '' }}>{{ $vol }}ml</option>
                @endforeach
            </select>

            <select name="sort" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="name" {{ request('sort', 'name') === 'name' ? 'selected' : '' }}>Name A–Z</option>
                <option value="retail_price" {{ request('sort') === 'retail_price' ? 'selected' : '' }}>Retail ↓</option>
                <option value="wholesale_price" {{ request('sort') === 'wholesale_price' ? 'selected' : '' }}>Wholesale ↓</option>
                <option value="stock" {{ request('sort') === 'stock' ? 'selected' : '' }}>Stock ↑</option>
            </select>

            <button type="submit" class="px-8 py-3 bg-black hover:bg-gray-800 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-sm active:scale-95">Filter</button>
            
            @if(request()->hasAny(['search', 'stock', 'volume', 'sort']))
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 text-[10px] font-black text-gray-400 hover:text-black bg-white border border-gray-100 rounded-xl text-center uppercase tracking-widest transition-all">Reset</a>
            @endif
        </form>
    </div>

    <!-- Product Table Container -->
    <div x-data="{ 
            loading: false,
            async fetchProducts(url = null) {
                this.loading = true;
                const form = document.getElementById('filter-form');
                const params = new URLSearchParams(new FormData(form));
                let targetUrl = url || `{{ route('admin.products.index') }}?${params.toString()}`;
                
                try {
                    const response = await fetch(targetUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    document.getElementById('table-container').innerHTML = await response.text();
                    window.history.pushState({}, '', targetUrl);
                } catch (error) { console.error(error); } finally { this.loading = false; }
            }
         }"
         @submit.prevent="fetchProducts()"
         @change="if($event.target.tagName === 'SELECT') fetchProducts()"
         class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative mb-12">
        
        <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-50 flex items-center justify-center rounded-2xl">
            <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin"></div>
        </div>

        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Product Catalog</h2>
        </div>

        <div id="table-container">
            @include('admin.products.partials.table')
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
                    @csrf @method('DELETE')
                    <button type="submit" id="delete-confirm-btn" disabled class="w-full py-3 text-sm font-bold text-white bg-red-600 rounded-xl opacity-50 cursor-not-allowed transition-all">Delete Product</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function initProductCatalog() {
            const tableContainer = document.getElementById('table-container');

            if (tableContainer) {
                tableContainer.addEventListener('click', function(e) {
                    const btnLoadMore = e.target.closest('#btn-admin-products-load-more');
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
                        <span>Syncing Catalog...</span>
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
                        
                        const tbody = document.getElementById('admin-products-tbody');
                        const newRows = doc.querySelectorAll('#admin-products-tbody tr');
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

                        const wrapper = document.getElementById('admin-products-load-more-wrapper');
                        const newBtn = doc.getElementById('btn-admin-products-load-more');
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
                        console.error('Error loading more products:', error);
                        btnLoadMore.disabled = false;
                        btnLoadMore.classList.remove('opacity-75');
                        btnLoadMore.innerHTML = `<span>Error - Retry</span>`;
                    });
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initProductCatalog);
        } else {
            initProductCatalog();
        }

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
</x-app-layout>
