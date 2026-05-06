<x-app-layout title="Global Sales">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Global Sales</h1>
            <p class="text-sm text-gray-500 mt-1">All registered transactions across authorized resellers and storefront.</p>
        </div>
        <a href="{{ route('admin.sales.report', ['year' => $selectedYear, 'month' => $selectedMonth]) }}"
           class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Download Report
        </a>
    </div>

    <!-- Timeframe Filter -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <form method="GET" action="{{ route('admin.sales.index') }}" id="filter-form" class="flex flex-col sm:flex-row sm:items-center gap-4 w-full">
            <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest shrink-0 px-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Timeframe
            </div>
            
            <div class="flex-1 flex flex-col sm:flex-row items-center gap-3">
                <select id="year" name="year" onchange="this.form.submit()"
                        class="w-full sm:w-auto pl-4 pr-10 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>

                <select id="month" name="month" onchange="this.form.submit()"
                        class="w-full sm:w-auto pl-4 pr-10 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer">
                    <option value="">All Months</option>
                    @foreach($availableMonths as $m)
                        <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ strtoupper(\Carbon\Carbon::create()->month($m)->format('F')) }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="px-2 shrink-0">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-black text-[9px] font-bold text-white rounded-xl uppercase tracking-widest">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                {{ $periodLabel }}
            </span>
        </div>
    </div>

    <!-- KPI & Chart Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-10">
        
        <!-- Metrics Column -->
        <div class="col-span-1 space-y-4">
            <!-- Revenue -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Global Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">RM{{ number_format($monthRevenue, 0) }}</p>
                </div>
            </div>

            <!-- Units Sold -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Units Sold</p>
                    <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ number_format($monthUnitsSold) }}</p>
                </div>
            </div>

            <!-- Transactions -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-5">
                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Transactions</p>
                    <p class="text-2xl font-bold text-gray-900 leading-none tabular-nums">{{ number_format($monthTransactions) }}</p>
                </div>
            </div>
        </div>

        <!-- Trend Chart -->
        <div class="col-span-1 lg:col-span-3 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Performance Trajectory</h2>
                    <p class="text-xs text-gray-400 mt-1">Aggregated platform metrics for {{ $periodLabel }}</p>
                </div>
                <div class="flex items-center gap-5 text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-black"></span>Revenue</span>
                    <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-200"></span>Units</span>
                </div>
            </div>
            <div class="h-[360px] w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Sales Table Container -->
    <div x-data="{ 
            loading: false,
            async fetchSales(url = null) {
                this.loading = true;
                const form = document.getElementById('filter-form');
                const params = new URLSearchParams(new FormData(form));
                let targetUrl = url || `{{ route('admin.sales.index') }}?${params.toString()}`;
                if (!url) { window.location.href = targetUrl; return; }
                try {
                    const response = await fetch(targetUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    document.getElementById('table-container').innerHTML = await response.text();
                    window.history.pushState({}, '', targetUrl);
                } catch (error) { console.error(error); } finally { this.loading = false; }
            }
         }"
         @click="if($event.target.closest('.pagination a')) { $event.preventDefault(); fetchSales($event.target.closest('.pagination a').href); }"
         class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12 relative">
        
        <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-50 flex items-center justify-center rounded-2xl">
            <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin"></div>
        </div>

        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Global Sales Ledger</h2>
        </div>

        <div id="table-container">
            @include('admin.sales.partials.table')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size   = 11;
        Chart.defaults.color       = '#94a3b8';

        const canvas = document.getElementById('trendChart');
        if(canvas) {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: 'Revenue',
                            data: @json($trendRevenue),
                            borderColor: '#000000',
                            borderWidth: 2,
                            fill: false, tension: 0.3,
                            pointRadius: 0, pointHoverRadius: 5,
                            yAxisID: 'yRev',
                        },
                        {
                            label: 'Units',
                            data: @json($trendUnits),
                            borderColor: '#e2e8f0',
                            borderWidth: 2,
                            fill: false, tension: 0.3,
                            pointRadius: 0, pointHoverRadius: 5,
                            yAxisID: 'yUnits',
                        }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        yRev: { position: 'left', grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { callback: v => 'RM' + Number(v).toLocaleString() } },
                        yUnits: { position: 'right', grid: { display: false }, border: { display: false } },
                        x: { grid: { display: false }, border: { display: false } }
                    }
                }
            });
        }
    </script>
</x-app-layout>
