<x-storefront-layout :hasHero="false">
    <x-slot name="title">My Account</x-slot>

    @php
        $initials = collect(explode(' ', Auth::user()->name))
            ->map(fn($w) => strtoupper(substr($w, 0, 1)))
            ->take(2)->implode('');
    @endphp

    <div class="bg-[#FBFBFD] min-h-screen">

        {{-- ── PAGE HEADER ─────────────────────────────────────────────── --}}
        <div class="bg-white border-b border-gray-100/80">
            <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 pt-12">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">

                    {{-- Avatar + Name --}}
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-3xl bg-gray-900 flex items-center justify-center flex-shrink-0 shadow-lg shadow-gray-200">
                                <span class="text-xl text-white font-medium tracking-[0.3em] uppercase">{{ $initials }}</span>
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-1.5">Member Dashboard</p>
                            <h1 class="text-3xl md:text-4xl font-light tracking-[0.05em] text-gray-900 leading-none uppercase">{{ Auth::user()->name }}</h1>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-full text-[11px] font-bold text-gray-500 hover:text-black uppercase tracking-[0.2em] transition-all bg-gray-50 hover:bg-gray-100 border border-gray-100">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ── TAB NAVIGATION ───────────────────────────────────────── --}}
                <nav class="flex space-x-1 overflow-x-auto scrollbar-hide">
                    @php
                        $navItems = [
                            ['route' => 'account.index', 'label' => 'Overview'],
                            ['route' => 'account.orders', 'label' => 'Orders'],
                            ['route' => 'account.addresses', 'label' => 'Addresses'],
                            ['route' => 'account.wishlist', 'label' => 'Wishlist'],
                            ['route' => 'account.settings', 'label' => 'Settings'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                           class="group relative px-4 py-4 text-[11px] font-bold uppercase tracking-[0.25em] transition-all duration-300 whitespace-nowrap
                                  {{ request()->routeIs($item['route']) ? 'text-black' : 'text-gray-400 hover:text-gray-600' }}">
                            {{ $item['label'] }}
                            @if(request()->routeIs($item['route']))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-black rounded-full"></span>
                            @else
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gray-200 group-hover:w-full transition-all duration-300 rounded-full"></span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        {{-- ── PAGE CONTENT ─────────────────────────────────────────────── --}}
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
            {{ $slot }}
        </div>

    </div>
</x-storefront-layout>

