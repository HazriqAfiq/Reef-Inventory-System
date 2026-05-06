@props(['darkHero' => false, 'hasHero' => false, 'title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laman Store') }} | Laman Store Malaysia</title>

    @php
        $typography = \App\Models\Setting::getValue('theme_typography_pairing', 'classic');
        $heroScrim = \App\Models\Setting::getValue('homepage_hero_scrim', '0.3');
        

        $fontLinks = [
            'classic' => 'family=Prata&family=Inter:wght@400;500;600;700;800;900',
            'editorial' => 'family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@400;500;600;700;800;900',
            'minimal' => 'family=Tenor+Sans&family=Outfit:wght@400;500;600;700;800;900'
        ];
        
        $fontSerif = [
            'classic' => '"Prata", serif',
            'editorial' => '"Playfair Display", serif',
            'minimal' => '"Tenor Sans", serif'
        ];
        
        $fontSans = [
            'classic' => '"Inter", sans-serif',
            'editorial' => '"Montserrat", sans-serif',
            'minimal' => '"Outfit", sans-serif'
        ];
    @endphp

    <!-- Fonts: Dynamic Premium Pairings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?{{ $fontLinks[$typography] ?? $fontLinks['classic'] }}&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --font-serif: {!! $fontSerif[$typography] ?? $fontSerif['classic'] !!};
            --font-sans: {!! $fontSans[$typography] ?? $fontSans['classic'] !!};
            --hero-scrim-opacity: {{ $heroScrim }};
        }
        .font-luxury { font-family: var(--font-serif); }
        body { 
            font-family: var(--font-sans);
            letter-spacing: -0.01em;
        }
        .bg-accent { background-color: #000; }
        .text-accent { color: #000; }
        .border-accent { border-color: #000; }
        .shadow-accent { --tw-shadow-color: rgba(0,0,0,0.1); }

        .hero-scrim {
            position: absolute;
            inset: 0;
            background-color: black;
            opacity: var(--hero-scrim-opacity);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        .nav-link {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: #666;
            transition: color 0.3s ease;
        }
        .nav-link:hover { color: #000; }

        /* Cinematic Animations */
        @keyframes zoom-slow {
            from { transform: scale(1); }
            to { transform: scale(1.15); }
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scroll-down {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(200%); }
        }
        .animate-zoom-slow { animation: zoom-slow 20s infinite alternate ease-in-out; }
        .animate-fade-in-up { animation: fade-in-up 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in-up.delay-300 { animation-delay: 0.3s; opacity: 0; }

        @php
            $menuRoutes = [
                'storefront.index', 
                'storefront.collection', 
                'storefront.newArrivals', 
                'storefront.bestSellers', 
                'storefront.promotions',
                'storefront.scent-finder',
                'storefront.scent-finder.results'
            ];
            $isMenuPage = request()->routeIs($menuRoutes);
        @endphp

        @if(!$isMenuPage)
        .animate-zoom-slow, .animate-fade-in-up, .animate-fade-in, .animate-ping, .animate-bounce {
            animation: none !important;
            opacity: 1 !important;
            transform: none !important;
        }
        @endif

        /* Smooth Scroll & Scrollbar */
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #ffffff;
        }
        ::-webkit-scrollbar-thumb {
            background: #f3f4f6;
            border-radius: 10px;
            transition: background 0.3s ease;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #000000;
        }

        /* Selection Color */
        ::selection {
            background: #000000;
            color: #ffffff;
        }

        /* Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-100 { transition-delay: 0.1s; }
        .reveal-delay-200 { transition-delay: 0.2s; }
        .reveal-delay-300 { transition-delay: 0.3s; }
        .reveal-delay-400 { transition-delay: 0.4s; }
        .reveal-delay-500 { transition-delay: 0.5s; }

        /* Back to Top Button - Premium Refined */
        .back-to-top {
            opacity: 0;
            visibility: hidden;
            transform: translateY(30px);
            transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .back-to-top.is-visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 scroll-smooth"
      x-data="{}"
      x-init="
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, observerOptions);
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
      ">

    <!-- ── HEADER ───────────────────────────────────────────────────────── -->
    @php 
        $announcementEnabled = \App\Models\Setting::getValue('announcement_bar_enabled', '0') === '1';
        $announcementSticky = \App\Models\Setting::getValue('announcement_bar_sticky', '0') === '1';
    @endphp

    @if($announcementEnabled && !$announcementSticky)
        <div class="bg-black text-white text-[10px] font-bold tracking-[0.2em] uppercase flex items-center justify-center h-10 relative w-full z-[60]">
            {{ \App\Models\Setting::getValue('announcement_bar_text', '') }}
        </div>
    @endif

    <header x-data="{ 
                mobileMenu: false, 
                scrolled: false, 
                cartCount: {{ array_sum(session('cart', [])) }},
                searchOpen: false 
             }"
            x-init="
                $watch('searchOpen', value => { 
                    if(value) { 
                        setTimeout(() => $refs.searchInput.focus(), 100); 
                    } 
                });
            "
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            @cart-updated.window="cartCount = $event.detail.count"
            class="fixed w-full z-50 {{ $isMenuPage ? 'transition-all duration-300 ease-in-out' : '' }}"
            :style="(scrolled || !@json($announcementEnabled) || @json($announcementSticky)) ? 'top: 0' : 'top: 40px'">
        
        @if($announcementEnabled && $announcementSticky)
            <div class="bg-black text-white text-[10px] font-bold tracking-[0.2em] uppercase flex items-center justify-center h-10 relative w-full z-[60]">
                {{ \App\Models\Setting::getValue('announcement_bar_text', '') }}
            </div>
        @endif

        <!-- Navigation -->
        <nav :class="{ 
                'bg-white border-b border-gray-100 py-4 shadow-sm': scrolled || !@json($isMenuPage), 
                'bg-transparent py-4': !scrolled && @json($isMenuPage)
              }"
              class="w-full {{ $isMenuPage ? 'transition-all duration-300 ease-in-out' : '' }} relative">
         
         <!-- Top Scrim (Only visible on Menu Pages with Dark Hero before scroll) -->
         <div x-show="!scrolled && @json($isMenuPage) && @json($darkHero ?? false)" 
              x-transition:enter="transition ease-out duration-700"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-black/60 via-black/20 to-transparent pointer-events-none -z-10">
         </div>
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-full">
                
                <!-- Mobile Menu Toggle (Left) -->
                <div class="flex md:hidden items-center">
                    <button @click="mobileMenu = true" 
                            class="p-2 transition-all duration-500 hover:opacity-50"
                            :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                        </svg>
                    </button>
                </div>

                <!-- Logo (Center on mobile, Left on desktop) -->
                <div class="flex-shrink-0 absolute left-1/2 -translate-x-1/2 md:static md:translate-x-0">
                    <a href="{{ route('storefront.index') }}" 
                       class="flex items-center gap-3 transition-all duration-500">
                        @php
                            $logoPath = \App\Models\Setting::getValue('brand_logo');
                            $brandName = \App\Models\Setting::getValue('brand_name', 'Laman Store');
                            $logoStyle = \App\Models\Setting::getValue('brand_logo_style', 'both');
                        @endphp
                        @if(($logoStyle === 'logo' || $logoStyle === 'both') && $logoPath && Storage::disk('public')->exists($logoPath))
                            <img src="{{ asset('storage/' . $logoPath) }}" 
                                 alt="{{ $brandName }}" 
                                 class="h-8 md:h-12 w-auto object-contain transition-all duration-500">
                        @endif
                        @if($logoStyle === 'text' || $logoStyle === 'both' || !($logoPath && Storage::disk('public')->exists($logoPath)))
                            <span class="text-xl md:text-3xl font-serif tracking-tight uppercase whitespace-nowrap transition-all duration-500"
                                  :class="{ 'text-gray-800': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                                {{ $brandName }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Desktop Links (Center) -->
                <div class="hidden md:flex items-center space-x-14">
                    @php
                        $navItems = [
                            ['route' => 'storefront.index', 'label' => 'Home'],
                            ['route' => 'storefront.collection', 'label' => 'Collection'],
                            ['route' => 'storefront.newArrivals', 'label' => 'New Arrivals'],
                            ['route' => 'storefront.bestSellers', 'label' => 'Best Sellers'],
                            ['route' => 'storefront.scent-finder', 'label' => 'Scent Finder'],
                        ];
                        // Automated Promotions Page: Only show if active promotions exist
                        if (\App\Models\Product::hasActivePromotions(Auth::user())) {
                            $navItems[] = ['route' => 'storefront.promotions', 'label' => 'Promotions'];
                        }
                    @endphp
                    @foreach($navItems as $item)
                        <a href="{{ $item['route'] ? route($item['route']) : '#' }}" 
                            class="text-[10px] font-bold tracking-[0.25em] transition-all duration-300 uppercase relative group"
                            :class="{ 
                                'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 
                                'text-white/40 hover:text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false),
                                'text-gray-500 hover:text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false)
                            }">
                            {{ $item['label'] }}
                            @if($item['route'] && request()->routeIs($item['route']))
                                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-4 h-[1.5px] bg-current transition-all duration-500"></span>
                            @else
                                <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-0 h-[1.5px] bg-current transition-all duration-500 group-hover:w-4"></span>
                            @endif
                        </a>
                    @endforeach
                </div>

                <!-- Icons (Right) -->
                <div class="flex items-center space-x-2 md:space-x-5">
                    <button @click="searchOpen = !searchOpen" 
                            class="p-2 transition-all duration-500 hover:opacity-50"
                            :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    </button>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="p-2 transition-all duration-500 hover:opacity-50"
                           :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }"
                           title="My Account">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="p-2 transition-all duration-500 hover:opacity-50"
                           :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }"
                           title="Login">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                        </a>
                    @endauth

                    <a href="{{ route('cart.index') }}" 
                       class="p-2 transition-all duration-500 hover:opacity-50 relative"
                       :class="{ 'text-black': scrolled || !@json($isMenuPage) || !@json($darkHero ?? false), 'text-white': !scrolled && @json($isMenuPage) && @json($darkHero ?? false) }">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        <template x-if="cartCount > 0">
                            <span x-text="cartCount" class="absolute top-1 right-1 bg-black text-white text-[8px] font-black px-1.5 py-0.5 rounded-full ring-1 ring-white transition-all transform scale-90"></span>
                        </template>
                    </a>
                </div>
                </div>
        <!-- Redesigned Floating Search Overlay -->
        <div x-show="searchOpen" 
             x-cloak 
             @click.away="searchOpen = false" 
             @keydown.escape.window="searchOpen = false"
             x-transition:enter="transition ease-out duration-500" 
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-300" 
             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="fixed left-1/2 -translate-x-1/2 top-[120px] w-[95%] max-w-[600px] z-[60]">
            
            <div class="relative flex items-center bg-white/80 backdrop-blur-2xl border border-white/20 rounded-full px-7 py-1.5 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all duration-500 hover:shadow-[0_20px_60px_rgba(0,0,0,0.15)] group focus-within:ring-1 focus-within:ring-black/5">
                {{-- Left Icon --}}
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
                
                {{-- Input --}}
                <form action="{{ route('storefront.collection') }}" method="GET" class="flex-1 px-4">
                    <input type="text" 
                           name="search" 
                           x-ref="searchInput"
                           placeholder="Search fragrances..." 
                           class="w-full bg-transparent border-none focus:ring-0 text-[13px] font-black text-gray-900 placeholder-gray-500 py-3 uppercase tracking-[0.25em]">
                </form>

                {{-- Right Icon (Submit) --}}
                <button type="submit" class="p-2 text-gray-500 hover:text-black transition-all transform hover:translate-x-1.5 duration-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Sidebar Menu -->
        <div x-show="mobileMenu" x-cloak class="md:hidden fixed inset-0 z-[100] overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
            <!-- Background Backdrop -->
            <div x-show="mobileMenu" 
                 x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="mobileMenu = false"></div>

            <div class="fixed inset-y-0 left-0 flex max-w-full pr-10">
                <div x-show="mobileMenu" 
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                     class="pointer-events-auto w-screen max-w-[320px]">
                    <div class="flex h-full flex-col overflow-y-auto bg-white shadow-2xl">
                        <!-- Header -->
                        <div class="px-8 pt-10 pb-8 flex items-center justify-between border-b border-gray-50">
                            <div class="flex items-center gap-3">
                                @php
                                    $logoPath = \App\Models\Setting::getValue('brand_logo');
                                    $brandName = \App\Models\Setting::getValue('brand_name', 'Laman Store');
                                    $logoStyle = \App\Models\Setting::getValue('brand_logo_style', 'both');
                                @endphp
                                @if(($logoStyle === 'logo' || $logoStyle === 'both') && $logoPath && Storage::disk('public')->exists($logoPath))
                                    <img src="{{ asset('storage/' . $logoPath) }}" 
                                         alt="{{ $brandName }}" 
                                         class="h-8 w-auto object-contain">
                                @endif
                                @if($logoStyle === 'text' || $logoStyle === 'both' || !($logoPath && Storage::disk('public')->exists($logoPath)))
                                    <h2 class="text-lg font-serif italic tracking-tight uppercase">{{ $brandName }}</h2>
                                @endif
                            </div>
                            <button @click="mobileMenu = false" class="p-2 text-gray-400 hover:text-black transition-colors">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Links -->
                        <div class="px-8 py-10 flex-1">
                            <nav class="space-y-8">
                                @foreach($navItems as $item)
                                    <a href="{{ $item['route'] ? route($item['route']) : '#' }}" 
                                       class="block text-[14px] font-black uppercase tracking-[0.3em] {{ request()->routeIs($item['route']) ? 'text-black' : 'text-gray-400' }} hover:text-black transition-colors">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </nav>
                        </div>

                        <!-- Footer Links -->
                        <div class="px-8 py-10 bg-gray-50/50 space-y-6">
                            @auth
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 group">
                                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-black transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <span class="text-[12px] font-black uppercase tracking-widest text-gray-600">My Profile</span>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="flex items-center gap-4 group">
                                    <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-gray-400 group-hover:text-black transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                                    </div>
                                    <span class="text-[12px] font-black uppercase tracking-widest text-gray-600">Sign In</span>
                                </a>
                            @endauth
                            
                            <p class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.2em] pt-4">
                                &copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    </header>

    <!-- ── MAIN CONTENT ────────────────────────────────────────────────── -->
    <main class="{{ $hasHero ? 'pt-0' : 'pt-20' }} min-h-screen">
        {{ $slot }}
    </main>

    <!-- ── FOOTER ──────────────────────────────────────────────────────────── -->
    <footer class="bg-[#FBFBFD] border-t border-gray-100 pt-24 pb-16 relative overflow-hidden">
        {{-- Back to Top Button (Premium Refined) --}}
        <div x-data="{ 
                showButton: false,
                scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }
             }"
             x-init="window.addEventListener('scroll', () => { showButton = window.pageYOffset > 800 })"
             :class="{ 'is-visible': showButton }"
             class="back-to-top absolute right-8 sm:right-12 top-0 -translate-y-1/2 z-20">
            <button @click="scrollToTop()" 
                    class="group flex flex-col items-center gap-3">
                <div class="w-14 h-14 bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-xl shadow-black/5 group-hover:border-black group-hover:shadow-2xl transition-all duration-700 relative overflow-hidden">
                    {{-- Animated background fill on hover --}}
                    <div class="absolute inset-0 bg-black translate-y-full group-hover:translate-y-0 transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"></div>
                    
                    <svg class="w-5 h-5 text-gray-900 group-hover:text-white relative z-10 group-hover:-translate-y-1 transition-all duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-[0.5em] text-gray-500 group-hover:text-black transition-colors duration-700">Top</span>
            </button>
        </div>

        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
            
            {{-- Newsletter & Brand --}}
            <div class="flex flex-col lg:flex-row justify-between items-start gap-16 mb-24 pb-20 border-b border-gray-100/50 reveal">
                <div class="max-w-md">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 bg-black rounded-2xl flex items-center justify-center text-white shadow-xl shadow-black/10">
                            <span class="font-luxury text-xl font-bold italic">R</span>
                        </div>
                        <span class="font-luxury text-2xl font-black tracking-tight text-gray-900">{{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}</span>
                    </div>
                    <p class="text-[15px] text-gray-500 font-medium leading-relaxed mb-10">
                        {{ \App\Models\Setting::getValue('footer_story', 'Join our exclusive circle for early access to limited collections, sanctuary updates, and the art of fine fragrance.') }}
                    </p>

                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-20 gap-y-12">
                    <div class="reveal reveal-delay-100">
                        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-400 mb-8">Collections</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ route('storefront.collection', ['category' => 'men']) }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">For Men</a></li>
                            <li><a href="{{ route('storefront.collection', ['category' => 'woman']) }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">For Women</a></li>
                            <li><a href="{{ route('storefront.collection', ['category' => 'unisex']) }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Unisex</a></li>
                            <li><a href="{{ route('storefront.newArrivals') }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">New Arrivals</a></li>
                        </ul>
                    </div>
                    
                    <div class="reveal reveal-delay-200">
                        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-400 mb-8">The Sanctuary</h4>
                        <ul class="space-y-4">
                            <li><a href="#" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Our Story</a></li>
                            <li><a href="#" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Bespoke Service</a></li>
                            <li><a href="#" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Find a Store</a></li>
                            <li><a href="#" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Journal</a></li>
                        </ul>
                    </div>

                    <div class="reveal reveal-delay-300">
                        <h4 class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-400 mb-8">Service</h4>
                        <ul class="space-y-4">
                            <li><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::getValue('contact_whatsapp', '')) }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">WhatsApp Us</a></li>
                            <li><a href="mailto:{{ \App\Models\Setting::getValue('contact_email', '') }}" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Concierge Email</a></li>
                            <li><a href="#" class="text-[14px] text-gray-600 hover:text-black font-bold transition-colors">Privacy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            {{-- Social & Copyright --}}
            <div class="flex flex-col md:flex-row justify-between items-center gap-8 reveal reveal-delay-400">
                <div class="flex items-center gap-10">
                    <a href="{{ \App\Models\Setting::getValue('footer_instagram', '#') }}" class="group" target="_blank">
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 group-hover:text-black transition-colors">Instagram</span>
                    </a>
                    <a href="{{ \App\Models\Setting::getValue('footer_facebook', '#') }}" class="group" target="_blank">
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 group-hover:text-black transition-colors">Facebook</span>
                    </a>
                    <a href="#" class="group">
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-gray-400 group-hover:text-black transition-colors">Tiktok</span>
                    </a>
                </div>
                
                <p class="text-[11px] text-gray-400 font-medium tracking-wide">
                    {{ \App\Models\Setting::getValue('copyright_text', '© ' . date('Y') . ' ' . \App\Models\Setting::getValue('brand_name', 'Laman Store') . ' Malaysia. All rights reserved.') }}
                </p>
            </div>
        </div>
    </footer>


    <!-- Notifications -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-y-10 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-10 opacity-0"
             class="fixed bottom-10 right-10 z-[60] bg-black text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-4 ring-4 ring-black/10">
            <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span class="text-[13px] font-black tracking-wide uppercase">{{ session('success') }}</span>
        </div>
    @endif



</body>
</html>
