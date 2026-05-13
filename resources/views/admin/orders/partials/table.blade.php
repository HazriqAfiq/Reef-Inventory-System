<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Order ID</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Reseller</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Items Qty</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total Price</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Order Status</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody id="admin-orders-tbody" class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    {{-- Order ID --}}
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-black text-black hover:underline">
                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </a>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ $order->created_at->format('d M Y \a\t h:i A') }}</p>
                    </td>

                    {{-- Reseller --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                {{ strtoupper(substr($order->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 leading-none">{{ $order->user->name }}</div>
                                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1 truncate max-w-[150px]">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Items Qty --}}
                    <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums">
                        {{ $order->items->sum('quantity') }}
                    </td>

                    {{-- Total Price --}}
                    <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                        RM{{ number_format($order->total_price, 2) }}
                    </td>

                    {{-- Order Status --}}
                    <td class="px-6 py-4 text-right">
                        @php
                            $statusColors = [
                                'pending'    => 'bg-amber-50 text-amber-600 border-amber-100/40',
                                'paid'       => 'bg-emerald-50 text-emerald-600 border-emerald-100/40',
                                'processing' => 'bg-blue-50 text-blue-600 border-blue-100/40',
                                'shipped'    => 'bg-indigo-50 text-indigo-600 border-indigo-100/40',
                                'delivered'  => 'bg-teal-50 text-teal-600 border-teal-100/40',
                                'cancelled'  => 'bg-gray-50 text-gray-500 border-gray-100/40',
                            ];
                            $badgeStyle = $statusColors[strtolower($order->status)] ?? 'bg-gray-50 text-gray-600 border-gray-100/40';
                        @endphp
                        <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider border {{ $badgeStyle }}">
                            {{ $order->status }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            @if(in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']))
                                <a href="{{ route('admin.orders.invoice', $order) }}" 
                                   data-no-spa
                                   download
                                   title="Download Receipt"
                                   class="inline-flex items-center justify-center w-8 h-8 bg-white hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-500 rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            @endif
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
                                Order Details
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No B2B Orders Recorded</p>
                            <p class="text-xs text-gray-400 mt-1">Check back later for wholesale orders placed by your reseller network.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->nextPageUrl())
    <div id="admin-load-more-wrapper" class="px-6 py-5 border-t border-gray-50 flex justify-center">
        <button id="btn-admin-load-more" 
                data-next-url="{{ $orders->nextPageUrl() }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-xs font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
            <span>Show More</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/>
            </svg>
        </button>
    </div>
@endif
