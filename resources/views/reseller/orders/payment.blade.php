<x-app-layout title="Order Checkout">

    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="{{ route('reseller.orders.create') }}"
           class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black transition-colors uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Store
        </a>
    </div>

    <!-- Error Handling -->
    @if($errors->any())
        <div class="mb-8 p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm border border-rose-100 shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xs font-black text-rose-900 uppercase tracking-widest">Please correct the following errors</h3>
                <ul class="mt-1.5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-[11px] font-bold text-rose-600 list-disc list-inside uppercase tracking-wider">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('reseller.orders.callback', $order) }}" method="POST"
          x-data="{ 
              selectedMethod: 'fpx',
              inlineAddr: {{ $addresses->isEmpty() ? 'true' : 'false' }},
              selectedAddr: '{{ $defaultAddress?->id ?? '' }}'
          }"
          class="space-y-8">
        @csrf

        <!-- Main Checkout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT COLUMN: Order Details & Shipping (lg:col-span-8) --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- 1. Delivery & Shipping Address Panel --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20 flex items-center justify-between">
                        <div>
                            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Delivery Address</h2>
                            <p class="text-[8px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">Where should we deliver your wholesale stock?</p>
                        </div>
                        <span class="text-[8px] font-black bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded uppercase tracking-wider">Required Step</span>
                    </div>
                    <div class="p-6 space-y-6">
                        @if($addresses->isNotEmpty())
                            {{-- Saved Address Selector --}}
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">Saved Shipping Profiles</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($addresses as $addr)
                                        <label class="block cursor-pointer select-none">
                                            <input type="radio" name="address_id" value="{{ $addr->id }}"
                                                   x-model="selectedAddr"
                                                   @click="inlineAddr = false"
                                                   class="sr-only">
                                            <div :class="selectedAddr === '{{ $addr->id }}' && !inlineAddr ? 'border-black bg-white text-gray-900 ring-1 ring-black' : 'bg-gray-50/50 hover:bg-gray-50 text-gray-700 border-gray-100'"
                                                 class="p-4 rounded-xl border transition-all h-full flex flex-col justify-between shadow-xs">
                                                <div class="flex items-start justify-between">
                                                    <div>
                                                        <span class="text-[9px] font-black text-gray-900 uppercase tracking-wider">{{ $addr->label }}</span>
                                                        @if($addr->is_default)
                                                            <span class="ml-1.5 text-[7px] bg-black text-white px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Default</span>
                                                        @endif
                                                    </div>
                                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0" :class="selectedAddr === '{{ $addr->id }}' && !inlineAddr ? 'border-black bg-black' : 'border-gray-300 bg-transparent'">
                                                        <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 space-y-1">
                                                    <p class="text-[11px] font-bold text-gray-900">{{ $addr->recipient_name }} · {{ $addr->phone }}</p>
                                                    <p class="text-[10px] text-gray-500 leading-snug">{{ $addr->address_line_1 }}@if($addr->address_line_2), {{ $addr->address_line_2 }}@endif</p>
                                                    <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">{{ $addr->city }}, {{ $addr->state }} {{ $addr->postal_code }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach

                                    {{-- "New Address" Option Card --}}
                                    <label class="block cursor-pointer select-none">
                                        <input type="radio" name="address_id" value=""
                                               x-model="selectedAddr"
                                               @click="inlineAddr = true"
                                               class="sr-only">
                                        <div :class="inlineAddr ? 'border-black bg-white text-gray-900 ring-1 ring-black' : 'bg-gray-50/50 hover:bg-gray-50 text-gray-700 border-gray-100'"
                                             class="p-4 rounded-xl border transition-all h-full flex flex-col justify-center items-center text-center shadow-xs min-h-[140px]">
                                            <svg class="w-6 h-6 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            <p class="font-extrabold text-[10px] uppercase tracking-wider leading-none text-gray-900">Ship to a new address</p>
                                            <p class="text-[8px] mt-1 text-gray-400">Enter custom delivery details</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endif

                        {{-- Manual Inline Form --}}
                        <div x-show="inlineAddr" x-transition class="space-y-4 pt-4 border-t border-gray-100 border-dashed" x-cloak>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">New Shipping Destination</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Address Label</label>
                                    <input type="text" name="address_label" placeholder="e.g. Home, Office" value="Home" :required="inlineAddr"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Recipient Name *</label>
                                    <input type="text" name="recipient_name" placeholder="John Doe" :required="inlineAddr"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                            </div>

                            <div>
                                <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Phone Number *</label>
                                <input type="text" name="phone" placeholder="+60123456789" :required="inlineAddr"
                                       class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Address Line 1 *</label>
                                    <input type="text" name="address_line_1" placeholder="Street Name, Unit No" :required="inlineAddr"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Address Line 2 (Optional)</label>
                                    <input type="text" name="address_line_2" placeholder="Building, Floor, Landmark"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">City *</label>
                                    <input type="text" name="city" placeholder="Kuala Lumpur" :required="inlineAddr"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">Postcode *</label>
                                    <input type="text" name="postal_code" placeholder="50000" maxlength="10" :required="inlineAddr"
                                           class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all placeholder-gray-300 shadow-xs">
                                </div>
                                <div>
                                    <label class="text-[8px] font-black text-gray-400 uppercase tracking-wider block mb-1">State *</label>
                                    <select name="state" :required="inlineAddr" class="w-full px-3.5 py-2.5 text-xs font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 transition-all cursor-pointer shadow-xs">
                                        <option value="">Select State</option>
                                        @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','W.P. Kuala Lumpur','W.P. Labuan','W.P. Putrajaya'] as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="flex items-center gap-2 mt-4 cursor-pointer select-none">
                                <input type="checkbox" name="save_address" value="1" checked class="rounded border-gray-300 text-black focus:ring-black">
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Save this address to my profile for future use</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- 2. Order Summary (Purchased Items List) --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Order Summary</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Item Name</th>
                                        <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Unit Price</th>
                                        <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Quantity</th>
                                        <th class="pb-3 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-700">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    @if($item->product->primaryImage)
                                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" class="w-10 h-10 object-cover rounded-xl border border-gray-100 shrink-0">
                                                    @else
                                                        <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 font-bold shrink-0 text-[10px]">RE</div>
                                                    @endif
                                                    <div>
                                                        <p class="font-bold text-gray-900 text-sm leading-tight">{{ $item->product->name }}</p>
                                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-0.5">{{ $item->product->sku ?? 'N/A' }} @if($item->product->volume_ml) • {{ $item->product->volume_ml }}ml @endif</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 text-center text-gray-800 font-bold tabular-nums">
                                                RM{{ number_format($item->price, 2) }}
                                            </td>
                                            <td class="py-4 text-center font-bold tabular-nums">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="py-4 text-right font-black text-gray-900 tabular-nums text-sm">
                                                RM{{ number_format($item->price * $item->quantity, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            
            {{-- RIGHT COLUMN: Payment Methods & Place Order (lg:col-span-4) --}}
            <div class="lg:col-span-4">
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-6">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Payment & Checkout</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        
                        {{-- Subtotal & Fee Breakdown --}}
                        <div class="space-y-3.5 border-b border-gray-100 pb-5">
                            <div class="flex items-center justify-between text-xs font-medium text-gray-500">
                                <span>Product Subtotal</span>
                                <span class="text-gray-900 font-bold tabular-nums">RM{{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs font-medium text-gray-500">
                                <span>Shipping & Handling</span>
                                <span class="text-emerald-600 font-extrabold uppercase tracking-widest text-[9px]">Free Shipping</span>
                            </div>
                            <div class="flex items-center justify-between text-xs font-medium text-gray-500">
                                <span>Estimated Taxes</span>
                                <span class="text-gray-900 font-bold tabular-nums">RM0.00</span>
                            </div>
                            <div class="flex items-center justify-between pt-3.5 border-t border-gray-100 border-dashed">
                                <span class="text-xs font-black text-gray-900 uppercase tracking-wider">Total Payable</span>
                                <span class="text-xl font-black text-gray-900 tabular-nums">RM{{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>

                        {{-- Payment select section --}}
                        <div class="space-y-6">
                            
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">Select Payment Method</p>
                                
                                <div class="space-y-3">
                                    
                                    {{-- FPX Option --}}
                                    <div class="relative">
                                        <label class="block cursor-pointer group">
                                            <input type="radio" name="payment_method" value="fpx" x-model="selectedMethod" class="sr-only">
                                            <div :class="selectedMethod === 'fpx' ? 'border-black bg-white text-gray-900 ring-1 ring-black' : 'bg-gray-50/50 hover:bg-gray-50 text-gray-700 border-gray-100'"
                                                 class="p-4 rounded-xl border transition-all flex items-center justify-between shadow-xs">
                                                <div class="flex items-center gap-3">
                                                    <svg class="w-4 h-4 shrink-0" :class="selectedMethod === 'fpx' ? 'text-black' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    <div class="text-left">
                                                        <p class="font-extrabold text-[10px] uppercase tracking-wider leading-none">Online Banking (FPX)</p>
                                                        <p class="text-[8px] mt-1 text-gray-400">Direct Bank Transfer</p>
                                                    </div>
                                                </div>
                                                <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0" :class="selectedMethod === 'fpx' ? 'border-black bg-black' : 'border-gray-300 bg-transparent'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                                </div>
                                            </div>
                                        </label>
                                        
                                        {{-- Bank List Selection Dropdown --}}
                                        <div x-show="selectedMethod === 'fpx'" x-transition class="mt-2.5 pl-4 pr-1">
                                            <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Select Bank Provider</label>
                                            <select name="fpx_bank" class="w-full bg-gray-50 border border-gray-100 rounded-lg py-2 px-3 text-[10px] font-bold text-gray-800 focus:ring-1 focus:ring-black focus:border-black outline-none shadow-xs">
                                                <option value="maybank">Maybank2u</option>
                                                <option value="cimb">CIMB Clicks</option>
                                                <option value="public_bank">Public Bank</option>
                                                <option value="rhb">RHB Now</option>
                                                <option value="hong_leong">Hong Leong Connect</option>
                                                <option value="ambank">AmOnline</option>
                                                <option value="bank_islam">Bank Islam</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- E-Wallet Option --}}
                                    <div class="relative">
                                        <label class="block cursor-pointer group">
                                            <input type="radio" name="payment_method" value="ewallet" x-model="selectedMethod" class="sr-only">
                                            <div :class="selectedMethod === 'ewallet' ? 'border-black bg-white text-gray-900 ring-1 ring-black' : 'bg-gray-50/50 hover:bg-gray-50 text-gray-700 border-gray-100'"
                                                 class="p-4 rounded-xl border transition-all flex items-center justify-between shadow-xs">
                                                <div class="flex items-center gap-3">
                                                    <svg class="w-4 h-4 shrink-0" :class="selectedMethod === 'ewallet' ? 'text-black' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    <div class="text-left">
                                                        <p class="font-extrabold text-[10px] uppercase tracking-wider leading-none">E-Wallet</p>
                                                        <p class="text-[8px] mt-1 text-gray-400">Instant Mobile Wallet</p>
                                                    </div>
                                                </div>
                                                <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0" :class="selectedMethod === 'ewallet' ? 'border-black bg-black' : 'border-gray-300 bg-transparent'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                                </div>
                                            </div>
                                        </label>
                                        
                                        {{-- E-Wallet Partner Selection Dropdown --}}
                                        <div x-show="selectedMethod === 'ewallet'" x-transition class="mt-2.5 pl-4 pr-1">
                                            <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Select E-Wallet App</label>
                                            <select name="ewallet_partner" class="w-full bg-gray-50 border border-gray-100 rounded-lg py-2 px-3 text-[10px] font-bold text-gray-800 focus:ring-1 focus:ring-black focus:border-black outline-none shadow-xs">
                                                <option value="tng">Touch 'n Go eWallet</option>
                                                <option value="grabpay">GrabPay</option>
                                                <option value="boost">Boost</option>
                                                <option value="shopeepay">ShopeePay</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Credit Card Option --}}
                                    <div class="relative">
                                        <label class="block cursor-pointer group">
                                            <input type="radio" name="payment_method" value="card" x-model="selectedMethod" class="sr-only">
                                            <div :class="selectedMethod === 'card' ? 'border-black bg-white text-gray-900 ring-1 ring-black' : 'bg-gray-50/50 hover:bg-gray-50 text-gray-700 border-gray-100'"
                                                 class="p-4 rounded-xl border transition-all flex items-center justify-between shadow-xs">
                                                <div class="flex items-center gap-3">
                                                    <svg class="w-4 h-4 shrink-0" :class="selectedMethod === 'card' ? 'text-black' : 'text-gray-400'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                    <div class="text-left">
                                                        <p class="font-extrabold text-[10px] uppercase tracking-wider leading-none">Credit / Debit Card</p>
                                                        <p class="text-[8px] mt-1 text-gray-400">Visa or MasterCard</p>
                                                    </div>
                                                </div>
                                                <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0" :class="selectedMethod === 'card' ? 'border-black bg-black' : 'border-gray-300 bg-transparent'">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-white"></div>
                                                </div>
                                            </div>
                                        </label>
                                        
                                        {{-- Credit Card Details Placeholder Fields --}}
                                        <div x-show="selectedMethod === 'card'" x-transition class="mt-2.5 pl-4 pr-1 space-y-2" x-cloak>
                                            <div>
                                                <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Card Number</label>
                                                <input type="text" placeholder="•••• •••• •••• ••••" class="w-full bg-gray-50 border border-gray-100 rounded-lg py-2 px-3 text-[10px] font-bold tracking-widest text-gray-800 focus:ring-1 focus:ring-black focus:border-black outline-none placeholder-gray-300 uppercase shadow-xs">
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Expiry Date</label>
                                                    <input type="text" placeholder="MM / YY" class="w-full bg-gray-50 border border-gray-100 rounded-lg py-2 px-3 text-[10px] font-bold text-gray-800 focus:ring-1 focus:ring-black focus:border-black outline-none placeholder-gray-300 uppercase shadow-xs">
                                                </div>
                                                <div>
                                                    <label class="block text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">CVV</label>
                                                    <input type="text" placeholder="•••" class="w-full bg-gray-50 border border-gray-100 rounded-lg py-2 px-3 text-[10px] font-bold text-gray-800 focus:ring-1 focus:ring-black focus:border-black outline-none placeholder-gray-300 uppercase shadow-xs">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Place Order Form Button --}}
                            <button type="submit" class="w-full relative group/btn overflow-hidden rounded-xl bg-black px-4 py-4 font-black uppercase text-[11px] tracking-widest text-white shadow-md hover:bg-gray-800 active:scale-95 transition-all duration-200">
                                Place Order
                            </button>

                            <div class="text-center">
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                    256-bit Secure Gateway
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>

</x-app-layout>
