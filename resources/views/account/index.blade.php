<x-account-layout>


    {{-- ── STAT CARDS ───────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

        {{-- Latest Order --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 group hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">
            <div class="flex items-center justify-between mb-10">
                <div class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-black transition-colors duration-500">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em]">Latest Activity</p>
            </div>
            @if($latestOrder)
                <div class="mb-10">
                    <p class="text-[11px] text-gray-400 font-bold uppercase tracking-[0.2em] mb-1">Last Order</p>
                    <p class="text-4xl font-light text-gray-900 tracking-tight uppercase">RM {{ number_format($latestOrder->total_price, 2) }}</p>
                    <div class="flex items-center gap-3 mt-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-[0.1em]
                            {{ $latestOrder->status === 'paid' ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50' }}">
                            {{ ucfirst($latestOrder->status) }}
                        </span>
                        <p class="text-[11px] text-gray-400 font-medium tracking-tight">{{ $latestOrder->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <a href="{{ route('account.orders') }}"
                   class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-black group/link">
                    <span class="border-b border-black/10 group-hover/link:border-black transition-all pb-0.5">View details</span>
                    <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @else
                <p class="text-2xl font-bold text-gray-200 mb-10 tracking-tight">No orders yet</p>
                <a href="{{ route('storefront.collection') }}"
                   class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-black group/link">
                    <span class="border-b border-black/10 group-hover/link:border-black transition-all pb-0.5">Start shopping</span>
                    <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endif
        </div>

        {{-- Default Address --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 group hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">
            <div class="flex items-center justify-between mb-10">
                <div class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-black transition-colors duration-500">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em]">Primary Address</p>
            </div>
            @if($defaultAddress)
                <div class="mb-10">
                    <p class="text-[15px] font-bold text-gray-900 tracking-tight mb-1">{{ $defaultAddress->recipient_name }}</p>
                    <p class="text-[13px] text-gray-500 font-medium leading-relaxed truncate">{{ $defaultAddress->address_line_1 }}</p>
                    <p class="text-[13px] text-gray-500 font-medium leading-relaxed">{{ $defaultAddress->city }}, {{ $defaultAddress->postal_code }}</p>
                    <p class="text-[11px] text-gray-300 font-bold uppercase tracking-[0.2em] mt-3">{{ $defaultAddress->label ?? 'Default' }}</p>
                </div>
                <a href="{{ route('account.addresses') }}"
                   class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-black group/link">
                    <span class="border-b border-black/10 group-hover/link:border-black transition-all pb-0.5">Edit address</span>
                    <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @else
                <p class="text-2xl font-bold text-gray-200 mb-10 tracking-tight">None saved</p>
                <a href="{{ route('account.addresses') }}"
                   class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-black group/link">
                    <span class="border-b border-black/10 group-hover/link:border-black transition-all pb-0.5">Add shipping</span>
                    <svg class="w-3.5 h-3.5 group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endif
        </div>

        {{-- Loyalty Points --}}
        <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 group hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">
            <div class="flex items-center justify-between mb-10">
                <div class="w-10 h-10 rounded-2xl bg-gray-50 flex items-center justify-center group-hover:bg-black transition-colors duration-500">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em]">Rewards Status</p>
            </div>
            <div class="mb-10">
                <p class="text-4xl font-light text-gray-900 tracking-tight uppercase">{{ number_format(Auth::user()->loyalty_points) }} <span class="text-lg font-bold text-gray-300">pts</span></p>
                <p class="text-[11px] text-emerald-600 font-bold tracking-[0.2em] uppercase mt-2">
                    Signature Member
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em] bg-gray-50 px-3 py-1.5 rounded-full">100 pts = RM 1</span>
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em] bg-gray-50 px-3 py-1.5 rounded-full">Tier 1</span>
            </div>
        </div>

    </div>

    {{-- ── QUICK LINKS ───────────────────────────────────────────────────── --}}
    <div class="bg-white rounded-[3rem] p-12 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50">
        <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.5em] mb-12 text-center">Explore Your Account</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">

            <a href="{{ route('storefront.collection') }}" class="group block text-center">
                <div class="mb-6 mx-auto w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 -2.3 2.1 -4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-2 group-hover:text-black transition-colors">Curated</p>
                <p class="text-xl font-light text-gray-900 tracking-widest uppercase">Shop Collection</p>
            </a>

            <a href="{{ route('account.orders') }}" class="group block text-center">
                <div class="mb-6 mx-auto w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-2 group-hover:text-black transition-colors">History</p>
                <p class="text-xl font-light text-gray-900 tracking-widest uppercase">Order Records</p>
            </a>

            <a href="{{ route('account.settings') }}" class="group block text-center">
                <div class="mb-6 mx-auto w-14 h-14 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-black transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-2 group-hover:text-black transition-colors">Profile</p>
                <p class="text-xl font-light text-gray-900 tracking-widest uppercase">Preferences</p>
            </a>

        </div>
    </div>

</x-account-layout>
