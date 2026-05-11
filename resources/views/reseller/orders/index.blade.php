<x-app-layout title="Wholesale Orders">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Order Pipeline Syncing</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Wholesale History</h1>
            <p class="text-xs text-gray-400 mt-1">Review your past stock purchases from Headquarters.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('reseller.orders.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-md shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Order Stock
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
            <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Wholesale Purchases Directory</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Order Ref</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Date & Time</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Units</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Value</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('reseller.orders.show', $order) }}" class="font-black text-black hover:underline">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </a>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-bold text-gray-900 leading-none">{{ $order->created_at->format('d M, Y') }}</p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $order->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-0.5 bg-gray-50 border border-gray-100 rounded text-[9px] font-black text-gray-500 tabular-nums">
                                    {{ $order->items->sum('quantity') }} items
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                                RM{{ number_format($order->total_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-emerald-600 bg-emerald-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-emerald-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-amber-600 bg-amber-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-amber-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('reseller.orders.show', $order) }}" 
                                       class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-black hover:text-white hover:border-black transition-all hover:scale-105 active:scale-95" 
                                       title="View Details">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="max-w-xs mx-auto">
                                    <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No wholesale orders found</p>
                                    <p class="text-xs text-gray-400 mt-1">Initiate a restock purchase order with HQ to purchase product inventory.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-6 py-5 border-t border-gray-50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
