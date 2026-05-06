<x-app-layout title="Dashboard">
    <!-- Page Header -->
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Overview</h1>
        <p class="text-sm text-gray-500 mt-1">Real-time performance analytics across your reseller network.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Wholesale Revenue -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Wholesale Revenue</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">RM{{ number_format($wholesaleRevenue, 0) }}</h3>
                @if($incomeChange !== null)
                    <span class="text-[10px] font-bold {{ $incomeChange >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} px-2 py-1 rounded-lg">
                        {{ $incomeChange >= 0 ? '+' : '' }}{{ $incomeChange }}%
                    </span>
                @endif
            </div>
        </div>

        <!-- Wholesale Units Supplied -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Supplied Units</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">{{ number_format($wholesaleUnitsSold) }}</h3>
                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">B2B Volume</span>
            </div>
        </div>

        <!-- Active Resellers -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Partners</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">{{ $activeResellers }}</h3>
                <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-1 rounded-lg">Resellers</span>
            </div>
        </div>

        <!-- HQ Inventory -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">HQ Stock</span>
            </div>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-bold text-gray-900 tabular-nums">{{ number_format($adminStock) }}</h3>
                @if($lowStockCount > 0)
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">{{ $lowStockCount }} Alerts</span>
                @else
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">Healthy</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Sales Chart -->
    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm mb-10">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Sell-In vs Sell-Out Velocity</h2>
                <p class="text-xs text-gray-400 mt-1">Comparison of HQ wholesale supply vs Reseller retail sales</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">HQ Supply (Sell-In)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    <span class="text-[10px] font-bold text-gray-500 uppercase">Reseller Sales (Sell-Out)</span>
                </div>
            </div>
        </div>
        <div class="h-[350px] w-full">
            <canvas id="mainSalesChart"></canvas>
        </div>
    </div>

    <div class="mb-10">
        <!-- Top Products -->
        <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-6">Product Performance</h2>
            <div class="h-[300px]">
                <canvas id="topProductsBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Operational Context -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <!-- Alerts -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/30">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Operational Alerts</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Growth Spike</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">+18% Velocity Identified</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Restock Alert</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $lowStockCount }} SKUs Below Threshold</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-gray-900">Partner Lead</p>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5">Top Performer Found</p>
                    </div>
                </div>
            </div>
        </div>



        <!-- Recent Wholesale Orders -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/20">
                <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Recent Wholesale Orders</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($recentWholesaleOrders as $order)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                        <div>
                            <p class="text-xs font-bold text-gray-900 truncate w-32">{{ $order->user->name }}</p>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest {{ $order->status === 'paid' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                {{ $order->status }}
                            </span>
                            <span class="text-xs font-bold text-gray-900">RM{{ number_format($order->total_price, 0) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Performance Ledger -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-10">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Performance Index</h2>
            <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Top Performers</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/10">
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Asset</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Volume</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Revenue</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Stock Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($topProductsChart->take(5) as $product)
                        <tr class="hover:bg-gray-50/30 transition-all">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-gray-50 border border-gray-100 p-1 shrink-0 overflow-hidden">
                                        @if($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-contain">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $product->category?->name ?? 'Series' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center text-xs font-bold text-gray-900">
                                {{ number_format($product->sales_sum_quantity ?? 0) }}
                            </td>
                            <td class="px-8 py-5 text-right text-xs font-bold text-gray-900">
                                RM{{ number_format($product->sales_sum_total_price ?? 0, 0) }}
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest {{ $product->stock > 50 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                    {{ $product->stock > 50 ? 'In Stock' : 'Low Stock' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        };

        // Main Sales Chart
        new Chart(document.getElementById('mainSalesChart'), {
            type: 'line',
            data: {
                labels: @json($trendLabels),
                datasets: [
                    {
                        data: @json($trendWholesale),
                        borderColor: '#10b981',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3
                    },
                    {
                        data: @json($trendNetwork),
                        borderColor: '#8b5cf6',
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.3
                    }
                ]
            },
            options: commonOptions
        });

        // Top Products Bar
        new Chart(document.getElementById('topProductsBarChart'), {
            type: 'bar',
            data: {
                labels: @json($topProductLabels->take(5)),
                datasets: [{
                    data: @json($topProductData->take(5)),
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
