<x-app-layout title="System Activity Logs">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl font-black text-gray-900 tracking-tight uppercase">Activity Ledger</h1>
            <p class="text-[12px] font-medium text-gray-500 mt-1 uppercase tracking-widest">Audit trail for administrative actions</p>
        </div>
    </div>

    <div x-data="{ 
            loading: false,
            async fetchLogs(url) {
                this.loading = true;
                try {
                    const response = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const html = await response.text();
                    document.getElementById('table-container').innerHTML = html;
                    window.history.pushState({}, '', url);
                } catch (error) {
                    console.error('Error fetching logs:', error);
                } finally {
                    this.loading = false;
                }
            }
         }"
         @click="if($event.target.closest('.pagination a')) { $event.preventDefault(); fetchLogs($event.target.closest('.pagination a').href); }"
         class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden mb-12 relative">
        
        <div x-show="loading" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-50 flex items-center justify-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-10 h-10 border-4 border-slate-600/10 border-t-slate-600 rounded-full animate-spin"></div>
                <p class="text-[11px] font-bold text-slate-600 uppercase tracking-widest">Scanning Trail...</p>
            </div>
        </div>

        <div id="table-container">
            @include('admin.activity-logs.partials.table')
        </div>
    </div>

</x-app-layout>
