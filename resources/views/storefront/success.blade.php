<x-storefront-layout>
    <x-slot name="title">Order Confirmed</x-slot>

    <div class="bg-gray-50 min-h-[80vh] flex items-center py-24">
        <div class="max-w-3xl mx-auto px-4 text-center">
            
            <!-- Success Animation / Icon -->
            <div class="relative w-32 h-32 mx-auto mb-12">
                <div class="absolute inset-0 bg-emerald-100 rounded-full animate-ping opacity-20"></div>
                <div class="relative w-full h-full bg-emerald-500 rounded-full flex items-center justify-center shadow-2xl shadow-emerald-200">
                    <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>

            <h1 class="text-5xl lg:text-7xl font-luxury font-black italic mb-8 uppercase tracking-tight">Order Confirmed</h1>
            
            <p class="text-lg lg:text-xl text-gray-500 font-medium leading-relaxed mb-12 max-w-xl mx-auto">
                Thank you for your purchase. We are preparing your artisanal fragrance with care. An email confirmation has been sent to your inbox.
            </p>

            <div class="bg-white rounded-3xl p-10 border border-gray-100 shadow-xl shadow-gray-200/20 mb-16 inline-block w-full max-w-md">
                <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-50">
                    <span class="text-[11px] font-black uppercase tracking-widest text-gray-400">Order Reference</span>
                    <span class="text-lg font-black tracking-tighter uppercase">#ORD{{ session('order_id') ?? '0000' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[11px] font-black uppercase tracking-widest text-gray-400">Status</span>
                    <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest rounded-full">Payment Successful</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('storefront.index') }}" class="px-12 py-6 bg-black text-white text-[12px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-gray-800 transition-all hover:scale-105 active:scale-95 shadow-xl shadow-black/10">
                    Return to Store
                </a>
                <a href="#" class="px-12 py-6 border border-gray-200 text-black text-[12px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-white transition-all hover:scale-105 active:scale-95 shadow-lg shadow-gray-100">
                    Track Your Order
                </a>
            </div>

            <div class="mt-24">
                <h3 class="text-[11px] font-black uppercase tracking-[0.4em] mb-12 text-gray-300 italic">Need Assistance?</h3>
                <div class="flex justify-center gap-12">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white rounded-2xl border border-gray-100 flex items-center justify-center mx-auto mb-4 hover:shadow-lg transition-shadow">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Email Support</span>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white rounded-2xl border border-gray-100 flex items-center justify-center mx-auto mb-4 hover:shadow-lg transition-shadow">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                        </div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-gray-500">Live Concierge</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-storefront-layout>
