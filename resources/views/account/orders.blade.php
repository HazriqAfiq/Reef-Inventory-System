<x-account-layout>

    {{-- ── PAGE HEADER ──────────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16">
        <div>
            <div class="inline-flex items-center gap-6">
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
                <h2 class="text-3xl md:text-4xl font-light tracking-[0.2em] text-gray-900 leading-none uppercase">Order History</h2>
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
            </div>
        </div>
        <a href="{{ route('storefront.collection') }}"
           class="inline-flex items-center gap-3 text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-black transition-all group">
            Continue Shopping
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="py-40 bg-white rounded-[3rem] text-center border border-gray-100/50 shadow-sm">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
            </div>
            <p class="text-3xl font-light text-gray-900 mb-4 uppercase tracking-[0.1em]">Your history is a clean slate</p>
            <p class="text-[13px] text-gray-400 font-medium mb-10 tracking-wide max-w-xs mx-auto">Explore our collection and start your fragrance journey today.</p>
            <a href="{{ route('storefront.collection') }}"
               class="inline-flex items-center gap-4 px-8 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50 group">
                Discover Collection
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    @else
        <div class="space-y-10">
            @foreach($orders as $order)
                <div class="bg-white rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 p-10 md:p-12 group/order hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">

                    {{-- Order Meta Row --}}
                    <div class="flex flex-wrap items-start justify-between gap-8 mb-12">
                        <div class="flex flex-wrap gap-x-12 gap-y-6">
                            <div>
                                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-2">Identifier</p>
                                <p class="text-[16px] font-bold text-gray-900 tracking-tight">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-2">Timestamp</p>
                                <p class="text-[15px] text-gray-600 font-bold tracking-tight">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-2">Current State</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-[0.1em]
                                    @if($order->status === 'delivered') text-emerald-700 bg-emerald-50
                                    @elseif($order->status === 'cancelled') text-red-700 bg-red-50
                                    @else text-amber-700 bg-amber-50 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-2">Total Value</p>
                            <p class="text-3xl font-black text-gray-900 tracking-tight">RM {{ number_format($order->total_price, 2) }}</p>
                        </div>
                    </div>

                    {{-- Status Stepper --}}
                    @if($order->status !== 'cancelled')
                    <div class="mb-14">
                        @php
                            $statusOrder = ['pending', 'paid', 'processing', 'shipped', 'delivered'];
                            $currentIdx = array_search($order->status, $statusOrder);
                            $steps = [
                                'pending'    => 'Placed',
                                'paid'       => 'Paid',
                                'processing' => 'Processing',
                                'shipped'    => 'Shipped',
                                'delivered'  => 'Delivered',
                            ];
                        @endphp
                        <div class="relative flex justify-between items-center w-full max-w-3xl">
                            <div class="absolute top-1.5 left-0 w-full h-[2px] bg-gray-50 rounded-full"></div>
                            <div class="absolute top-1.5 left-0 h-[2px] bg-black rounded-full transition-all duration-1000" style="width: {{ ($currentIdx / (count($statusOrder) - 1)) * 100 }}%"></div>
                            @foreach($statusOrder as $idx => $s)
                                <div class="relative z-10 flex flex-col items-center">
                                    <div class="w-3.5 h-3.5 rounded-full border-4 border-white shadow-sm {{ $idx <= $currentIdx ? 'bg-black' : 'bg-gray-200' }} transition-colors duration-500"></div>
                                    <p class="text-[9px] font-bold uppercase tracking-widest mt-4 {{ $idx <= $currentIdx ? 'text-black' : 'text-gray-300' }}">
                                        {{ $steps[$s] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Content Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 border-t border-gray-50 pt-10">
                        {{-- Items List --}}
                        <div class="lg:col-span-8 space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-6 group/item">
                                    <div class="w-20 h-20 rounded-2xl bg-gray-50 flex items-center justify-center p-3 overflow-hidden border border-gray-100/50 group-hover/item:border-black/5 transition-colors">
                                        <img src="{{ $item->product->primaryImage
                                            ? asset('storage/' . $item->product->primaryImage->image_path)
                                            : 'https://placehold.co/80x80/f9fafb/d1d5db?text=' . urlencode(substr($item->product->name, 0, 1)) }}"
                                             class="w-full h-full object-contain mix-blend-multiply group-hover/item:scale-110 transition-transform duration-500"
                                             alt="{{ $item->product->name }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[15px] font-bold text-gray-900 tracking-tight truncate">{{ $item->product->name }}</p>
                                        <p class="text-[12px] text-gray-400 font-medium mt-1">
                                            Quantity: {{ $item->quantity }}
                                            <span class="mx-3 text-gray-200">|</span>
                                            RM {{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                    <p class="text-[15px] font-black text-gray-900">RM {{ number_format($item->quantity * $item->price, 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        {{-- Order Info Sidebar --}}
                        <div class="lg:col-span-4 space-y-8">
                            {{-- Shipping --}}
                            @if($order->shippingAddress)
                                <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-100/50">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-5">Shipment Target</p>
                                    <div class="space-y-1">
                                        <p class="text-[14px] font-bold text-gray-900">{{ $order->shippingAddress->full_name }}</p>
                                        <p class="text-[13px] text-gray-500 font-medium leading-relaxed">{{ $order->shippingAddress->address }}</p>
                                        <p class="text-[13px] text-gray-500 font-medium leading-relaxed">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->postal_code }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Actions --}}
                            @if(in_array($order->status, ['pending', 'paid']))
                                <div class="px-2">
                                    <form action="{{ route('account.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        <button type="submit" class="w-full py-4 text-[10px] font-bold text-red-400 hover:text-red-600 uppercase tracking-[0.3em] transition-all border border-red-100 rounded-2xl hover:bg-red-50 hover:border-red-200">
                                            Request Cancellation
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        @if($orders->hasPages())
            <div class="mt-16 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    @endif

</x-account-layout>

