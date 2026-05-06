<x-app-layout title="Partner Workspace">
    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Partner Workspace</h1>
        <p class="text-sm text-gray-500 mt-1">Your personal sales performance, earnings, and inventory overview.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Lifetime Volume -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lifetime Volume</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM{{ number_format($myTotalRevenue, 0) }}</h3>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">{{ number_format($myTotalSales) }} txns</span>
            </div>
        </div>

        <!-- Current Month -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Current Month</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM{{ number_format($thisMonthRevenue, 0) }}</h3>
                @if($revenueChange !== null)
                    <span class="text-[10px] font-bold {{ $revenueChange >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-1 rounded-lg">
                        {{ $revenueChange >= 0 ? '+' : '' }}{{ $revenueChange }}%
                    </span>
                @endif
            </div>
        </div>

        <!-- Earnings -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">My Earnings</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM{{ number_format($myCommission, 0) }}</h3>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Commission</span>
            </div>
        </div>

        <!-- Personal Stock -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Personal Stock</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">{{ number_format($myTotalUnits) }}</h3>
                <span class="text-[10px] font-bold {{ $lowStockProducts->count() > 0 ? 'text-amber-600 bg-amber-50' : 'text-gray-500 bg-gray-50' }} px-2 py-1 rounded-lg">
                    {{ $lowStockProducts->count() > 0 ? $lowStockProducts->count() . ' Low' : 'Stable' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm mb-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Sales Trend</h2>
                <p class="text-xs text-gray-400 mt-1">Daily revenue & volume analysis</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Revenue</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-indigo-200"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Units</span>
                </div>
            </div>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="mainSalesChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Top Products -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Product Performance</h2>
            <div class="h-[300px]">
                <canvas id="topSellersChart"></canvas>
            </div>
        </div>

        <!-- Goal Progress -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden relative" x-data="{ editing: false }">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Monthly Goal</h2>
                <button @click="editing = true" class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition-colors">Adjust</button>
            </div>
            <div class="p-6">
                @if($monthlyGoal > 0)
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative w-28 h-28 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90">
                                <circle cx="56" cy="56" r="50" stroke="currentColor" stroke-width="6" fill="transparent" class="text-gray-100"/>
                                <circle cx="56" cy="56" r="50" stroke="currentColor" stroke-width="6" fill="transparent" class="text-black" stroke-dasharray="{{ 2 * pi() * 50 }}" stroke-dashoffset="{{ (1 - ($goalProgress / 100)) * (2 * pi() * 50) }}" style="transition: stroke-dashoffset 1s ease-in-out;"/>
                            </svg>
                            <div class="absolute flex flex-col items-center">
                                <span class="text-xl font-bold text-gray-900">{{ $goalProgress }}%</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Target</p>
                            <h4 class="text-lg font-bold text-gray-900">RM{{ number_format($monthlyGoal, 0) }}</h4>
                            <p class="text-[10px] font-bold text-gray-400 mt-1">RM{{ number_format($thisMonthRevenue, 2) }} earned</p>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-6">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">No Goal Set</p>
                        <button @click="editing = true" class="px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">Set Target</button>
                    </div>
                @endif
            </div>

            <!-- Goal Edit Overlay -->
            <div x-show="editing" x-cloak class="absolute inset-0 bg-white/95 backdrop-blur-sm z-20 p-6 flex flex-col justify-center rounded-2xl">
                <form action="{{ route('reseller.dashboard.goal') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3 block text-center">Monthly Goal (RM)</label>
                        <input type="number" name="monthly_goal" value="{{ $monthlyGoal }}" class="w-full bg-gray-50 border-gray-100 rounded-xl px-4 py-3 text-center text-xl font-bold focus:ring-2 focus:ring-black/10 focus:border-black transition-all">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-black text-white text-xs font-bold uppercase tracking-widest py-3 rounded-xl hover:bg-gray-800 transition-all shadow-sm">Save</button>
                        <button type="button" @click="editing = false" class="px-5 bg-gray-100 text-gray-600 text-xs font-bold uppercase tracking-widest py-3 rounded-xl hover:bg-gray-200 transition-all">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Operational Context -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <!-- Low Stock Alerts -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Stock Alerts</h2>
                <a href="{{ route('reseller.orders.create') }}" class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition-colors">Restock</a>
            </div>
            <div class="p-6 space-y-4">
                @forelse($lowStockProducts->take(4) as $p)
                    @php
                        $statusColor = $p->quantity <= 5 ? 'bg-rose-500' : ($p->quantity < 15 ? 'bg-amber-500' : 'bg-emerald-500');
                        $dotColor = $p->quantity <= 5 ? 'bg-rose-500' : ($p->quantity < 15 ? 'bg-amber-500' : 'bg-emerald-500');
                    @endphp
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 rounded-full {{ $dotColor }}"></div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-900">{{ $p->product?->name }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $p->quantity }} units remaining</p>
                        </div>
                    </div>
                @empty
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                        <p class="text-xs font-bold text-gray-700">All stock levels healthy</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Sales -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30 flex items-center justify-between">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Recent Sales</h2>
                <a href="{{ route('reseller.sales.index') }}" class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-wider transition-colors">View All</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($myRecentSales->take(4) as $sale)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                        <div>
                            <p class="text-xs font-bold text-gray-900 truncate w-32">{{ $sale->product->name }}</p>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $sale->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs font-bold text-gray-900">RM{{ number_format($sale->total_price, 0) }}</span>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">No sales yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        var commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        };

        // Sales Trend
        new Chart(document.getElementById('mainSalesChart'), {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [
                    {
                        data: @json($trendRevenue),
                        borderColor: '#6366f1',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3,
                        yAxisID: 'y'
                    },
                    {
                        data: @json($trendUnits),
                        borderColor: '#c7d2fe',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { callback: v => 'RM' + v.toLocaleString() } },
                    y1: { beginAtZero: true, position: 'right', grid: { display: false }, border: { display: false }, ticks: { display: false } },
                    x: { grid: { display: false }, border: { display: false }, ticks: { maxTicksLimit: 7 } }
                }
            }
        });

        // Product Performance
        new Chart(document.getElementById('topSellersChart'), {
            type: 'bar',
            data: {
                labels: @json($topProductLabels),
                datasets: [{
                    data: @json($topProductData),
                    backgroundColor: '#6366f1',
                    borderRadius: 4,
                    barThickness: 16
                }]
            },
            options: {
                indexAxis: 'y',
                ...commonOptions,
                scales: {
                    x: { grid: { display: false }, ticks: { display: false } },
                    y: { grid: { display: false }, ticks: { font: { weight: 'bold' }, color: '#1f2937' } }
                }
            }
        });
    </script>
</x-app-layout>
