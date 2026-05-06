<x-app-layout title="Manage Resellers">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Manage Resellers</h1>
            <p class="text-sm text-gray-500 mt-1">View and manage authorized reseller accounts within your network.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.resellers.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add Reseller
            </a>
        </div>
    </div>



    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <!-- Accounts -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Accounts</p>
                <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ $totalResellers }}</p>
            </div>
        </div>

        <!-- Transactions -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Transactions</p>
                <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ number_format($totalSalesCount) }}</p>
            </div>
        </div>

        <!-- Revenue -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Network Revenue</p>
                <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">RM{{ number_format($totalRevenue, 2) }}</p>
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
        <div @click="if($event.target.closest('.pagination a')) { $event.preventDefault(); fetchResellers($event.target.closest('.pagination a').href); }"
             class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12 relative">
            
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
