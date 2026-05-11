<x-app-layout title="Order Details">

    {{-- Back Link --}}
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-black text-gray-400 hover:text-black uppercase tracking-widest transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Orders
        </a>
    </div>

    {{-- HEADER --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1.5">
                <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
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
            </div>
            <p class="text-xs text-gray-400 mt-1">Placed on {{ $order->created_at->format('d M Y \a\t h:i A') }}</p>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        {{-- MAIN DETAILS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Product</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Qty</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Unit Price</th>
                                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $item->product->name }}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                            {{ $item->product->sku }} &middot; {{ $item->variant?->name ?? $item->product->volume_ml . 'ml' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-gray-400 tabular-nums">
                                        RM{{ number_format($item->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                                        RM{{ number_format($item->price * $item->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50/50 border-t border-gray-100">
                            <tr>
                                <td colspan="3" class="px-6 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    Total Amount
                                </td>
                                <td class="px-6 py-5 text-right text-lg font-black text-gray-900 tracking-tight tabular-nums">
                                    RM{{ number_format($order->total_price, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- SIDEBAR METRICS --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Customer Details</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center font-bold text-[10px] shrink-0">
                            {{ strtoupper(substr($order->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-none">{{ $order->user->name }}</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">{{ $order->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Payment Reference</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Gateway Ref ID</p>
                        <p class="font-mono text-[11px] text-gray-900 font-bold bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-200 inline-block">
                            {{ $order->billplz_id ?? 'Not Available' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Payment Status</p>
                        @if($order->status === 'paid')
                            <p class="text-sm font-black text-emerald-600">Paid & Verified</p>
                        @else
                            <p class="text-sm font-black text-amber-600 animate-pulse">Pending Verification</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
