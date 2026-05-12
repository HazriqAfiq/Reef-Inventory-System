<x-app-layout title="Order Details">

    <!-- Back Navigation -->
    <a href="{{ route('admin.orders.index') }}"
       class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black mb-8 transition-colors uppercase tracking-widest">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Orders
    </a>

    <!-- Shipment Status Tracker Timeline (Full Width at the Top) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Shipment Status Tracker</h2>
            @if($order->tracking_number)
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-indigo-600 bg-indigo-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-indigo-100/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                        Tracked Shipment
                    </span>
                    @if($order->tracking_url)
                        <a href="{{ $order->tracking_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-[9px] font-black text-white bg-black hover:bg-gray-800 px-3.5 py-1.5 rounded-xl uppercase tracking-widest transition-colors shadow-sm">
                            Track Live
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div class="p-6 md:p-8">
            {{-- Responsive timeline wrapper --}}
            <div class="relative">
                {{-- Desktop progress line background (Column 1 center to Column 5 center) --}}
                <div class="hidden sm:block absolute top-[18px] left-[10%] right-[10%] h-1 bg-gray-100 -z-10 rounded-full"></div>
                
                {{-- Desktop active progress line (Column 1 center to active column center) --}}
                @php
                    $progressPercentages = [
                        'pending'    => 0,
                        'paid'       => 25,
                        'processing' => 50,
                        'shipped'    => 75,
                        'delivered'  => 100,
                        'cancelled'  => 0,
                    ];
                    $pPercent = $progressPercentages[$order->status] ?? 0;
                @endphp
                @if($order->status !== 'cancelled')
                    <div class="hidden sm:block absolute top-[18px] left-[10%] h-1 bg-black -z-10 rounded-full transition-all duration-500 ease-out" style="width: calc({{ $pPercent }}% * 0.8)"></div>
                @endif

                {{-- Mobile progress line background (Vertical) --}}
                <div class="sm:hidden absolute top-4 bottom-4 left-[18px] w-1 bg-gray-100 -z-10 rounded-full"></div>

                {{-- Mobile active progress line (Vertical) --}}
                @if($order->status !== 'cancelled')
                    <div class="sm:hidden absolute top-4 left-[18px] w-1 bg-black -z-10 rounded-full transition-all duration-500 ease-out" style="height: {{ $pPercent }}%"></div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 sm:gap-0 relative z-10">
                    {{-- Step 1: Placed --}}
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 {{ $order->status !== 'cancelled' ? 'bg-black border-black text-white' : 'bg-gray-100 border-gray-200 text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black text-gray-900 uppercase tracking-widest leading-none sm:mt-1">Placed</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">{{ $order->created_at->format('d M \a\t h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Step 2: Paid --}}
                    @php
                        $isPaid = in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']);
                        $step2Bg = $isPaid ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-400';
                    @endphp
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 {{ $step2Bg }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5-1.5a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black {{ $isPaid ? 'text-gray-900' : 'text-gray-400' }} uppercase tracking-widest leading-none sm:mt-1">Paid</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                @if($isPaid)
                                    Verified
                                @else
                                    Awaiting Payment
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Step 3: Processing --}}
                    @php
                        $isProcessing = in_array($order->status, ['processing', 'shipped', 'delivered']);
                        $step3Bg = $isProcessing ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-400';
                    @endphp
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 {{ $step3Bg }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black {{ $isProcessing ? 'text-gray-900' : 'text-gray-400' }} uppercase tracking-widest leading-none sm:mt-1">Processing</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                @if($isProcessing)
                                    In Progress
                                @else
                                    Pending Prep
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Step 4: Shipped --}}
                    @php
                        $isShipped = in_array($order->status, ['shipped', 'delivered']);
                        $step4Bg = $isShipped ? 'bg-black border-black text-white animate-pulse' : 'bg-white border-gray-200 text-gray-400';
                    @endphp
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 {{ $step4Bg }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black {{ $isShipped ? 'text-gray-900' : 'text-gray-400' }} uppercase tracking-widest leading-none sm:mt-1">Shipped</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                @if($order->shipped_at)
                                    {{ $order->shipped_at->format('d M \a\t h:i A') }}
                                @else
                                    Pending Dispatch
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Step 5: Delivered --}}
                    @php
                        $isDelivered = $order->status === 'delivered';
                        $step5Bg = $isDelivered ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-white border-gray-200 text-gray-400';
                    @endphp
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 {{ $step5Bg }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black {{ $isDelivered ? 'text-emerald-600' : 'text-gray-400' }} uppercase tracking-widest leading-none sm:mt-1">Delivered</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                @if($order->delivered_at)
                                    {{ $order->delivered_at->format('d M \a\t h:i A') }}
                                @else
                                    Final Destination
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        {{-- MAIN DETAILS --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-8 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6 bg-white">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
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
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $order->created_at->format('d M Y \a\t h:i A') }}</span>
                        </div>
                        <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                            Order Items <span class="text-gray-300 font-medium">#</span>{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </h2>
                    </div>
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
            {{-- ORDER FULFILLMENT & TRACKING --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Fulfillment Control</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        {{-- EasyParcel Integration Connectivity Notice --}}
                        @if(config('services.easyparcel.key'))
                            <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-100/60 flex items-start gap-2.5 mb-4">
                                <span class="flex h-2 w-2 mt-1 relative shrink-0">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <div class="text-[10px] text-emerald-800 font-bold leading-relaxed">
                                    <p class="uppercase tracking-widest text-[9px] text-emerald-600 mb-0.5">EasyParcel Automation: ACTIVE</p>
                                    Leave tracking number blank to automatically book shipment, calculate rates, and generate carrier details!
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-start gap-2.5 mb-4">
                                <span class="flex h-2 w-2 mt-1 relative shrink-0">
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-gray-400"></span>
                                </span>
                                <div class="text-[10px] text-gray-500 font-bold leading-relaxed">
                                    <p class="uppercase tracking-widest text-[9px] text-gray-400 mb-0.5">EasyParcel Automation: OFFLINE</p>
                                    Configure <code class="bg-gray-100 px-1 rounded">EASYPARCEL_API_KEY</code> in env to enable automatic courier booking and airway bill generation.
                                </div>
                            </div>
                        @endif

                        {{-- Active Shipment Details Summary --}}
                        @if($order->tracking_number)
                            <div class="p-3 bg-indigo-50/70 rounded-xl border border-indigo-100/60 flex items-start gap-2.5 mb-4">
                                <svg class="w-4 h-4 text-indigo-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"/></svg>
                                <div class="text-[10px] text-indigo-800 font-bold leading-relaxed">
                                    <p class="uppercase tracking-widest text-[9px] text-indigo-600 mb-0.5">Active Shipment Details</p>
                                    Courier Partner: <span class="text-indigo-900 font-black">{{ $order->courier_name }}</span><br>
                                    Tracking Number: <span class="text-indigo-900 font-black font-mono">{{ $order->tracking_number }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Order Status Selector --}}
                        <div>
                            <label for="status" class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Order Status</label>
                            <div class="relative">
                                <select id="status" name="status" class="w-full text-xs font-bold text-gray-900 bg-gray-50 rounded-xl border border-gray-200 px-3.5 py-3 focus:border-black focus:ring-0 appearance-none cursor-pointer">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Awaiting Payment (Pending)</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Payment Verified (Paid)</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Packaging / In Progress</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped & Dispatched</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Successfully Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Tracking block wrapper --}}
                        <div class="space-y-4 pt-1 border-t border-gray-50">
                            {{-- Courier Selector --}}
                            <div>
                                <label for="courier_name" class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Courier Partner</label>
                                <div class="relative">
                                    <select id="courier_name" name="courier_name" class="w-full text-xs font-bold text-gray-900 bg-gray-50 rounded-xl border border-gray-200 px-3.5 py-3 focus:border-black focus:ring-0 appearance-none cursor-pointer">
                                        <option value="">-- Select Courier Partner --</option>
                                        <option value="PosLaju" {{ strtolower($order->courier_name ?? '') === 'poslaju' ? 'selected' : '' }}>PosLaju</option>
                                        <option value="J&T Express" {{ strtolower($order->courier_name ?? '') === 'j&t express' || strtolower($order->courier_name ?? '') === 'jt' ? 'selected' : '' }}>J&T Express</option>
                                        <option value="DHL" {{ strtolower($order->courier_name ?? '') === 'dhl' ? 'selected' : '' }}>DHL</option>
                                        <option value="FedEx" {{ strtolower($order->courier_name ?? '') === 'fedex' ? 'selected' : '' }}>FedEx</option>
                                        <option value="Ninja Van" {{ strtolower($order->courier_name ?? '') === 'ninja van' ? 'selected' : '' }}>Ninja Van</option>
                                        <option value="GDex" {{ strtolower($order->courier_name ?? '') === 'gdex' ? 'selected' : '' }}>GD Express (GDex)</option>
                                        <option value="Other" {{ $order->courier_name && !in_array(strtolower($order->courier_name), ['poslaju', 'j&t express', 'jt', 'dhl', 'fedex', 'ninja van', 'gdex']) ? 'selected' : '' }}>Other (Manual Entry Below)</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Custom Courier Name Input --}}
                            <div id="custom_courier_wrapper" class="hidden">
                                <label for="courier_name_custom" class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Custom Courier Name</label>
                                <input type="text" id="courier_name_custom" class="w-full text-xs font-bold text-gray-900 bg-gray-50 rounded-xl border border-gray-200 px-3.5 py-3 focus:border-black focus:ring-0" placeholder="e.g. SF Express">
                            </div>

                            {{-- Tracking Number --}}
                            <div>
                                <label for="tracking_number" class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Tracking Number</label>
                                <input type="text" id="tracking_number" name="tracking_number" value="{{ $order->tracking_number }}" class="w-full text-xs font-bold text-gray-900 bg-gray-50 rounded-xl border border-gray-200 px-3.5 py-3 focus:border-black focus:ring-0" placeholder="e.g. PL123456789MY">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full py-3.5 bg-black hover:bg-gray-800 text-white text-[11px] font-black uppercase tracking-widest rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 mt-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Apply Updates
                        </button>
                    </form>
                </div>
            </div>

            {{-- CUSTOMER DETAILS --}}
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

            {{-- SHIPPING ADDRESS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                    <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Shipping Address</h2>
                </div>
                <div class="p-6 space-y-4 text-xs text-gray-600">
                    @if($order->shippingAddress)
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Recipient</p>
                            <p class="font-bold text-gray-900">{{ $order->shippingAddress->first_name }} {{ $order->shippingAddress->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Contact Phone</p>
                            <p class="font-bold text-gray-900">{{ $order->shippingAddress->phone }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Destination Address</p>
                            <p class="font-bold text-gray-900 leading-relaxed">{{ $order->shippingAddress->address }}</p>
                            <p class="font-bold text-gray-900 mt-0.5">{{ $order->shippingAddress->postcode }} {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }}</p>
                        </div>
                    @else
                        <p class="text-gray-400 italic">No delivery address specified.</p>
                    @endif
                </div>
            </div>
            
            {{-- PAYMENT REFERENCE --}}
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

    <script>
        (function() {
            const courierSelect = document.getElementById('courier_name');
            const customWrapper = document.getElementById('custom_courier_wrapper');
            const customInput = document.getElementById('courier_name_custom');

            function toggleCustomCourier() {
                if (courierSelect.value === 'Other') {
                    customWrapper.classList.remove('hidden');
                    customInput.setAttribute('name', 'courier_name');
                    courierSelect.removeAttribute('name');
                } else {
                    customWrapper.classList.add('hidden');
                    courierSelect.setAttribute('name', 'courier_name');
                    customInput.removeAttribute('name');
                }
            }

            if (courierSelect) {
                courierSelect.addEventListener('change', toggleCustomCourier);
                // Initialize on load
                if (courierSelect.value === 'Other' || (courierSelect.value === '' && "{{ $order->courier_name }}" !== '')) {
                    courierSelect.value = 'Other';
                    customInput.value = "{{ $order->courier_name }}";
                    toggleCustomCourier();
                }
            }
        })();
    </script>
</x-app-layout>
