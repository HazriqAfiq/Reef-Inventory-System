<x-app-layout title="Mock Billplz Payment">

    <div class="min-h-[80vh] flex items-center justify-center p-4">
        <div class="max-w-md w-full relative group">
            
            <!-- Animated background glow -->
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-[#ffea00] to-indigo-600 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200 animate-gradient-x"></div>
            
            <div class="relative bg-white rounded-[2rem] shadow-2xl overflow-hidden ring-1 ring-gray-900/5">
                
                {{-- Gateway Header --}}
                <div class="bg-[#002244] px-8 pt-10 pb-12 relative overflow-hidden text-center flex flex-col items-center">
                    <!-- Decor -->
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-[#ffea00]/10 rounded-full blur-xl"></div>
                    
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-8 h-8 text-[#ffea00]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-black text-white tracking-tight mb-1 relative z-10">Billplz<span class="text-[#ffea00]">.</span></h1>
                    <p class="text-blue-200/70 text-xs font-semibold uppercase tracking-widest relative z-10">Secure Checkout Simulator</p>
                </div>

                {{-- Amount section (overlapping) --}}
                <div class="px-8 -mt-8 relative z-20">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 text-center transform transition-transform hover:scale-105 duration-300">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Total Payable</p>
                        <p class="text-4xl font-black text-gray-900 tracking-tighter">RM {{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>

                {{-- Details --}}
                <div class="px-8 pt-8 pb-10">
                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50 border-dashed">
                            <span class="text-gray-500 font-medium">Bill ID</span>
                            <span class="font-bold text-gray-900 font-mono bg-gray-100 px-2 py-0.5 rounded-md text-xs">{{ $order->billplz_id }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50 border-dashed">
                            <span class="text-gray-500 font-medium">Order Ref</span>
                            <span class="font-bold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm py-2 border-b border-gray-50 border-dashed">
                            <span class="text-gray-500 font-medium">Pay To</span>
                            <span class="font-bold text-blue-600 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Reef Perfume HQ
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('reseller.orders.callback', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full relative group/btn overflow-hidden rounded-2xl bg-gray-900 px-4 py-4 font-bold text-white shadow-xl hover:shadow-2xl hover:shadow-indigo-500/20 active:scale-95 transition-all duration-200">
                            <!-- Button hover accent -->
                            <div class="absolute inset-0 w-0 bg-gradient-to-r from-blue-600 to-indigo-600 transition-all duration-[250ms] ease-out group-hover/btn:w-full"></div>
                            <span class="relative flex items-center justify-center gap-2">
                                Simulate Payment
                                <svg class="w-5 h-5 text-[#ffea00] animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </button>
                        <div class="mt-5 text-center">
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-widest mb-1 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                256-bit Mock Encryption
                            </p>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

</x-app-layout>
