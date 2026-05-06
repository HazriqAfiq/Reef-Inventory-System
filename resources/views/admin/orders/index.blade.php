<x-app-layout title="Wholesale Orders">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Wholesale Orders</h1>
            <p class="text-sm text-gray-500 mt-1">B2B orders placed by the Reseller network.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.export') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-400 hover:text-black text-xs font-bold uppercase tracking-widest rounded-xl transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Orders Table Container -->
    <div x-data="{ 
            loading: false,
            async fetchOrders(url) {
                this.loading = true;
                try {
                    const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    document.getElementById('table-container').innerHTML = await response.text();
                    window.history.pushState({}, '', url);
                } catch (error) { console.error(error); } finally { this.loading = false; }
            }
         }"
         @click="if($event.target.closest('.pagination a')) { $event.preventDefault(); fetchOrders($event.target.closest('.pagination a').href); }"
         class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative mb-12">
        
        <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-50 flex items-center justify-center rounded-2xl">
            <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin"></div>
        </div>

        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Order Ledger</h2>
        </div>

        <div id="table-container">
            @include('admin.orders.partials.table')
        </div>
    </div>

</x-app-layout>
