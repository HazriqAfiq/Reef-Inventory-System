<x-app-layout title="Inventory Audit Workspace">
    <div class="relative">
        
        <!-- Page Header -->
        <div class="mb-10">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Shelf Audit Terminal</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Inventory Audit Desk</h1>
            <p class="text-xs text-gray-400 mt-1">Verify and enter physical count counts for every product. The system maps verification timestamps to maintain accuracy.</p>
        </div>

        <form action="{{ route('reseller.dashboard.audit') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Health Metric Card -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-gray-900 uppercase tracking-widest">Current Audit Health: {{ $auditHealthPercentage }}%</h4>
                        <p class="text-xs text-gray-400 mt-0.5">Target: 100% of products audited within the last 7 days.</p>
                    </div>
                </div>
                
                <div class="w-full md:w-64">
                    <div class="w-full h-2 bg-gray-100 rounded-full overflow-hidden mb-1">
                        <div class="h-full {{ $auditHealthPercentage >= 80 ? 'bg-emerald-500' : 'bg-amber-500' }} rounded-full transition-all duration-500" style="width: {{ $auditHealthPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Stock Audit Ledger Form List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Active Shelf Count Entry List</span>
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ $myStocks->count() }} Products Available</span>
                </div>

                <div class="divide-y divide-gray-100 p-6 space-y-4">
                    @foreach($myStocks as $stock)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50/60 border border-gray-100/70 rounded-xl gap-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3.5 min-w-0">
                                <div class="w-11 h-11 rounded-lg bg-white border border-gray-150 p-1 shrink-0 overflow-hidden flex items-center justify-center shadow-sm">
                                    @if($stock->product?->primaryImage)
                                        <img src="{{ asset('storage/' . $stock->product->primaryImage->image_path) }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="text-[9px] font-black text-gray-300">Code</div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-black text-gray-900 truncate">{{ $stock->product?->name }}</h4>
                                    <div class="flex items-center gap-1.5 mt-0.5 text-[9px] text-gray-400 font-bold uppercase tracking-widest">
                                        <span>{{ $stock->product?->sku }}</span>
                                        <span>&middot;</span>
                                        <span>{{ $stock->product?->volume_ml }}ml</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                <!-- Status Badge -->
                                <div class="text-left sm:text-right">
                                    <span class="px-2.5 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $stock->freshness_badge_color }}">
                                        {{ $stock->freshness_status }}
                                    </span>
                                    <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider block mt-1">Verified: {{ $stock->updated_at ? $stock->updated_at->diffForHumans() : 'Never' }}</span>
                                </div>

                                <!-- Incremental Qty Entry Controller -->
                                <div class="flex items-center bg-white border border-gray-200 rounded-xl p-1 shadow-sm shrink-0">
                                    <button type="button" @click="const inp = $el.nextElementSibling; inp.value = Math.max(0, parseInt(inp.value) - 1);" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg font-black text-xs transition-colors">-</button>
                                    <input type="number" name="stocks[{{ $stock->id }}]" value="{{ $stock->quantity }}" min="0" class="w-12 bg-transparent border-0 text-center text-xs font-black focus:ring-0 p-0 text-gray-900">
                                    <button type="button" @click="const inp = $el.previousElementSibling; inp.value = parseInt(inp.value) + 1;" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg font-black text-xs transition-colors">+</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer Action Bar -->
                <div class="px-8 py-4 border-t border-gray-50 bg-gray-50/20 flex items-center justify-end gap-3 shrink-0">
                    <a href="{{ route('reseller.dashboard') }}" class="px-5 py-3 text-gray-600 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-black text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-md">
                        Submit Shelf Audit
                    </button>
                </div>
            </div>
        </form>

    </div>
</x-app-layout>
