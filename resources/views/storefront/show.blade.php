<x-storefront-layout>
    <x-slot name="title">{{ $product->name }}</x-slot>

    <div class="bg-white border-t-2 pt-8 lg:pt-16" x-data="{ 
        activeImage: 0, 
        selectedVariantId: {{ $product->variants->where('stock', '>', 0)->first()?->id ?? $product->variants->first()?->id ?? 'null' }},
        variants: @js($product->variants),
        get selectedVariant() {
            return this.variants.find(v => v.id === this.selectedVariantId) || null;
        },
        lowStockThreshold: 15
    }">
        <div class="max-w-[1600px] mx-auto w-full px-6 sm:px-8 lg:px-12 pb-16">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">
                
                <!-- ── PRODUCT IMAGES (Swiper Carousel) ───────────────────────── -->
                <div class="w-full lg:w-[50%] flex flex-col md:flex-row-reverse gap-6"
                     x-init="
                        const thumbSwiper = new Swiper('.thumb-swiper', {
                            spaceBetween: 12,
                            slidesPerView: 4,
                            direction: 'horizontal',
                            breakpoints: {
                                768: { direction: 'vertical', slidesPerView: 5 }
                            },
                            watchSlidesProgress: true,
                            centerInsufficientSlides: true,
                        });
                        const mainSwiper = new Swiper('.main-swiper', {
                            spaceBetween: 0,
                            effect: 'fade',
                            fadeEffect: { crossFade: true },
                            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                            thumbs: {
                                swiper: thumbSwiper,
                            },
                        });
                     ">
                    <style>
                         .swiper-button-disabled { display: none !important; }
                     </style>
                    <!-- Main Image Display -->
                    <div class="w-full relative bg-[#FAFAFA] overflow-hidden group rounded-2xl" style="aspect-ratio: 1/1;">
                        <div class="swiper main-swiper absolute inset-0 w-full h-full">
                            <div class="swiper-wrapper">
                                @forelse($product->images as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" 
                                             class="w-full h-full object-cover transition-transform duration-700" alt="{{ $product->name }}">
                                    </div>
                                @empty
                                    <div class="swiper-slide flex items-center justify-center">
                                        <img src="https://placehold.co/800x800?text={{ urlencode($product->name) }}" class="w-full h-full object-cover opacity-10" alt="Placeholder">
                                    </div>
                                @endforelse
                            </div>
                            <!-- Navigation Buttons -->
                            <div class="swiper-button-next !w-10 !h-10 !bg-white/90 !rounded-full !shadow-lg opacity-100 lg:opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-0 lg:translate-x-4 group-hover:translate-x-0 after:hidden flex items-center justify-center">
                                <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <div class="swiper-button-prev !w-10 !h-10 !bg-white/90 !rounded-full !shadow-lg opacity-100 lg:opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-0 lg:-translate-x-4 group-hover:translate-x-0 after:hidden flex items-center justify-center">
                                <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    <div class="md:w-[12%] relative z-[20]">
                        <style>
                            .thumb-swiper .swiper-slide {
                                transition: all 0.3s ease;
                                background: #ffffff !important;
                                border: 1px solid #eeeeee !important;
                                border-radius: 12px !important;
                                overflow: hidden !important;
                                cursor: pointer;
                                opacity: 0.6 !important;
                            }
                            .thumb-swiper .swiper-slide-thumb-active {
                                opacity: 1 !important;
                                border-color: #000000 !important;
                                border-width: 2px !important;
                                box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
                            }
                            .thumb-swiper .swiper-slide img {
                                width: 100% !important;
                                height: 100% !important;
                                object-fit: cover !important;
                                filter: none !important;
                                brightness: 1 !important;
                                mix-blend-mode: normal !important;
                            }
                        </style>
                        <div class="swiper thumb-swiper h-full max-h-[600px]">
                            <div class="swiper-wrapper">
                                @foreach($product->images as $img)
                                    <div class="swiper-slide aspect-square">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" 
                                             alt="Thumbnail">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── PRODUCT DETAILS ───────────────────────────────────────── -->
                <div class="w-full lg:w-[50%] flex flex-col lg:justify-center py-4 lg:py-0">
                    <nav class="flex mb-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">
                        <a href="{{ route('storefront.index') }}" class="hover:text-black transition-colors">Home</a>
                        <span class="mx-2">/</span>
                        <a href="{{ route('storefront.collection') }}" class="hover:text-black transition-colors">Collection</a>
                        <span class="mx-2">/</span>
                        <span class="text-gray-900">{{ $product->name }}</span>
                    </nav>

                    <div class="pb-6 border-b border-gray-100/50">
                        <div class="flex items-center gap-2 mb-3">
                            @if($product->release_date && $product->release_date >= now()->subMonths(3))
                                <span class="px-3 py-1 bg-black text-white text-[9px] font-black uppercase tracking-[0.3em] rounded-full shadow-xl shadow-black/20 border border-white/10">New Arrival</span>
                            @endif
                            @if($product->sales_sum_quantity && $product->sales_sum_quantity > 10)
                                <span class="px-3 py-1 bg-black text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-black/10">Best Seller</span>
                            @endif
                            @if($product->effective_promotion_badge)
                                <span class="px-3 py-1 bg-amber-400 text-black text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg shadow-amber-400/20">
                                    {{ $product->effective_promotion_badge }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl lg:text-4xl font-light text-gray-900 uppercase tracking-[0.15em] leading-tight mb-4">
                            {{ $product->name }}
                        </h1>
                        
                        <p class="text-[11px] text-gray-400 font-bold uppercase tracking-[0.3em] mb-3">{{ $product->category?->name ?? 'Exquisite Fragrance' }}</p>
                        
                        <div class="mb-4">
                            <span class="text-[11px] font-medium text-gray-500 uppercase tracking-widest">
                                {{ collect([$product->top_note, $product->heart_note, $product->base_note])->filter()->join(' · ') ?: 'Signature Composition' }}
                            </span>
                        </div>



                        <div class="flex flex-col gap-1 mb-3">
                            <div class="flex items-baseline gap-4">
                                <span class="text-xl font-black text-black tracking-widest uppercase">
                                    RM <span x-text="selectedVariant ? Number(selectedVariant.retail_price).toFixed(2) : '{{ number_format($product->retail_price, 2) }}'"></span>
                                </span>
                            </div>
                            

                        </div>

                        <div class="mb-4">
                            <span class="text-[9px] font-black text-gray-900 uppercase tracking-[0.2em] block mb-2">Select Volume</span>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->variants as $variant)
                                    <button @click="selectedVariantId = {{ $variant->id }}"
                                            :class="selectedVariantId === {{ $variant->id }} ? 'bg-black text-white border-black shadow-xl shadow-black/10' : 'bg-white text-gray-500 border-gray-100 hover:border-black'"
                                            class="px-6 py-2 border rounded-2xl text-[12px] font-black tracking-[0.2em] transition-all duration-300 uppercase">
                                        {{ $variant->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" :class="selectedVariant && selectedVariant.stock > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-red-500'"></div>
                                <span class="text-[11px] font-black uppercase tracking-widest" :class="selectedVariant && selectedVariant.stock > 0 ? 'text-emerald-600' : 'text-red-500'">
                                    <span x-text="selectedVariant && selectedVariant.stock > 0 ? 'In stock' : 'Currently Unavailable'"></span>
                                </span>
                            </div>
                            <template x-if="selectedVariant && selectedVariant.stock > 0 && selectedVariant.stock <= lowStockThreshold">
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-[0.2em] rounded-full border border-red-100 animate-pulse">
                                    Only <span x-text="selectedVariant.stock"></span> left
                                </span>
                            </template>
                        </div>
                    </div>
                    
                    <!-- Add to Cart & Trust Section -->
                    <div class="py-6" x-data="{ 
                        adding: false, 
                        added: false,
                        quantity: 1,
                        async addToCart() {
                            this.adding = true;
                            try {
                                const response = await fetch('{{ route('cart.add') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        product_id: {{ $product->id }},
                                        variant_id: this.selectedVariantId,
                                        quantity: this.quantity
                                    })
                                });
                                const data = await response.json();
                                if (data.success) {
                                    this.added = true;
                                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                                    setTimeout(() => this.added = false, 2000);
                                }
                            } catch (error) {
                                console.error('Error adding to cart:', error);
                            } finally {
                                this.adding = false;
                            }
                        }
                    }">
                        <form @submit.prevent="addToCart">
                            <div class="space-y-12">
                                <button type="submit" 
                                        :disabled="adding || added || !selectedVariant || selectedVariant.stock <= 0"
                                        class="w-full bg-black/90 backdrop-blur-md text-white px-12 py-3 rounded-2xl text-[12px] font-black uppercase tracking-[0.3em] hover:bg-black transition-all disabled:bg-gray-400 flex items-center justify-center gap-2 shadow-xl shadow-black/10">
                                    <template x-if="adding">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </template>
                                    <span x-text="added ? 'ADDED TO CART ✓' : (adding ? 'ADDING...' : (selectedVariant && selectedVariant.stock > 0 ? 'ADD TO CART' : 'OUT OF STOCK'))"></span>
                                </button>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-6 border-t border-gray-100/50">
                                    <!-- Golden Guarantee -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex items-center sm:flex-col justify-center text-left sm:text-center bg-white transition-all hover:border-black group gap-4 sm:gap-0">
                                        <svg class="w-7 h-7 text-gray-900 sm:mb-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                        <div>
                                            <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">Golden Guarantee</p>
                                            <p class="text-[9px] lg:text-[10px] text-gray-400">Return within 30 days</p>
                                        </div>
                                    </div>
 
                                    <!-- High Stability -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex items-center sm:flex-col justify-center text-left sm:text-center bg-white transition-all hover:border-black group gap-4 sm:gap-0">
                                        <svg class="w-7 h-7 text-gray-900 sm:mb-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                                        </svg>
                                        <div>
                                            <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">High Stability</p>
                                            <p class="text-[9px] lg:text-[10px] text-gray-400">Lasts for hours</p>
                                        </div>
                                    </div>
 
                                    <!-- Fast Delivery -->
                                    <div class="border border-gray-200 rounded-2xl p-4 flex items-center sm:flex-col justify-center text-left sm:text-center bg-white transition-all hover:border-black group gap-4 sm:gap-0">
                                        <svg class="w-7 h-7 text-gray-900 sm:mb-3 group-hover:scale-110 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.129-1.125V11.25c0-4.446-3.51-8.31-7.962-8.447-4.062-.123-7.514 3.018-8.134 6.84a1.875 1.875 0 000 .375v2.25M17.25 18.75V11.25M17.25 18.75H6.75V11.25m10.5 0V7.5a3.75 3.75 0 10-7.5 0v3.75m0 0h7.5" />
                                        </svg>
                                        <div>
                                            <p class="text-[11px] lg:text-[12px] font-bold text-gray-900 mb-1 leading-tight tracking-wide">Fast Delivery</p>
                                            <p class="text-[9px] lg:text-[10px] text-gray-400">within 6 hours.</p>
                                        </div>
                                    </div>
                                </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <!-- ── DESCRIPTION & REVIEWS ────────────────────────────────────── -->
            <div class="mt-24 border-t border-gray-100 pt-24" x-data="{ tab: 'description' }">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-center justify-center gap-12 border-b border-gray-100 mb-12">
                        <button @click="tab = 'description'" 
                                class="relative py-4 text-[11px] font-bold uppercase tracking-[0.3em] transition-all"
                                :class="tab === 'description' ? 'text-black' : 'text-gray-400 hover:text-black'">
                            Description
                            <div x-show="tab === 'description'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-x-0"
                                 x-transition:enter-end="opacity-100 scale-x-100"
                                 class="absolute bottom-0 left-0 w-full h-[2px] bg-black"></div>
                        </button>
                        <button @click="tab = 'reviews'" 
                                class="relative py-4 text-[11px] font-bold uppercase tracking-[0.3em] transition-all flex items-center gap-3"
                                :class="tab === 'reviews' ? 'text-black' : 'text-gray-400 hover:text-black'">
                            Reviews 
                            <span class="text-[9px] opacity-60">({{ $product->reviews->count() }})</span>
                            <div x-show="tab === 'reviews'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-x-0"
                                 x-transition:enter-end="opacity-100 scale-x-100"
                                 class="absolute bottom-0 left-0 w-full h-[2px] bg-black"></div>
                        </button>
                    </div>
                    
                    {{-- Tab Content: Description --}}
                    <div x-show="tab === 'description'" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-20">
                            <div class="md:col-span-8">
                                <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-6">The Essence</h3>
                                <p class="text-[15px] text-gray-600 leading-[1.8] tracking-wide mb-8">
                                    {{ $product->description }}
                                </p>
                                <p class="text-[14px] text-gray-500 italic font-light leading-relaxed border-l-2 border-gray-100 pl-6">
                                    Experience the ultimate fragrance journey with Laman Store. Crafted with precision and passion, this scent is designed for those who seek perfection in every detail.
                                </p>
                            </div>
                            <div class="md:col-span-4 space-y-10">
                                <div>
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-6">Scent Profile</h3>
                                    <div class="space-y-6">
                                        @if($product->top_note)
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-300 mb-2">Top Notes</span>
                                            <span class="text-[13px] text-gray-800 tracking-wider font-medium">{{ $product->top_note }}</span>
                                        </div>
                                        @endif
                                        @if($product->heart_note)
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-300 mb-2">Heart Notes</span>
                                            <span class="text-[13px] text-gray-800 tracking-wider font-medium">{{ $product->heart_note }}</span>
                                        </div>
                                        @endif
                                        @if($product->base_note)
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-300 mb-2">Base Notes</span>
                                            <span class="text-[13px] text-gray-800 tracking-wider font-medium">{{ $product->base_note }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                @if($product->category)
                                <div>
                                    <h3 class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-400 mb-4">Classification</h3>
                                    <span class="inline-block px-4 py-2 border border-gray-100 rounded-full text-[11px] font-bold uppercase tracking-widest text-gray-600">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tab Content: Reviews --}}
                    <div x-show="tab === 'reviews'" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white">
                        
                        {{-- Review Form --}}
                        @auth
                            <div class="mb-16 p-8 lg:p-12 bg-gray-50/50 rounded-3xl border border-gray-100">
                                <h4 class="text-[12px] font-bold uppercase tracking-[0.2em] mb-8">Share Your Experience</h4>
                                <form action="{{ route('product.review', $product) }}" method="POST" class="space-y-8 max-w-2xl">
                                    @csrf
                                    <div>
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-4">Rating</label>
                                        <div class="flex gap-4" x-data="{ rating: {{ $userReview?->rating ?? 5 }}, hover: 0 }">
                                            <template x-for="i in 5">
                                                <button type="button" @click="rating = i" @mouseenter="hover = i" @mouseleave="hover = 0" class="focus:outline-none transition-transform hover:scale-110 active:scale-95">
                                                    <svg class="w-7 h-7 transition-colors" :class="(hover || rating) >= i ? 'text-black' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            </template>
                                            <input type="hidden" name="rating" :value="rating">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-4">Your Impression</label>
                                        <textarea name="body" rows="4" placeholder="Describe the scent, longevity, and your general impression..." 
                                                  class="w-full border-gray-100 bg-white text-[14px] focus:ring-0 focus:border-black p-6 rounded-2xl transition-all placeholder:text-gray-300">{{ $userReview?->body }}</textarea>
                                    </div>
                                    <button type="submit" class="bg-black text-white px-12 py-4 rounded-full text-[11px] font-black uppercase tracking-[0.3em] hover:bg-gray-800 transition-all shadow-xl shadow-black/10">
                                        {{ $userReview ? 'Update Review' : 'Post Review' }}
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="mb-16 p-12 text-center bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                                <p class="text-[12px] text-gray-400 font-medium tracking-wide uppercase">Please <a href="{{ route('login') }}" class="text-black font-black border-b border-black">login</a> to leave a review.</p>
                            </div>
                        @endauth

                        {{-- Review List --}}
                        <div class="space-y-12">
                            @forelse($product->reviews as $review)
                                <div class="flex flex-col sm:flex-row gap-8 lg:gap-12 py-10 border-b border-gray-50 last:border-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-14 h-14 rounded-full bg-gray-900 text-white flex items-center justify-center text-[12px] font-black tracking-widest">
                                            {{ strtoupper(substr($review->user->name, 0, 1) . substr(strrchr($review->user->name, " "), 1, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                                            <div class="flex items-center gap-4">
                                                <p class="text-[14px] font-black text-gray-900 tracking-tight uppercase">{{ $review->user->name }}</p>
                                                <div class="flex gap-0.5">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-black' : 'text-gray-100' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="text-[15px] text-gray-600 leading-[1.8] tracking-wide max-w-3xl">
                                            {{ $review->body }}
                                        </div>
                                        @auth
                                            @if(auth()->id() === $review->user_id)
                                                <form action="{{ route('product.review.destroy', [$product, $review]) }}" method="POST" onsubmit="return confirm('Remove your review?')" class="mt-6">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[9px] uppercase tracking-[0.2em] font-black text-gray-300 hover:text-red-500 transition-colors">
                                                        Delete Review
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @empty
                                <div class="py-24 text-center">
                                    <p class="text-gray-300 font-luxury text-3xl italic mb-4">Silent Elegance</p>
                                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-[0.3em]">No reviews yet. Be the first to share the story.</p>
                                </div>
                            @endforelse
                        </div>
            </div>
        </div> {{-- End of Main Product Wrapper (max-w-1600) --}}
        
        <!-- ── RELATED PRODUCTS ────────────────────────────────────────── -->
        <section class="mt-40 py-24 bg-white border-t border-gray-100 reveal">
            <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
                @if($relatedProducts->isNotEmpty())
                    <div class="text-center mb-16">
                        <div class="inline-flex gap-8 items-center mb-4">
                            <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                            <p class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                                YOU MAY <span class="text-gray-800 font-medium">ALSO LIKE</span>
                            </p>
                            <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                        </div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Curated for your fragrance journey</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16">
                        @foreach($relatedProducts as $rel)
                            <x-product-card :product="$rel" />
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div> {{-- End of bg-white min-h-screen --}}
</x-storefront-layout>
