<x-app-layout title="My Personal Stock">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Personal Stock</h1>
            <p class="text-sm text-gray-500 mt-1">Manage local inventory acquired from HQ.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reseller.orders.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Restock Inventory
            </a>
        </div>
    </div>

    <!-- Stock Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse($stocks as $stock)
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md group">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest truncate">{{ $stock->product->sku }}</p>
                        <h3 class="text-sm font-bold text-gray-900 truncate">{{ $stock->product->name }}</h3>
                    </div>
                </div>
                
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Available Units</p>
                        <h4 class="text-2xl font-bold {{ $stock->quantity <= 5 ? 'text-rose-600' : 'text-gray-900' }} tabular-nums">
                            {{ $stock->quantity }}
                        </h4>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $stock->product->volume_ml }}ml Edition</span>
                        @if($stock->quantity <= 5)
                            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-bold uppercase tracking-widest rounded-lg border border-rose-100">
                                Low Stock
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center">
                <div class="mx-auto w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mb-6 text-gray-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1 tracking-tight">Your warehouse is empty</h3>
                <p class="text-sm text-gray-500 mb-8">Order stock from HQ to start generating sales.</p>
                <a href="{{ route('reseller.orders.create') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    Restock Now
                </a>
            </div>
        @endforelse
    </div>
    
    @if($stocks->hasPages())
        <div class="mt-10">
            {{ $stocks->links() }}
        </div>
    @endif
</x-app-layout>
