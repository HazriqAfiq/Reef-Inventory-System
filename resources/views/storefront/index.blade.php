<x-storefront-layout :hasHero="true" :darkHero="true">
    <x-slot name="title">Luxury Fragrances</x-slot>

    <!-- ── IMMERSIVE HERO SECTION ─────────────────────────────────────────── -->
    <section class="relative h-screen min-h-[600px] flex items-center justify-center overflow-hidden bg-black text-white">
        <!-- Cinematic Scrim System -->
        <div class="hero-scrim z-[1]"></div> <!-- Global Tint -->
        <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/90 via-black/10 to-transparent z-[2]"></div> <!-- Top Scrim -->
        <div class="absolute inset-x-0 bottom-0 h-2/3 bg-gradient-to-t from-black/90 via-black/20 to-transparent z-[2]"></div> <!-- Bottom Scrim -->

        <!-- Background Scaling Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . ($settings['homepage_hero_image'] ?? 'hero/hero_cinematic.png')) }}" 
                 class="w-full h-full object-cover animate-zoom-slow" 
                 alt="Cinematic Perfume">
        </div>

        <!-- Hero Content -->
        <div class="relative z-[3] w-full text-center px-4 animate-fade-in-up mt-16 flex flex-col items-center justify-center">
            <div class="flex w-full items-center justify-center gap-4 md:gap-10 mb-8">
                <p class="w-8 md:w-20 h-[1px] bg-white opacity-40"></p>
                <p class="text-white/60 text-3xl md:text-6xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                    THE ART OF <span class="text-white font-semibold">PURE ESSENCE</span>
                </p>
                <p class="w-8 md:w-20 h-[1px] bg-white opacity-40"></p>
            </div>
            
            <p class="text-[11px] font-bold text-white uppercase tracking-[0.6em] mb-16 opacity-80">
                {{ $settings['homepage_subtitle'] ?? 'The Laman Signature' }}
            </p>

            <div class="flex flex-col items-center gap-16 animate-fade-in-up delay-300">
                <a href="{{ route('storefront.collection') }}" 
                   class="inline-block border border-white px-16 py-5 rounded-2xl text-[11px] font-black tracking-[0.4em] uppercase hover:bg-white hover:text-black transition-all duration-300 shadow-2xl shadow-white/5">
                    Explore Collection
                </a>
            </div>
        </div>

        <x-scroll-indicator />
    </section>

    <!-- ── NEW ARRIVALS ──────────────────────────────────────────────────── -->
    <section class="py-24 bg-white overflow-hidden reveal">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        NEW <span class="text-gray-800 font-medium">ARRIVALS</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Timeless scents, recently unveiled</p>
            </div>

            @if($settings['new_arrivals_hero_image'] ?? null)
                <div class="mb-16 rounded-[2.5rem] overflow-hidden aspect-[21/7] md:aspect-[21/6] shadow-2xl shadow-black/5">
                    <img src="{{ asset('storage/' . $settings['new_arrivals_hero_image']) }}" class="w-full h-full object-cover" alt="New Arrivals Banner">
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($newArrivals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16 text-center">
                <a href="{{ route('storefront.newArrivals') }}" class="inline-block border border-gray-800 px-12 py-4 rounded-2xl text-[11px] font-black tracking-[0.3em] uppercase text-gray-800 hover:bg-gray-800 hover:text-white transition-all duration-500">
                    Explore New Arrivals
                </a>
            </div>
        </div>
    </section>

    <!-- ── EXCLUSIVE PROMOTIONS ────────────────────────────────────────── -->
    @if($promotionalItems->count() > 0)
    <section class="py-24 bg-white overflow-hidden reveal">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        EXCLUSIVE <span class="text-gray-800 font-medium">OFFERS</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Limited time prestige collections</p>
            </div>

            @if($settings['promotions_hero_image'] ?? null)
                <div class="mb-16 rounded-[2.5rem] overflow-hidden aspect-[21/7] md:aspect-[21/6] shadow-2xl shadow-black/5">
                    <img src="{{ asset('storage/' . $settings['promotions_hero_image']) }}" class="w-full h-full object-cover" alt="Exclusive Offers Banner">
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($promotionalItems as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16 text-center">
                <a href="{{ route('storefront.promotions') }}" class="inline-block border border-gray-800 px-12 py-4 rounded-2xl text-[11px] font-black tracking-[0.3em] uppercase text-gray-800 hover:bg-gray-800 hover:text-white transition-all duration-500">
                    View All Promotions
                </a>
            </div>
        </div>
    </section>
    @endif



    <!-- ── BEST SELLERS ─────────────────────────────────────────────────── -->
    <section class="py-24 bg-white reveal">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
            <div class="text-center mb-16">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        BEST <span class="text-gray-800 font-medium">SELLERS</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Our most celebrated signature scents</p>
            </div>

            @if($settings['best_sellers_hero_image'] ?? null)
                <div class="mb-16 rounded-[2.5rem] overflow-hidden aspect-[21/7] md:aspect-[21/6] shadow-2xl shadow-black/5">
                    <img src="{{ asset('storage/' . $settings['best_sellers_hero_image']) }}" class="w-full h-full object-cover" alt="Best Sellers Banner">
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-16 text-center">
                <a href="{{ route('storefront.bestSellers') }}" class="inline-block border border-gray-800 px-12 py-4 rounded-2xl text-[11px] font-black tracking-[0.3em] uppercase text-gray-800 hover:bg-gray-800 hover:text-white transition-all duration-500">
                    Explore Best Sellers
                </a>
            </div>
        </div>
    </section>

    <!-- ── BRAND PHILOSOPHY ─────────────────────────────────────────────── -->
    <section class="py-40 bg-white overflow-hidden relative border-t border-b border-gray-50 reveal">
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="flex items-center justify-center gap-4 mb-20">
                <p class="w-10 h-0.5 bg-gray-800"></p>
                <h2 class="text-[11px] font-bold uppercase tracking-[0.5em] text-gray-400 italic">{{ $settings['philosophy_title'] ?? 'Our Philosophy' }}</h2>
                <p class="w-10 h-0.5 bg-gray-800"></p>
            </div>
            <p class="text-3xl sm:text-5xl font-serif text-black font-medium leading-[1.4] mb-16 italic">
                "{{ $settings['philosophy_quote'] ?? 'Fragrances are not just scents, they are stories bottled in glass, waiting to be told across your skin.' }}"
            </p>
            <a href="{{ route('storefront.collection') }}" class="inline-block text-[11px] font-bold uppercase tracking-[0.4em] text-gray-800 border-b border-gray-800 pb-2 hover:opacity-50 transition-opacity">{{ $settings['philosophy_link_text'] ?? 'Our Heritage' }}</a>
        </div>
    </section>

</x-storefront-layout>
