<x-app-layout title="Manage Resellers">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Reseller Network Live</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Manage Resellers</h1>
            <p class="text-xs text-gray-400 mt-1">Authorized wholesale partners, procurement frequency, and network spend analytics.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.resellers.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-[11px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 hover:-translate-y-0.5 transition-all shadow-md duration-300">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add Reseller Account
            </a>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Accounts -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Registered Partners</span>
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 group-hover:bg-violet-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ $totalResellers }}</h3>
                <p class="text-[9px] text-violet-600 font-bold uppercase tracking-wider mt-2 leading-none">Active reseller storefronts</p>
            </div>
        </div>

        <!-- Wholesale Orders -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Wholesale Orders</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ number_format($totalOrdersCount) }}</h3>
                <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 leading-none">Total restock operations submitted</p>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Network Wholesale Spend</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">RM{{ number_format($totalRevenue, 2) }}</h3>
                <p class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider mt-2 leading-none">Aggregated wholesale pipeline value</p>
            </div>
        </div>
    </div>

    <!-- Search & Table Workspace -->
    <div x-data="{ 
            loading: false,
            async fetchResellers(url = null) {
                this.loading = true;
                const form = document.getElementById('search-form');
                const params = new URLSearchParams(new FormData(form));
                let targetUrl = url || `{{ route('admin.resellers.index') }}?${params.toString()}`;
                try {
                    const response = await fetch(targetUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    document.getElementById('table-container').innerHTML = await response.text();
                    window.history.pushState({}, '', targetUrl);
                } catch (error) { console.error(error); } finally { this.loading = false; }
            }
         }"
         class="space-y-6">
        
        <!-- Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form id="search-form" @submit.prevent="fetchResellers()" class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search partners by name or email…" 
                           class="w-full pl-11 pr-4 py-3 text-sm font-bold text-gray-900 border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">Search</button>
                    <a href="{{ route('admin.resellers.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-400 hover:text-black text-xs font-bold uppercase tracking-widest rounded-xl transition-all flex items-center justify-center">Reset</a>
                </div>
            </form>
        </div>

        <!-- Partners Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12 relative">
            
            <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-50 flex items-center justify-center rounded-2xl">
                <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin"></div>
            </div>

            <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Authorized Resellers</h2>
            </div>

            <div id="table-container">
                @include('admin.resellers.partials.table')
            </div>
        </div>
    </div>

    <script>
        function initResellersCatalog() {
            const tableContainer = document.getElementById('table-container');

            if (tableContainer) {
                tableContainer.addEventListener('click', function(e) {
                    const btnLoadMore = e.target.closest('#btn-admin-resellers-load-more');
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
                        <span>Syncing Partners...</span>
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
                        
                        const tbody = document.getElementById('admin-resellers-tbody');
                        const newRows = doc.querySelectorAll('#admin-resellers-tbody tr');
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

                        const wrapper = document.getElementById('admin-resellers-load-more-wrapper');
                        const newBtn = doc.getElementById('btn-admin-resellers-load-more');
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
                        console.error('Error loading more resellers:', error);
                        btnLoadMore.disabled = false;
                        btnLoadMore.classList.remove('opacity-75');
                        btnLoadMore.innerHTML = `<span>Error - Retry</span>`;
                    });
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initResellersCatalog);
        } else {
            initResellersCatalog();
        }
    </script>

    <!-- Delete Modal -->
    <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full shadow-2xl">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Reseller?</h3>
            <p class="text-sm text-gray-500 mb-8">This will permanently remove <span id="delete-name" class="font-bold text-black"></span> and all associated records. This action cannot be undone.</p>
            
            <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center mb-2">Type the name to confirm</label>
                <input type="text" id="delete-confirm-input" class="w-full text-center py-3 bg-white border-gray-200 rounded-xl text-sm font-bold focus:ring-0 focus:border-red-500">
            </div>

            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3 border border-gray-200 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-50">Cancel</button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" id="delete-confirm-btn" disabled class="w-full py-3 bg-black text-white rounded-xl text-xs font-bold uppercase tracking-widest disabled:opacity-20 transition-all">Confirm</button>
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
            document.getElementById('delete-modal').classList.replace('hidden', 'flex');
        }
        document.getElementById('delete-confirm-input').addEventListener('input', e => {
            const btn = document.getElementById('delete-confirm-btn');
            btn.disabled = e.target.value !== expectedDeleteName;
        });
        function closeDeleteModal() { document.getElementById('delete-modal').classList.replace('flex', 'hidden'); }
    </script>
</x-app-layout>
