<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100/80">
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Date & Time</th>
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Product</th>
                <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell">Volume</th>
                <th class="text-center px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Qty</th>
                <th class="text-right px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Revenue</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50/80">
            @forelse($sales as $sale)
                <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                    <td class="px-7 py-4.5 whitespace-nowrap">
                        <p class="text-[13px] font-medium text-gray-900">{{ $sale->created_at->format('d M Y') }}</p>
                        <p class="text-[11px] font-medium text-gray-400 mt-0.5 uppercase tracking-wider">{{ $sale->created_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-7 py-4.5">
                        <p class="text-[13px] font-medium text-gray-900">{{ $sale->product->name }}</p>
                    </td>
                    <td class="px-7 py-4.5 text-center hidden sm:table-cell">
                        <span class="inline-block text-[11px] font-medium bg-gray-100 border border-gray-200/80 text-gray-500 px-2.5 py-0.5 rounded-md shadow-sm">
                            {{ $sale->product->volume_ml }}ml
                        </span>
                    </td>
                    <td class="px-7 py-4.5 text-center">
                        <span class="inline-flex items-center justify-center min-w-[2rem] px-1.5 h-6 rounded-lg bg-white border border-gray-100 text-black shadow-sm text-[12px] font-black">
                            {{ $sale->quantity }}
                        </span>
                    </td>
                    <td class="px-7 py-4.5 text-right">
                        <span class="text-[14px] font-black text-gray-900">
                            RM{{ number_format($sale->total_price, 2) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-7 py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-16 h-16 bg-gray-50 border border-gray-100 rounded-full flex items-center justify-center mb-1">
                                <svg class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <p class="text-[15px] font-bold text-gray-900">No sales recorded yet</p>
                            <p class="text-[12px] text-gray-500">Record a new sale or adjust your timeframe filter.</p>
                            <a href="{{ route('reseller.sales.create') }}" class="text-[11px] font-black uppercase tracking-widest text-white bg-black px-6 py-2.5 rounded-xl hover:bg-gray-900 transition-all shadow-xl shadow-black/10 inline-flex cursor-pointer mt-2">Record Sale</a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- Page total footer --}}
        @if($sales->count() > 0)
            <tfoot>
                <tr class="border-t border-gray-100 bg-gray-50/80">
                    <td colspan="3" class="px-7 py-5 text-[11px] font-bold text-gray-500 uppercase tracking-widest text-right">
                        Page Total
                    </td>
                    <td class="px-7 py-5 text-center text-[14px] font-black text-gray-700">
                        {{ number_format($sales->sum('quantity')) }}
                    </td>
                    <td class="px-7 py-5 text-right text-[15px] font-black text-gray-900">
                        RM{{ number_format($sales->sum('total_price'), 2) }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>

{{-- Pagination --}}
@if(method_exists($sales, 'hasPages') && $sales->hasPages())
    <div class="px-7 py-5 border-t border-gray-50">
        {{ $sales->links() }}
    </div>
@endif
