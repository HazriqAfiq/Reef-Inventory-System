<x-app-layout title="Order Details">
    <div class="max-w-4xl mx-auto pb-12">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Order Details</h1>
                <p class="text-sm text-gray-500 mt-1">Reviewing wholesale transaction #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('reseller.orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-100 text-gray-400 hover:text-black text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to History
                </a>
            </div>
        </div>



        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Header Section -->
            <div class="px-10 py-10 border-b border-gray-50 flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        @if($order->status === 'paid')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Paid Status
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-amber-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                Pending Status
                            </span>
                        @endif
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                        <span class="text-gray-300 font-medium">#</span>{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </h1>
                </div>
                
                <div class="shrink-0">
                    @if($order->status === 'paid')
                        <a href="{{ route('reseller.orders.invoice', $order) }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-3 bg-white border border-gray-100 text-gray-900 text-xs font-bold uppercase tracking-widest rounded-xl hover:border-gray-200 transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Download Invoice
                        </a>
                    @else
                        <a href="{{ route('reseller.orders.payment', $order) }}" class="inline-flex items-center gap-2 px-10 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                            Complete Payment
                        </a>
                    @endif
                </div>
            </div>

            <!-- Summary Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-50 bg-gray-50/20 border-b border-gray-100">
                <div class="px-10 py-8 text-center md:text-left">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Gateway Reference</p>
                    <p class="font-mono text-xs font-bold text-gray-400 bg-gray-100/50 px-2.5 py-1 rounded-lg inline-block">{{ $order->billplz_id ?? 'Not Available' }}</p>
                </div>
                <div class="px-10 py-8 text-center md:text-left">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Total Quantity</p>
                    <p class="text-2xl font-bold text-gray-900 tabular-nums">{{ number_format($order->items->sum('quantity')) }} <span class="text-[10px] text-gray-400 uppercase ml-1">units</span></p>
                </div>
                <div class="px-10 py-8 text-center md:text-left">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Grand Total</p>
                    <p class="text-2xl font-bold text-gray-900 tabular-nums">RM{{ number_format($order->total_price, 2) }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-10">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-6">Order Breakdown</h3>
                <div class="bg-gray-50/20 rounded-2xl border border-gray-50 overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-50">
                                <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest">Product</th>
                                <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-center">Qty</th>
                                <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-right">Unit Price</th>
                                <th class="px-8 py-4 text-[9px] font-bold text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/50">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50/50 transition-all">
                                    <td class="px-8 py-5">
                                        <p class="text-xs font-bold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-0.5">{{ $item->product->volume_ml }}ml Edition</p>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-xs font-bold text-gray-900 tabular-nums">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="px-8 py-5 text-right text-xs font-bold text-gray-400 tabular-nums">
                                        RM{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-8 py-5 text-right text-xs font-bold text-gray-900 tabular-nums">
                                        RM{{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="px-8 py-6 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Payable</td>
                                <td class="px-8 py-6 text-right text-xl font-bold text-gray-900 tabular-nums">
                                    RM{{ number_format($order->total_price, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
