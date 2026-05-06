<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date & Time</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Origin</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Product</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Volume</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Qty</th>
                <th class="text-right px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Revenue</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($sales as $sale)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    {{-- Date --}}
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-sm font-bold text-gray-900">{{ $sale->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $sale->created_at->format('h:i A') }}</p>
                    </td>

                    {{-- Origin --}}
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded bg-gray-900 text-white flex items-center justify-center text-[9px] font-bold shrink-0">
                                {{ $sale->user ? strtoupper(substr($sale->user->name, 0, 2)) : 'ST' }}
                            </div>
                            <span class="text-xs font-bold text-gray-900 truncate">{{ $sale->user->name ?? 'Storefront' }}</span>
                        </div>
                    </td>

                    {{-- Product --}}
                    <td class="px-8 py-5">
                        <p class="text-sm font-bold text-gray-900">{{ $sale->product->name }}</p>
                    </td>

                    {{-- Volume --}}
                    <td class="px-8 py-5 text-center">
                        <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $sale->product->volume_ml }}ml</span>
                    </td>

                    {{-- Qty --}}
                    <td class="px-8 py-5 text-center">
                        <span class="text-sm font-bold text-gray-900">{{ $sale->quantity }}</span>
                    </td>

                    {{-- Revenue --}}
                    <td class="px-8 py-5 text-right whitespace-nowrap">
                        <span class="text-sm font-bold text-gray-900">RM{{ number_format($sale->total_price, 2) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Global Sales Ledger Empty</p>
                    </td>
                </tr>
            @endforelse
        </tbody>

        @if($sales->count() > 0)
            <tfoot>
                <tr class="bg-gray-50/20 border-t border-gray-100">
                    <td colspan="4" class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Page Sum</td>
                    <td class="px-8 py-5 text-center text-sm font-bold text-gray-900">{{ number_format($sales->sum('quantity')) }}</td>
                    <td class="px-8 py-5 text-right text-sm font-bold text-gray-900">RM{{ number_format($sales->sum('total_price'), 2) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>

@if(method_exists($sales, 'hasPages') && $sales->hasPages())
    <div class="px-8 py-5 border-t border-gray-50">
        {{ $sales->links() }}
    </div>
@endif
