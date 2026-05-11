<x-app-layout title="Command Center">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">HQ Operations Live</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Command Center</h1>
            <p class="text-xs text-gray-400 mt-1">Real-time order tracking, stock levels, and reseller performance.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm flex items-center gap-2 text-xs font-bold text-gray-600">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>Role: Admin Control</span>
            </div>
        </div>
    </div>

    <!-- Overview KPI Cards (Critical numbers only) -->
    <div class="grid grid-cols-2 lg:grid-cols-7 gap-4 mb-8">
        <!-- Card 1: Total Accumulated Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Revenue</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM{{ number_format($totalRevenue, 0) }}</h3>
            </div>
            <p class="text-[9px] text-indigo-600 font-bold uppercase tracking-wider mt-2 leading-none">All-time wholesale revenue</p>
        </div>

        <!-- Card 2: Monthly Sales Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Monthly Wholesale Revenue</span>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-600 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">RM{{ number_format($monthlyRevenue, 0) }}</h3>
            </div>
            <p class="text-[9px] text-rose-600 font-bold uppercase tracking-wider mt-2 leading-none">
                {{ $monthlyOrdersCount }} {{ Str::plural('order', $monthlyOrdersCount) }} this month
            </p>
        </div>

        <!-- Card 3: Total Products -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Catalog Products</span>
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 group-hover:bg-brand group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($totalProducts) }}</h3>
            </div>
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-2 leading-none">Total products in catalog</p>
        </div>

        <!-- Card 4: Total Stock Units -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Headquarters Stock</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($totalStockUnits) }}</h3>
            </div>
            <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 leading-none">Available stock units</p>
        </div>

        <!-- Card 5: Low Stock Items -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Low Stock Items</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($lowStockProductsCount) }}</h3>
            </div>
            <p class="text-[9px] text-amber-600 font-bold uppercase tracking-wider mt-2 leading-none">Products needing restock</p>
        </div>

        <!-- Card 6: Out of Stock Items -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Out of Stock Items</span>
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($outOfStockProductsCount) }}</h3>
            </div>
            <p class="text-[9px] text-red-600 font-bold uppercase tracking-wider mt-2 leading-none">Products completely out</p>
        </div>

        <!-- Card 7: Total Active Resellers -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Active Resellers</span>
                    <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center text-violet-600 group-hover:bg-violet-500 group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857"/></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums truncate">{{ number_format($totalResellers) }}</h3>
            </div>
            <p class="text-[9px] text-violet-600 font-bold uppercase tracking-wider mt-2 leading-none">Registered partners</p>
        </div>
    </div>

    <!-- Sales & Order Analytics Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Left 2/3: Orders Trend Graph -->
        <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-2xl border border-gray-100 shadow-sm flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-black"></span>
                        30-Day Wholesale Revenue & Order Trends
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Total wholesale revenue and order count history</p>
                </div>
                
                <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-gray-400 shrink-0">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-gray-900">Revenue (RM)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        <span class="text-gray-900">Order count</span>
                    </div>
                </div>
            </div>
            
            <div class="flex-1 min-h-[300px] h-[300px]">
                <canvas id="ordersTrendChart"></canvas>
            </div>
        </div>

        <!-- Right Column: Inventory Alerts (Moved next to analytics graph) -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3 shrink-0">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Stock Levels & Warnings
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Out of stock and low stock products requiring attention</p>
                </div>
            </div>

            <!-- Content Area (Single Unified List) -->
            <div class="p-6 flex-1 overflow-y-auto max-h-[300px]">
                <div class="space-y-3">
                    @php $hasAlerts = false; @endphp

                    <!-- 1. Out of Stock items first (Critical Priority) -->
                    @foreach($outOfStockItems as $product)
                        @php $hasAlerts = true; @endphp
                        <div class="flex items-center justify-between p-3 bg-rose-50/20 border border-rose-100/50 rounded-xl hover:bg-rose-50/50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-white border border-gray-100 p-1 shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="text-[10px] font-black text-gray-300">SKU</div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-gray-900 truncate">{{ $product->name }}</h4>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $product->sku }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right">
                                    <span class="text-[10px] font-black text-rose-600 tabular-nums bg-rose-50 border border-rose-100 px-2.5 py-1 rounded-lg">Out of stock</span>
                                </div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-[10px] font-black uppercase tracking-wider text-black hover:opacity-75 transition-opacity px-2.5 py-1.5 bg-white border border-gray-150 rounded-lg shadow-sm">
                                    Restock
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- 2. Low Stock items second (Warning Priority) -->
                    @foreach($lowStockItems as $product)
                        @php $hasAlerts = true; @endphp
                        <div class="flex items-center justify-between p-3 bg-amber-50/20 border border-amber-100/50 rounded-xl hover:bg-amber-50/50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-lg bg-white border border-gray-100 p-1 shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="text-[10px] font-black text-gray-300">SKU</div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-gray-900 truncate">{{ $product->name }}</h4>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $product->sku }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <div class="text-right">
                                    <span class="text-[10px] font-black text-amber-600 tabular-nums bg-amber-50 border border-amber-100 px-2.5 py-1 rounded-lg">{{ $product->stock }} left</span>
                                </div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-[10px] font-black uppercase tracking-wider text-black hover:opacity-75 transition-opacity px-2.5 py-1.5 bg-white border border-gray-150 rounded-lg shadow-sm">
                                    Restock
                                </a>
                            </div>
                        </div>
                    @endforeach

                    <!-- 3. Empty State -->
                    @if(!$hasAlerts)
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-900">Zero inventory alerts!</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">All warehouse stock levels are healthy.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Powerhouse Leaders and Reseller Activity Section -->
    <div x-data="{
        activeFilter: 'month',
        resellerTotals: {
            month: {{ $topResellersMonth->sum('wholesale_spend') }},
            year: {{ $topResellersYear->sum('wholesale_spend') }},
            total: {{ $topResellersTotal->sum('wholesale_spend') }}
        },
        formatRM(val) {
            return 'RM' + Number(val).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
    }" x-init="$watch('activeFilter', val => updateDashboardCharts(val))">
        
        <!-- Row Header with Period Filter Segment Control -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                    Performance & Network Leaders
                </h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Real-time statistics of product movement and reseller acquisitions</p>
            </div>
            
            <!-- Segment Control Button Group -->
            <div class="inline-flex bg-gray-100 p-1 rounded-xl shadow-inner shrink-0">
                <button @click="activeFilter = 'month'" :class="activeFilter === 'month' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150">
                    This Month
                </button>
                <button @click="activeFilter = 'year'" :class="activeFilter === 'year' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150">
                    This Year
                </button>
                <button @click="activeFilter = 'total'" :class="activeFilter === 'total' ? 'bg-white text-black shadow-sm' : 'text-gray-500 hover:text-black'" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all duration-150">
                    All-Time
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 items-stretch">
        
        <!-- Column 1: Top Selling Products -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3 shrink-0">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                        Top Wholesale Products
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Highest volume catalog items purchased by resellers</p>
                </div>
            </div>

            <div class="p-6 flex-1 flex flex-col justify-center items-center">
                @if(isset($topSellingProducts) && $topSellingProducts->count() > 0)
                    <div class="w-full h-[280px] relative">
                        <canvas id="topWholesaleProductsChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400 text-xs">No product sales yet.</div>
                @endif
            </div>
        </div>

        <!-- Column 2: Top Resellers by Spend -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between gap-3 shrink-0">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                        Top Resellers by Items
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Partners with the highest wholesale items purchased</p>
                </div>
            </div>

            <div class="p-6 flex-1 flex flex-col justify-center items-center">
                @if(isset($topResellers) && $topResellers->count() > 0)
                    <div class="w-full h-[280px] relative">
                        <canvas id="topResellersSpendChart"></canvas>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400 text-xs">No reseller items purchased recorded.</div>
                @endif
            </div>
        </div>

        <!-- Column 3: Reseller Spend Share -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span>
                        Reseller Distribution
                    </h2>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Wholesale spend distribution among all resellers</p>
                </div>
            </div>

            <div class="p-6 flex-1 flex flex-col justify-center items-center">
                @if(isset($topResellers) && $topResellers->count() > 0)
                    <div class="w-full h-[280px] relative flex items-center justify-center">
                        <canvas id="resellerSpendShareChart"></canvas>
                        <!-- Center Info Overlay -->
                        <div class="absolute flex flex-col items-center justify-center text-center pointer-events-none mb-8">
                            <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none">Total Spend</span>
                            <span class="text-xs font-black text-gray-900 mt-1 tabular-nums leading-none" x-text="formatRM(resellerTotals[activeFilter])"></span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-400 text-xs">No reseller spend recorded.</div>
                @endif
            </div>
        </div>

    </div>
    </div>

    <!-- Recent Wholesale Orders (Full Width Table) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col mb-10">
        <div class="px-6 py-4 border-b border-gray-50 bg-gray-50/20 shrink-0 flex items-center justify-between">
            <div>
                <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Latest Wholesale Orders
                </h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Recent orders submitted by resellers waiting for delivery</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black uppercase tracking-wider text-black hover:underline shrink-0">
                View All Orders &rarr;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Order ID</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Reseller</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Items Qty</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total Price</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Order Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-black text-black hover:underline">
                                    #{{ $order->id }}
                                </a>
                                <p class="text-[9px] text-gray-400 font-semibold mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5 truncate max-w-[150px]">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums">
                                {{ $order->total_quantity ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                                RM{{ number_format($order->total_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @php
                                    $statusColors = [
                                        'pending'    => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'paid'       => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'shipped'    => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'delivered'  => 'bg-teal-50 text-teal-600 border-teal-100',
                                        'cancelled'  => 'bg-gray-50 text-gray-500 border-gray-100',
                                    ];
                                    $badgeStyle = $statusColors[strtolower($order->status)] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border {{ $badgeStyle }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                No recent wholesale orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.font.size = 11;

        // Dual Axis Line Chart for Orders Trend
        const ctx = document.getElementById('ordersTrendChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($trendLabels),
                    datasets: [
                        {
                            label: 'Wholesale Revenue (RM)',
                            data: @json($trendRevenue),
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            fill: true,
                            borderWidth: 2.5,
                            pointRadius: 1,
                            pointHoverRadius: 4,
                            tension: 0.35,
                            yAxisID: 'y'
                        },
                        {
                            label: 'Wholesale Order Count',
                            data: @json($trendCount),
                            borderColor: '#6366f1',
                            backgroundColor: 'rgba(99, 102, 241, 0.05)',
                            fill: true,
                            borderWidth: 2.5,
                            pointRadius: 1,
                            pointHoverRadius: 4,
                            tension: 0.35,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            padding: 12,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { weight: 'black', size: 12 },
                            bodyFont: { weight: 'bold', size: 11 }
                        }
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            grid: { color: '#f1f5f9' },
                            border: { display: false },
                            ticks: {
                                callback: function(value) { return 'RM' + value; },
                                font: { weight: 'bold' }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            border: { display: false },
                            ticks: {
                                stepSize: 1,
                                font: { weight: 'bold' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { weight: 'bold' } }
                        }
                    }
                }
            });
        }

        // Global variables for multi-period charts
        let productChartInstance, resellerChartInstance, spendShareChartInstance;

        // Datasets mapping for dynamic filtering
        const productDatasets = {
            month: {
                labels: @json($topSellingProductsMonth->pluck('name')),
                qty: @json($topSellingProductsMonth->map(fn($p) => (int)($p->wholesale_qty ?? 0))->values()),
                revenue: @json($topSellingProductsMonth->map(fn($p) => round((float)($p->wholesale_revenue ?? 0), 2))->values())
            },
            year: {
                labels: @json($topSellingProductsYear->pluck('name')),
                qty: @json($topSellingProductsYear->map(fn($p) => (int)($p->wholesale_qty ?? 0))->values()),
                revenue: @json($topSellingProductsYear->map(fn($p) => round((float)($p->wholesale_revenue ?? 0), 2))->values())
            },
            total: {
                labels: @json($topSellingProductsTotal->pluck('name')),
                qty: @json($topSellingProductsTotal->map(fn($p) => (int)($p->wholesale_qty ?? 0))->values()),
                revenue: @json($topSellingProductsTotal->map(fn($p) => round((float)($p->wholesale_revenue ?? 0), 2))->values())
            }
        };

        const resellerDatasets = {
            month: {
                labels: @json($topResellersMonth->pluck('name')),
                spend: @json($topResellersMonth->map(fn($r) => round((float)($r->wholesale_spend ?? 0), 2))->values()),
                items: @json($topResellersMonth->map(fn($r) => (int)($r->wholesale_items ?? 0))->values()),
                orders: @json($topResellersMonth->pluck('orders_count'))
            },
            year: {
                labels: @json($topResellersYear->pluck('name')),
                spend: @json($topResellersYear->map(fn($r) => round((float)($r->wholesale_spend ?? 0), 2))->values()),
                items: @json($topResellersYear->map(fn($r) => (int)($r->wholesale_items ?? 0))->values()),
                orders: @json($topResellersYear->pluck('orders_count'))
            },
            total: {
                labels: @json($topResellersTotal->pluck('name')),
                spend: @json($topResellersTotal->map(fn($r) => round((float)($r->wholesale_spend ?? 0), 2))->values()),
                items: @json($topResellersTotal->map(fn($r) => (int)($r->wholesale_items ?? 0))->values()),
                orders: @json($topResellersTotal->pluck('orders_count'))
            }
        };

        // Variable tracker to keep the current filter reference inside tooltips
        let currentFilterPeriod = 'month';

        // Dynamic update function called by Alpine.js $watch
        window.updateDashboardCharts = function(period) {
            currentFilterPeriod = period;

            // 1. Update Product Chart
            if (productChartInstance) {
                productChartInstance.data.labels = productDatasets[period].labels;
                productChartInstance.data.datasets[0].data = productDatasets[period].qty;
                productChartInstance.update();
            }

            // 2. Update Reseller Chart (Counted by Items/Units)
            if (resellerChartInstance) {
                resellerChartInstance.data.labels = resellerDatasets[period].labels;
                resellerChartInstance.data.datasets[0].data = resellerDatasets[period].items;
                resellerChartInstance.update();
            }

            // 3. Update Spend Share Doughnut Chart
            if (spendShareChartInstance) {
                spendShareChartInstance.data.labels = resellerDatasets[period].labels;
                spendShareChartInstance.data.datasets[0].data = resellerDatasets[period].spend;
                spendShareChartInstance.update();
            }
        };

        // Reseller Spend Share Doughnut Chart
        const pieCtx = document.getElementById('resellerSpendShareChart');
        if (pieCtx) {
            spendShareChartInstance = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: resellerDatasets[currentFilterPeriod].labels,
                    datasets: [{
                        data: resellerDatasets[currentFilterPeriod].spend,
                        backgroundColor: [
                            '#4f46e5', // Deep Royal Indigo
                            '#06b6d4', // Vibrant Cyan
                            '#10b981', // Vibrant Emerald Green
                            '#f59e0b', // Warm Amber Orange
                            '#ec4899'  // Elegant Rose Pink
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                padding: 12,
                                font: {
                                    weight: 'bold',
                                    size: 10
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return ' ' + context.label + ': RM' + value.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' (' + percentage + '%)';
                                }
                            },
                            padding: 12,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { weight: 'black', size: 11 },
                            bodyFont: { weight: 'bold', size: 10 }
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // 1. Top Wholesale Products Horizontal Bar Chart
        const barCtx1 = document.getElementById('topWholesaleProductsChart');
        if (barCtx1) {
            productChartInstance = new Chart(barCtx1, {
                type: 'bar',
                data: {
                    labels: productDatasets[currentFilterPeriod].labels,
                    datasets: [{
                        label: 'Units Sold',
                        data: productDatasets[currentFilterPeriod].qty,
                        backgroundColor: '#1e293b',
                        hoverBackgroundColor: '#0f172a',
                        borderRadius: 6,
                        barThickness: 16
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const revenues = productDatasets[currentFilterPeriod].revenue;
                                    const value = context.raw || 0;
                                    const rev = revenues[context.dataIndex] || 0;
                                    return ' ' + value.toLocaleString() + ' units (RM' + rev.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + ')';
                                }
                            },
                            padding: 10,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { weight: 'black', size: 11 },
                            bodyFont: { weight: 'bold', size: 10 }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { weight: 'bold' } }
                        },
                        y: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                font: { weight: 'bold' },
                                color: '#1e293b'
                            }
                        }
                    }
                }
            });
        }

        // 2. Top Resellers Items Purchased Horizontal Bar Chart
        const barCtx2 = document.getElementById('topResellersSpendChart');
        if (barCtx2) {
            resellerChartInstance = new Chart(barCtx2, {
                type: 'bar',
                data: {
                    labels: resellerDatasets[currentFilterPeriod].labels,
                    datasets: [{
                        label: 'Items Purchased',
                        data: resellerDatasets[currentFilterPeriod].items,
                        backgroundColor: '#4f46e5',
                        hoverBackgroundColor: '#4338ca',
                        borderRadius: 6,
                        barThickness: 16
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw || 0; // items
                                    const spend = resellerDatasets[currentFilterPeriod].spend[context.dataIndex] || 0;
                                    const orderCount = resellerDatasets[currentFilterPeriod].orders[context.dataIndex] || 0;
                                    return ' ' + value.toLocaleString() + ' units purchased (RM' + spend.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2}) + ' spend across ' + orderCount + 'x orders)';
                                }
                            },
                            padding: 10,
                            backgroundColor: 'rgba(0,0,0,0.85)',
                            titleFont: { weight: 'black', size: 11 },
                            bodyFont: { weight: 'bold', size: 10 }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                callback: function(value) { return value.toLocaleString() + ' units'; },
                                font: { weight: 'bold' }
                            }
                        },
                        y: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: {
                                font: { weight: 'bold' },
                                color: '#1e293b'
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
