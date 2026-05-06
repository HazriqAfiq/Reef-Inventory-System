<x-storefront-layout :hasHero="true" :darkHero="true">
    <x-slot name="title">All Fragrances</x-slot>

    <div class="bg-white min-h-screen">
        <!-- ── CINEMATIC SHOP BANNER ────────────────────────────────────────────────── -->
        <header class="relative h-[40vh] min-h-[350px] flex flex-col items-center justify-center overflow-hidden bg-black text-white">
            <!-- Cinematic Scrim System -->
            <div class="absolute inset-0 z-[1] bg-black/40"></div> <!-- Global Tint -->
            <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/90 via-black/10 to-transparent z-[2]"></div> <!-- Top Scrim -->
            <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-black/90 via-black/40 to-transparent z-[2]"></div> <!-- Bottom Scrim -->

            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('storage/' . ($settings['collection_hero_image'] ?? 'hero/hero_cinematic.png')) }}" 
                     class="w-full h-full object-cover animate-zoom-slow" 
                     alt="Shop cinematic background">
            </div>

            <div class="relative z-[3] text-center px-4 animate-fade-in-up mt-16">
                <div class="inline-flex gap-8 items-center mb-6">
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                    <p class="text-white/60 text-3xl md:text-5xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                        {{ explode(' ', $settings['collection_title'] ?? 'OUR COLLECTION')[0] ?? 'OUR' }} 
                        <span class="text-white font-semibold">
                            {{ implode(' ', array_slice(explode(' ', $settings['collection_title'] ?? 'OUR COLLECTION'), 1)) ?: 'COLLECTION' }}
                        </span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                </div>
                <p class="text-[11px] font-bold text-white uppercase tracking-[0.5em] drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $settings['collection_description'] ?? 'Timeless Scents. Curated for You.' }}</p>
            </div>

            <x-scroll-indicator />
        </header>

        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12 py-16">
            <div x-data="{ 
                loading: false,
                categories: @js(explode(',', request('category', ''))),
                types: @js(explode(',', request('type', ''))),
                minPrice: @js(request('min_price', '')),
                maxPrice: @js(request('max_price', '')),
                sort: @js(request('sort', 'latest')),
                
                async fetchProducts(url = null) {
                    this.loading = true;
                    if (!url) {
                        url = new URL(window.location.href);
                        url.searchParams.set('category', this.categories.filter(c => c).join(','));
                        url.searchParams.set('type', this.types.filter(t => t).join(','));
                        url.searchParams.set('sort', this.sort);
                        if (this.minPrice) url.searchParams.set('min_price', this.minPrice);
                        else url.searchParams.delete('min_price');
                        if (this.maxPrice) url.searchParams.set('max_price', this.maxPrice);
                        else url.searchParams.delete('max_price');
                    }

                    try {
                        const response = await fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const html = await response.text();
                        document.getElementById('products-container').innerHTML = html;
                        window.history.pushState({}, '', url);
                        
                        // Scroll to top of grid
                        window.scrollTo({ top: document.getElementById('products-container').offsetTop - 150, behavior: 'smooth' });
                    } catch (error) {
                        console.error('Error fetching products:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                toggleCategory(cat) {
                    if (this.categories.includes(cat)) {
                        this.categories = this.categories.filter(c => c !== cat);
                    } else {
                        this.categories.push(cat);
                    }
                    this.fetchProducts();
                },
                toggleType(type) {
                    if (this.types.includes(type)) {
                        this.types = this.types.filter(t => t !== type);
                    } else {
                        this.types.push(type);
                    }
                    this.fetchProducts();
                },
                handleSort(val) {
                    this.sort = val;
                    this.fetchProducts();
                }
            }" @click="if($event.target.closest('.ajax-link')) { $event.preventDefault(); fetchProducts($event.target.closest('.ajax-link').href); }">
                
                <!-- ── REFINED TOP BAR (Filters & Sort) ────────────────────────── -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-16 pb-8 border-b border-gray-100 gap-8">
                    <div class="flex flex-col gap-6 w-full lg:w-auto">
                        <!-- Category Buttons -->
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-black/40 mr-2">Category:</span>
                            @foreach([
                                'men' => 'Men',
                                'woman' => 'Women',
                                'unisex' => 'Unisex'
                            ] as $val => $label)
                                <button type="button" @click="toggleCategory('{{ $val }}')"
                                        :disabled="loading"
                                        :class="categories.includes('{{ $val }}') ? 'bg-black text-white border-black' : 'bg-transparent text-gray-500 border-gray-200 hover:border-gray-800 hover:text-black'"
                                        class="px-5 py-2 border rounded-full text-[12px] font-medium transition-all duration-300 disabled:opacity-50">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Type Buttons -->
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-black/40 mr-2">Type:</span>
                            @foreach(['Perfume sprays', 'Body sprays', 'Hair mists', 'Roll-on perfumes'] as $type)
                                <button type="button" @click="toggleType('{{ $type }}')"
                                        :disabled="loading"
                                        :class="types.includes('{{ $type }}') ? 'bg-black text-white border-black' : 'bg-transparent text-gray-500 border-gray-200 hover:border-gray-800 hover:text-black'"
                                        class="px-5 py-2 border rounded-full text-[12px] font-medium transition-all duration-300 disabled:opacity-50">
                                    {{ $type }}
                                </button>
                            @endforeach
                        </div>

                        <!-- Price Range -->
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-black/40 mr-2">Price Range:</span>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">RM</span>
                                    <input type="number" x-model="minPrice" placeholder="Min" 
                                           class="w-24 pl-8 pr-3 py-2 border border-gray-200 rounded-full text-[12px] font-medium focus:ring-1 focus:ring-black focus:border-black transition-all">
                                </div>
                                <span class="text-gray-300">─</span>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-gray-400">RM</span>
                                    <input type="number" x-model="maxPrice" placeholder="Max" 
                                           class="w-24 pl-8 pr-3 py-2 border border-gray-200 rounded-full text-[12px] font-medium focus:ring-1 focus:ring-black focus:border-black transition-all">
                                </div>
                                <button @click="fetchProducts()" :disabled="loading" 
                                        class="ml-2 p-2 bg-black text-white rounded-full hover:bg-gray-800 transition-colors disabled:opacity-50">
                                    <template x-if="!loading">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </template>
                                    <template x-if="loading">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </template>
                                </button>
                                <button @click="minPrice=''; maxPrice=''; fetchProducts()" 
                                        x-show="minPrice || maxPrice"
                                        class="text-[10px] font-bold uppercase tracking-widest text-red-400 hover:text-red-600 ml-2 transition-colors underline underline-offset-4">Reset Price</button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-12">
                         <div class="relative" x-data="{ sortOpen: false }">
                            <button @click="sortOpen = !sortOpen" @click.away="sortOpen = false" 
                                    class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.2em] text-black/40 hover:text-black transition-colors">
                                <span>Sort By: </span>
                                <span class="text-black ml-1" x-text="sort == 'low-high' ? 'Low to High' : (sort == 'high-low' ? 'High to Low' : 'Latest')"></span>
                                <svg class="w-3 h-3 transition-transform duration-300" :class="{ 'rotate-180': sortOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="sortOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-cloak
                                 class="absolute right-0 mt-4 w-48 bg-white border border-gray-100 shadow-2xl shadow-black/5 z-50 overflow-hidden">
                                <div class="flex flex-col">
                                    @foreach([
                                        'latest' => 'Latest',
                                        'low-high' => 'Price: Low to High',
                                        'high-low' => 'Price: High to Low'
                                    ] as $val => $label)
                                        <button @click="handleSort('{{ $val }}'); sortOpen = false"
                                           :class="sort == '{{ $val }}' ? 'text-black bg-gray-50/50' : 'text-gray-400'"
                                           class="w-full text-left px-6 py-4 text-[10px] font-bold uppercase tracking-widest transition-colors hover:bg-gray-50">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- ── PRODUCT GRID ─────────────────────────────────────────── -->
                <div id="products-container" class="relative min-h-[400px]">
                    <div :class="{ 'opacity-50 pointer-events-none': loading }" class="transition-opacity duration-300">
                        @include('storefront.partials.products-grid')
                    </div>
                    
                    <template x-if="loading">
                        <div class="absolute inset-0 flex items-center justify-center z-10">
                            <div class="w-12 h-12 border-4 border-black/10 border-t-black rounded-full animate-spin"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-storefront-layout>
