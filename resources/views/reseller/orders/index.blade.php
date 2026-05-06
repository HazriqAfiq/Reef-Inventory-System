<x-app-layout title="Wholesale Orders">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Wholesale History</h1>
            <p class="text-sm text-gray-500 mt-1">Review your past stock purchases from HQ.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('reseller.orders.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Order Stock
            </a>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/20 border-b border-gray-50">
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Ref</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date & Time</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Units</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Value</th>
                        <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/30 transition-all group">
                            <td class="px-8 py-5">
                                <span class="font-mono text-xs font-bold text-gray-400">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <p class="text-xs font-bold text-gray-900">{{ $order->created_at->format('d M, Y') }}</p>
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $order->created_at->format('h:i A') }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2 py-1 bg-gray-50 border border-gray-100 text-gray-900 text-xs font-bold rounded-lg tabular-nums">
                                    {{ $order->items->sum('quantity') }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right text-xs font-bold text-gray-900 tabular-nums">
                                RM{{ number_format($order->total_price, 2) }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-emerald-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-amber-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="{{ route('reseller.orders.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-white text-gray-400 hover:text-black border border-gray-100 hover:border-gray-200 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm">
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-20 text-center">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900 mb-1">No orders found</p>
                                <p class="text-xs text-gray-500">Restock inventory to see your orders here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-8 py-5 border-t border-gray-50 bg-gray-50/10">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
