<x-app-layout title="Wholesale Orders">

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
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm flex items-center gap-2 text-xs font-bold text-gray-600">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>Partner Network</span>
            </div>
            
            <a href="{{ route('admin.orders.export') }}"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
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
