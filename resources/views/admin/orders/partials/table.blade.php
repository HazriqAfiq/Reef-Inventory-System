<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Ref</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Reseller</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date & Time</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Items</th>
                <th class="text-right px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Value</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Status</th>
                <th class="px-8 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    {{-- Ref --}}
                    <td class="px-8 py-5">
                        <span class="text-xs font-bold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>

                    {{-- Reseller --}}
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                {{ strtoupper(substr($order->user->name, 0, 2)) }}
                            </div>
                            <p class="text-sm font-bold text-gray-900">{{ $order->user->name }}</p>
                        </div>
                    </td>

                    {{-- Date --}}
                    <td class="px-8 py-5 whitespace-nowrap">
                        <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $order->created_at->format('h:i A') }}</p>
                    </td>

                    {{-- Items --}}
                    <td class="px-8 py-5 text-center">
                        <span class="text-xs font-bold text-gray-900">{{ $order->items->sum('quantity') }}</span>
                    </td>

                    {{-- Total --}}
                    <td class="px-8 py-5 text-right">
                        <span class="text-sm font-bold text-gray-900">RM{{ number_format($order->total_price, 2) }}</span>
                    </td>

                    {{-- Status --}}
                    <td class="px-8 py-5 text-center">
                        @if($order->status === 'paid')
                            <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-widest border border-emerald-100">
                                Paid
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-[9px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full uppercase tracking-widest border border-amber-100">
                                Pending
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-8 py-5 text-right">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-widest transition-colors">
                            Details
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-20 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">No B2B Orders Recorded</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
    <div class="px-8 py-5 border-t border-gray-50">
        {{ $orders->links() }}
    </div>
@endif
