<x-storefront-layout title="Your Signature Aura" :darkHero="true" :hasHero="true">
    <div x-data="{}">
    <style>
        html { scroll-behavior: smooth !important; }
    </style>
    <!-- ── RESULTS HERO ────────────────────────────────────────── -->
    <header class="relative h-[40vh] min-h-[350px] flex flex-col items-center justify-center overflow-hidden bg-black text-white">
        <!-- Cinematic Scrim System -->
        <div class="absolute inset-0 z-[1] bg-black/40"></div>
        <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/90 via-black/10 to-transparent z-[2]"></div> <!-- Top Scrim -->
        <div class="absolute inset-x-0 bottom-0 h-[80%] bg-gradient-to-t from-black/90 via-black/40 to-transparent z-[2]"></div>

        <!-- Background Image -->
        @php
            $heroImage = \App\Models\Setting::getValue('scent_finder_results_hero_image', 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?auto=format&fit=crop&q=80&w=2000');
        @endphp
        <div class="absolute inset-0 z-0">
            <img src="{{ str_contains($heroImage, 'http') ? $heroImage : asset('storage/' . $heroImage) }}" 
                 class="w-full h-full object-cover animate-zoom-slow" 
                 alt="Discovery Results">
        </div>

        <div class="relative z-[3] text-center px-4 animate-fade-in-up mt-16">
            <div class="inline-flex gap-8 items-center mb-6">
                <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                <p class="text-white/60 text-3xl md:text-5xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                    YOUR <span class="text-white font-semibold">SIGNATURE AURA</span>
                </p>
                <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
            </div>
            <p class="text-[11px] font-bold text-white uppercase tracking-[0.5em] drop-shadow-lg" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
                Discovery Complete
            </p>
        </div>

        <x-scroll-indicator target="selection" />
    </header>

    <!-- ── RESULTS CONTENT ─────────────────────────────────────── -->
    <div id="selection" class="bg-white min-h-screen scroll-mt-20">


        <div class="max-w-[1600px] mx-auto py-24 px-6 sm:px-8 lg:px-12">
            
            @if($recommendations->isEmpty())
                <div class="text-center py-32 bg-[#F9F9F9] rounded-[40px] border border-gray-100">
                    <div class="mb-10 flex justify-center">
                        <div class="w-20 h-20 rounded-full border border-gray-200 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-400 font-serif text-3xl italic mb-10">No exact matches found...</p>
                    <a href="{{ route('storefront.collection') }}" class="inline-flex items-center gap-4 text-[10px] font-bold uppercase tracking-[0.4em] text-black border-b border-black pb-2 hover:gap-6 transition-all duration-500">
                        Explore Full Collection
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" /></svg>
                    </a>
                </div>
            @else
                @php
                    $topMatch = $recommendations->first();
                    $otherMatches = $recommendations->skip(1);
                    
                    $accuracy = $topMatch->scent_accuracy ?? 85;
                @endphp
                              <!-- ── SIGNATURE MATCH PREMIUM CARD ─────────────────────────── -->
                <div class="mb-24 reveal">
                    <div class="relative group max-w-[1300px] mx-auto px-4 sm:px-0">
                        <!-- Refined Background Ambiance -->
                        <div class="absolute -top-16 -right-16 w-80 h-80 bg-gray-100/40 rounded-full blur-[80px] opacity-40"></div>
                        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-gray-50 rounded-full blur-[80px] opacity-40"></div>

                        <div class="relative flex flex-col lg:flex-row items-stretch bg-white rounded-[2.5rem] overflow-hidden border border-gray-100 shadow-[0_25px_70px_rgba(0,0,0,0.03)] transition-all duration-700 hover:shadow-[0_40px_90px_rgba(0,0,0,0.07)]">
                            
                            <!-- ── Left Side: Product Showcase (55%) ── -->
                            <div class="lg:w-[55%] relative min-h-[400px] lg:min-h-[500px] overflow-hidden flex items-center justify-center bg-gradient-to-br from-[#FAFAFA] via-white to-[#FAFAFA]">
                                <!-- Soft Inner Glow -->
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.9),transparent_70%)]"></div>
                                
                                <!-- Product Image with Floating Effect -->
                                <div class="relative z-10 w-full h-full flex items-center justify-center p-8 transition-all duration-[2000ms] group-hover:scale-105">
                                    <img src="{{ $topMatch->primaryImage ? asset('storage/' . $topMatch->primaryImage->image_path) : 'https://placehold.co/1200x1200?text=' . urlencode($topMatch->name) }}" 
                                         class="max-w-[80%] max-h-[80%] object-contain drop-shadow-[0_30px_50px_rgba(0,0,0,0.06)] transform -rotate-2 transition-transform duration-[3000ms] group-hover:rotate-0" 
                                         alt="{{ $topMatch->name }}">
                                    
                                    <!-- Dynamic Floating Particles -->
                                    <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-black/5 rounded-full animate-ping"></div>
                                    <div class="absolute bottom-1/3 right-1/4 w-1.5 h-1.5 bg-black/5 rounded-full animate-pulse delay-700"></div>
                                </div>

                                <!-- Signature Selection Overlay -->
                                <div class="absolute top-6 left-6 z-20">
                                    <div class="px-5 py-2.5 bg-white/90 backdrop-blur-md rounded-full border border-gray-100 shadow-sm flex items-center gap-3">
                                        <div class="w-1 h-1 bg-black rounded-full"></div>
                                        <span class="text-[9px] font-black uppercase tracking-[0.3em] text-black">Signature Selection</span>
                                    </div>
                                </div>
                            </div>

                            <!-- ── Right Side: Structured Info (45%) ── -->
                            <div class="lg:w-[45%] bg-white p-8 md:p-10 lg:p-12 flex flex-col justify-between border-l border-gray-50 relative">
                                <!-- Top Content Group -->
                                <div class="space-y-6 relative z-10">
                                    <!-- Refined Match Badge -->
                                    <div class="flex items-center justify-between">
                                        <div class="inline-flex items-center gap-3 px-4 py-2 bg-white border border-gray-100 rounded-full shadow-sm">
                                            <div class="flex items-center gap-2">
                                                <span class="relative flex h-2 w-2">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                                </span>
                                                <span class="text-[10px] font-black text-gray-900 tracking-tight">{{ $accuracy }}% Match</span>
                                            </div>
                                            <div class="w-[1px] h-3 bg-gray-200"></div>
                                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400">For You</span>
                                        </div>
                                        <span class="text-[9px] font-bold uppercase tracking-[0.4em] text-gray-300">{{ $topMatch->category?->name ?? 'Fragrance' }}</span>
                                    </div>

                                    <!-- Product Identity -->
                                    <div class="space-y-2">
                                        <h2 class="text-4xl md:text-5xl font-luxury leading-tight text-gray-900 tracking-tight">
                                            {{ $topMatch->name }}
                                        </h2>
                                        <p class="text-[14px] font-light text-gray-500 leading-relaxed italic serif">
                                            "{{ $topMatch->scent_profile ?? 'A harmonious blend of citrus top notes with a deep, lingering woody essence.' }}"
                                        </p>
                                    </div>

                                    <!-- Refined Scent Chips -->
                                    <div class="space-y-4 pt-2">
                                        <p class="text-[8px] font-black uppercase tracking-[0.3em] text-gray-300">Composition Notes</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(array_filter([$topMatch->top_note, $topMatch->heart_note, $topMatch->base_note]) as $note)
                                                <span class="px-4 py-2 bg-gray-50 border border-gray-100 rounded-full text-[9px] font-bold uppercase tracking-widest text-gray-600 transition-all hover:border-black hover:bg-white cursor-default">
                                                    {{ $note }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Minimal Attributes -->
                                    <div class="flex items-center gap-4 text-[9px] font-bold uppercase tracking-[0.3em] text-gray-400 pt-2">
                                        <span class="flex items-center gap-2"><div class="w-1 h-1 bg-gray-200 rounded-full"></div> {{ ucfirst($answers['vibe'] ?? 'Classic') }}</span>
                                        <span class="flex items-center gap-2"><div class="w-1 h-1 bg-gray-200 rounded-full"></div> {{ ucfirst($answers['intensity'] ?? 'Balanced') }}</span>
                                        <span class="flex items-center gap-2"><div class="w-1 h-1 bg-gray-200 rounded-full"></div> {{ ucfirst($answers['time'] ?? 'All Day') }}</span>
                                    </div>
                                </div>

                                <!-- Bottom Action Group -->
                                <div class="mt-10 pt-8 border-t border-gray-50 space-y-6 relative z-10">
                                    <div class="flex items-center justify-between">
                                        <div class="space-y-0.5">
                                            <p class="text-[8px] font-black uppercase tracking-[0.2em] text-gray-300">Investment</p>
                                            <p class="text-2xl font-light text-gray-900 tracking-tighter">RM {{ number_format($topMatch->retail_price, 2) }}</p>
                                        </div>
                                        
                                         <a href="{{ route('storefront.show', $topMatch->slug) }}" 
                                            class="bg-black text-white px-10 py-4 rounded-full text-[10px] font-bold tracking-[0.3em] uppercase hover:bg-gray-900 transition-all duration-500 shadow-xl hover:shadow-2xl hover:translate-y-[-2px] active:scale-95 whitespace-nowrap">
                                             {{ \App\Models\Setting::getValue('scent_finder_cta_text', 'Experience Now') }}
                                         </a>
                                    </div>

                                    <div class="text-left">
                                        <a href="{{ route('storefront.scent-finder') }}" class="inline-flex items-center gap-3 text-[8px] font-bold uppercase tracking-[0.3em] text-gray-400 hover:text-black transition-colors group/link">
                                            Not your vibe? Try another match 
                                            <svg class="w-3 h-3 transform group-hover/link:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($otherMatches->isNotEmpty())
                    <div class="pt-32 border-t border-gray-100">
                        <div class="text-center mb-24">
                            <div class="inline-flex gap-8 items-center mb-6">
                                <p class="w-8 md:w-16 h-[1px] bg-gray-200"></p>
                                <h3 class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                                    OTHER <span class="text-gray-900 font-medium">NOBLE MATCHES</span>
                                </h3>
                                <p class="w-8 md:w-16 h-[1px] bg-gray-200"></p>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Complementary paths to your essence</p>
                        </div>

                        <div class="flex flex-wrap justify-center gap-x-8 gap-y-16 reveal reveal-delay-200">
                            @foreach($otherMatches as $product)
                                <div class="w-[calc(50%-1rem)] md:w-[calc(25%-1.5rem)] max-w-[320px]">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ── RETAKE JOURNEY CALLOUT ─────────────────────── -->
                <div class="mt-32 mb-16 text-center">
                    <div class="max-w-4xl mx-auto p-12 md:p-20 rounded-[3.5rem] bg-[#FAFAFA] border border-gray-50 relative overflow-hidden group shadow-sm transition-all duration-700 hover:shadow-md">
                        <div class="relative z-10 space-y-8">
                            <div class="space-y-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-gray-300">Refined Discovery</p>
                                <h4 class="text-3xl md:text-4xl font-luxury text-gray-900 leading-tight">Not quite what you were <br class="hidden md:block"> looking for?</h4>
                            </div>
                            
                            <p class="text-gray-500 text-base font-light max-w-xl mx-auto leading-relaxed italic serif">
                                Every aura is unique and ever-changing. You can retake the discovery journey at any time to explore different facets of your olfactory personality.
                            </p>

                            <div class="pt-2">
                                <a href="{{ route('storefront.scent-finder') }}" class="group/btn inline-flex flex-col items-center gap-4">
                                    <div class="flex items-center gap-6">
                                        <span class="text-[11px] font-black uppercase tracking-[0.6em] text-black transition-all duration-500 group-hover/btn:tracking-[0.8em]">
                                            Retake Journey
                                        </span>
                                        <svg class="w-5 h-5 transform group-hover/btn:translate-x-3 transition-transform duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                        </svg>
                                    </div>
                                    <div class="w-24 h-[1px] bg-black/10 relative overflow-hidden">
                                        <div class="absolute inset-0 bg-black translate-x-[-100%] group-hover/btn:translate-x-[0%] transition-transform duration-700 ease-in-out"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    <style>
        .animate-subtle-zoom {
            /* Removed */
        }
    </style>
    </div>
</x-storefront-layout>


