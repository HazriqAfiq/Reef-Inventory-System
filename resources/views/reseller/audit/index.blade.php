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

        <form action="{{ route('reseller.dashboard.audit') }}" method="POST" 
              x-data="{ showConfirm: false }" 
              @submit.prevent="showConfirm = true" 
              class="space-y-8">
            @csrf

            <!-- Integrity & Instructions Banner -->
            <div class="bg-amber-50/50 border border-amber-100 rounded-2xl p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 border border-amber-200">
                    <svg class="w-5 h-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-black text-amber-900 uppercase tracking-widest">Shelf Count Integrity Rules</h4>
                    <p class="text-[11px] text-amber-700/80 mt-1 leading-relaxed font-medium">
                        To maintain stock reporting compliance, entered quantities represent physical counts currently verified on your shelf. 
                        Your entered physical stock <strong>cannot exceed your historical restock purchases</strong>. Over-reporting is locked automatically by the system.
                    </p>
                </div>
            </div>

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
                        <div x-data="{ qty: {{ $stock->quantity }}, originalQty: {{ $stock->quantity }}, maxQty: {{ $stock->total_restocked }} }"
                             :class="qty !== originalQty ? 'border-amber-200/80 bg-amber-50/15' : 'border-gray-100/70 bg-gray-50/60'"
                             class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border rounded-xl gap-4 hover:bg-gray-50 transition-all duration-300">
                            
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
                                    <div class="mt-2 flex flex-wrap items-center gap-1.5 font-semibold">
                                        <span class="inline-flex items-center text-[8px] font-bold text-gray-500 bg-gray-100/80 px-2 py-0.5 rounded uppercase tracking-wider border border-gray-150">
                                            System Stock Exist: {{ $stock->quantity }}
                                        </span>
                                        <span class="inline-flex items-center text-[8px] font-black text-gray-700 bg-gray-150 px-2 py-0.5 rounded uppercase tracking-wider border border-gray-200 animate-pulse">
                                            Max Audit Limit: {{ $stock->total_restocked }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between sm:justify-end gap-4 shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0 border-gray-100">
                                <!-- Status Badge -->
                                <div class="text-left sm:text-right flex flex-col items-start sm:items-end gap-1.5">
                                    <template x-if="qty !== originalQty">
                                        <span class="px-2.5 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 animate-pulse">
                                            Modified Count
                                        </span>
                                    </template>
                                    <template x-if="qty === originalQty">
                                        <span class="px-2.5 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $stock->freshness_badge_color }}">
                                            {{ $stock->freshness_status }}
                                        </span>
                                    </template>
                                    <span class="text-[8px] text-gray-400 font-bold uppercase tracking-wider">Verified: {{ $stock->updated_at ? $stock->updated_at->diffForHumans() : 'Never' }}</span>
                                </div>

                                <!-- Incremental Qty Entry Controller -->
                                <div class="flex items-center bg-white border border-gray-200 rounded-xl p-1 shadow-sm shrink-0">
                                    <button type="button" @click="qty = Math.max(0, qty - 1)" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg font-black text-xs transition-colors">-</button>
                                    <input type="number" name="stocks[{{ $stock->id }}]" x-model.number="qty" min="0" :max="maxQty" @input="if (qty > maxQty) qty = maxQty; if (isNaN(qty) || qty < 0) qty = 0;" class="w-12 bg-transparent border-0 text-center text-xs font-black focus:ring-0 p-0 text-gray-900">
                                    <button type="button" @click="qty = Math.min(maxQty, qty + 1)" class="w-8 h-8 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-lg font-black text-xs transition-colors">+</button>
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

            <!-- Confirmation Dialogue Overlay Modal -->
            <div x-show="showConfirm" x-cloak style="display: none;"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div @click.away="showConfirm = false"
                     class="bg-white rounded-2xl border border-gray-100 shadow-2xl max-w-md w-full p-6 text-center transform transition-all"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="scale-95 translate-y-4"
                     x-transition:enter-end="scale-100 translate-y-0"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="scale-100 translate-y-0"
                     x-transition:leave-end="scale-95 translate-y-4">
                    
                    <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4 border border-indigo-100">
                        <svg class="w-7 h-7 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    
                    <h3 class="text-base font-black text-gray-900 uppercase tracking-widest">Confirm Shelf Audit?</h3>
                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                        You are about to save physical counts for your fragrance inventory. 
                        Please ensure these counts match your physical shelf quantities before proceeding.
                    </p>
                    
                    <div class="flex items-center gap-3 mt-6">
                        <button type="button" @click="showConfirm = false"
                                class="flex-1 px-5 py-3 bg-white border border-gray-150 hover:bg-gray-50 text-gray-400 hover:text-black rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                            Review Counts
                        </button>
                        <button type="button" @click="$el.closest('form').submit();"
                                class="flex-1 px-5 py-3 bg-black hover:bg-gray-800 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md">
                            Confirm & Save
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</x-app-layout>
