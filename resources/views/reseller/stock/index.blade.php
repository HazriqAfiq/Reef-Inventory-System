<x-app-layout title="My Stock">

    <!-- Page Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Verified Shelf Assets</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">My Stock</h1>
            <p class="text-xs text-gray-400 mt-1">Manage local shelf inventory levels and physical safety stock margins.</p>
        </div>
        <a href="{{ route('reseller.audit.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            New Shelf Audit
        </a>
    </div>

    <!-- Inventory KPIs (Admin Catalog Style) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- KPI 1: Total Catalog Products -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total My Products</span>
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 group-hover:bg-black group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ number_format($totalProducts) }}</h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-2 leading-none">Fragrance profiles on shelf</p>
            </div>
        </div>

        <!-- KPI 2: Shelf Stock -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total On-Hand Stock</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ number_format($totalStockUnits) }}</h3>
                <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-wider mt-2 leading-none">Total physical units verified</p>
            </div>
        </div>

        <!-- KPI 3: Average Freshness -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Average Audit Age</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ round($averageAge, 1) }} Days</h3>
                <p class="text-[9px] text-amber-600 font-bold uppercase tracking-wider mt-2 leading-none">Average elapsed count freshness</p>
            </div>
        </div>

        <!-- KPI 4: Low/Out Stock Count -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group duration-300 flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Low / Out Products</span>
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div>
                <h3 class="text-2xl font-black text-gray-900 tracking-tight tabular-nums">{{ $lowStockCount + $outOfStockCount }}</h3>
                <p class="text-[9px] text-red-600 font-bold uppercase tracking-wider mt-2 leading-none">
                    <span class="font-black">{{ $lowStockCount }}</span> Low &middot; <span class="font-black">{{ $outOfStockCount }}</span> Out of Stock
                </p>
            </div>
        </div>
    </div>

    <!-- Search & Filters (Admin Catalog Style) -->
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm mb-8">
        <form method="GET" action="{{ route('reseller.stock.index') }}" class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search product name..." autocomplete="off"
                       class="w-full pl-11 pr-4 py-3 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder:text-gray-400">
            </div>

            <!-- Stock Level filter -->
            <select name="stock" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="">Stock Level</option>
                <option value="high" {{ request('stock') === 'high' ? 'selected' : '' }}>High (> 100)</option>
                <option value="medium" {{ request('stock') === 'medium' ? 'selected' : '' }}>Medium (50–100)</option>
                <option value="low" {{ request('stock') === 'low' ? 'selected' : '' }}>Low (1–49)</option>
                <option value="out" {{ request('stock') === 'out' ? 'selected' : '' }}>Out of Stock</option>
            </select>

            <!-- Volume filter -->
            <select name="volume" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="">Volume</option>
                @foreach($volumes as $vol)
                    <option value="{{ $vol }}" {{ request('volume') == $vol ? 'selected' : '' }}>{{ $vol }}ml</option>
                @endforeach
            </select>

            <!-- Sorting filter -->
            <select name="sort" class="px-5 py-3 text-[10px] font-black text-gray-800 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 uppercase tracking-widest cursor-pointer transition-all hover:bg-gray-100">
                <option value="name" {{ request('sort', 'name') === 'name' ? 'selected' : '' }}>Name A–Z</option>
                <option value="stock_desc" {{ request('sort') === 'stock_desc' ? 'selected' : '' }}>Stock Desc ↓</option>
                <option value="stock_asc" {{ request('sort') === 'stock_asc' ? 'selected' : '' }}>Stock Asc ↑</option>
                <option value="last_audited" {{ request('sort') === 'last_audited' ? 'selected' : '' }}>Last Audited</option>
            </select>

            <button type="submit" class="px-8 py-3 bg-black hover:bg-gray-800 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-sm active:scale-95">Filter</button>
            
            @if(request()->hasAny(['search', 'stock', 'volume', 'sort']))
                <a href="{{ route('reseller.stock.index') }}" class="px-6 py-3 text-[10px] font-black text-gray-400 hover:text-black bg-white border border-gray-100 rounded-xl text-center uppercase tracking-widest transition-all">Reset</a>
            @endif
        </form>
    </div>

    <!-- Product Table Container (Admin Catalog Style) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">My Stock Catalog</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-8 py-4 w-[35%] min-w-[240px] text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Product</th>
                        <th class="px-8 py-4 w-[10%] min-w-[80px] text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Volume</th>
                        <th class="px-8 py-4 w-[15%] min-w-[140px] text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Market Value Pricing</th>
                        <th class="px-8 py-4 w-[25%] min-w-[180px] text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">My Shelf Stock</th>
                        <th class="px-8 py-4 w-[15%] min-w-[120px] text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Audit Freshness</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                    @forelse($stocks as $stock)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            {{-- Product Detail --}}
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                                        @if($stock->product?->primaryImage)
                                            <img src="{{ asset('storage/' . $stock->product->primaryImage->image_path) }}" class="w-full h-full object-contain">
                                        @else
                                            <div class="text-[9px] font-black text-gray-300">Code</div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $stock->product?->name }}</p>
                                        <div class="flex items-center gap-1.5 mt-1">
                                            <span class="font-mono text-[9px] font-bold text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 leading-none uppercase tracking-wider">{{ $stock->product?->sku }}</span>
                                            @if($stock->product?->category)
                                                <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded leading-none border border-indigo-100/50">{{ $stock->product->category->name }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Volume --}}
                            <td class="px-8 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex px-2 py-0.5 bg-gray-50 border border-gray-100 rounded text-[9px] font-black text-gray-500 uppercase tracking-wider">
                                    {{ $stock->product?->volume_ml }} ml
                                </span>
                            </td>

                            {{-- Pricing --}}
                            <td class="px-8 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex flex-col items-end">
                                    <p class="text-sm font-black text-gray-900 leading-none">RM{{ number_format($stock->product?->retail_price, 2) }}</p>
                                    <span class="text-[8px] font-bold text-gray-400 mt-1 uppercase tracking-widest">Est. Valuation: RM{{ number_format($stock->quantity * ($stock->product?->retail_price ?? 0), 2) }}</span>
                                </div>
                            </td>

                            {{-- Shelf Stock Progress Bar --}}
                            <td class="px-8 py-4 min-w-[180px]">
                                @php
                                    $qty = $stock->quantity;
                                    $percent = min(max(($qty / 100) * 100, 2), 100); 
                                    if($qty == 0) $percent = 0;
                                    
                                    if ($qty === 0) {
                                        $barColor = 'bg-rose-500';
                                    } elseif ($qty < 15) {
                                        $barColor = 'bg-amber-500';
                                    } else {
                                        $barColor = 'bg-emerald-500';
                                    }
                                @endphp
                                <div class="mb-1.5 flex items-center justify-between gap-4 leading-none">
                                    <span class="text-xs font-black text-gray-900 tabular-nums leading-none">
                                        {{ number_format($qty) }}
                                        <span class="text-[8px] text-gray-400 font-black uppercase tracking-wider ml-0.5 leading-none">Verified units</span>
                                    </span>
                                    @if($qty < 15)
                                        <span class="text-[8px] font-black uppercase text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded leading-none border border-amber-100/40">Low</span>
                                    @endif
                                </div>
                                <div class="w-full bg-gray-50 h-1 rounded-full overflow-hidden relative border border-gray-100">
                                    <div class="h-full rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                                </div>
                            </td>

                            {{-- Audit Freshness --}}
                            <td class="px-8 py-4 text-center whitespace-nowrap">
                                @php
                                    $days = $stock->updated_at ? $stock->updated_at->diffInDays(now()) : 99;
                                    if ($days <= 1) {
                                        $badge = 'bg-emerald-50 text-emerald-600 border-emerald-100/40';
                                        $label = 'Verified Today';
                                    } elseif ($days <= 7) {
                                        $badge = 'bg-indigo-50 text-indigo-600 border-indigo-100/40';
                                        $label = 'Verified Recent';
                                    } else {
                                        $badge = 'bg-rose-50 text-rose-600 border-rose-100/40';
                                        $label = 'Audit Stale';
                                    }
                                @endphp
                                <div class="inline-flex flex-col items-center leading-none">
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border {{ $badge }} leading-none">
                                        {{ $label }}
                                    </span>
                                    <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider block mt-1 leading-none">{{ $stock->updated_at ? $stock->updated_at->diffForHumans() : 'Never' }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No Products Found</p>
                                    <p class="text-xs text-gray-400 mt-1">Try adjusting your filters or complete a new shelf audit.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stocks->hasPages())
            <div class="px-6 py-5 border-t border-gray-50">
                {{ $stocks->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
