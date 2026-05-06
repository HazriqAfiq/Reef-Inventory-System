<x-storefront-layout title="Scent Finder" :darkHero="true" :hasHero="true">
    <div class="relative min-h-screen bg-[#050505] text-white selection:bg-white selection:text-black overflow-hidden font-sans" 
         x-data="{ 
            step: 0,
            answers: {
                vibe: '',
                intensity: '',
                time: ''
            },
            goBack() {
                if (this.step > 0) this.step--;
            },
            finishJourney() {
                this.$refs.form.submit();
            }
         }">

        <!-- ── PROGRESS INDICATOR ────────────────────────────────────── -->
        <div class="fixed top-0 left-0 w-full h-[2px] z-[60] flex">
            <div class="h-full bg-white transition-all duration-200 ease-in-out" 
                 :style="'width: ' + (step / 4 * 100) + '%'"></div>
        </div>

        <!-- ── NAVIGATION CONTROLS ───────────────────────────────────── -->
        <div x-show="step > 0" 
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 -translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             class="fixed top-36 left-12 z-[60]">
            <button @click="goBack()" class="group flex items-center gap-6">
                <div class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center backdrop-blur-2xl group-hover:bg-white group-hover:border-white transition-all duration-500 shadow-2xl">
                    <svg class="w-5 h-5 text-white group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.6em] text-white/50 group-hover:text-white transition-all duration-500">Previous</span>
            </button>
        </div>

        <form x-ref="form" action="{{ route('storefront.scent-finder.results') }}" method="GET">
            <template x-for="(value, key) in answers">
                <input type="hidden" :name="'answers['+key+']'" :value="value">
            </template>
        </form>

        <!-- ── STAGE 0: THE INVITATION ─────────────────────────────── -->
        <div x-show="step === 0" 
             x-transition:enter="transition duration-500 ease-out" 
             x-transition:enter-start="opacity-0 scale-105" 
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition duration-300 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative h-screen flex flex-col items-center justify-center text-center px-6">
            
            @php
                $heroImage = \App\Models\Setting::getValue('scent_finder_hero_image', 'hero/scent-finder-hero.png');
            @endphp
            <div class="absolute inset-0 z-0">
                <img src="{{ str_contains($heroImage, 'http') ? $heroImage : asset('storage/' . $heroImage) }}" 
                     class="w-full h-full object-cover animate-zoom-slow opacity-60" alt="Discovery Journey">
                <div class="absolute inset-0 bg-black/40"></div>
                <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-black/95 via-black/30 to-transparent"></div> <!-- Top Scrim -->
                <div class="absolute inset-x-0 bottom-0 h-full bg-gradient-to-t from-[#050505] via-transparent to-black/20"></div>
            </div>

            <div class="relative z-10 w-full max-w-5xl mx-auto flex flex-col items-center justify-center animate-fade-in-up">
                <div class="inline-flex items-center justify-center gap-8 mb-8">
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                    <p class="text-white/60 text-3xl md:text-5xl font-light uppercase tracking-[0.3em] leading-none whitespace-nowrap">
                        FIND YOUR <span class="text-white font-semibold">SIGNATURE AURA</span>
                    </p>
                    <p class="w-8 md:w-16 h-[1px] bg-white opacity-40"></p>
                </div>

                <p class="text-[11px] font-bold text-white uppercase tracking-[0.5em] mb-16 opacity-80 animate-fade-in-up delay-300">
                    The Discovery Journey
                </p>
                
                <p class="text-sm md:text-base font-light text-white/50 max-w-xl mx-auto mb-16 leading-relaxed uppercase tracking-widest animate-fade-in-up delay-300">
                    Step into our digital sanctuary and allow us to distill your essence into a singular, unforgettable fragrance.
                </p>

                <div class="flex flex-col items-center gap-16 animate-fade-in-up delay-300">
                    <button @click="step = 1" 
                            class="inline-block border border-white px-16 py-5 rounded-2xl text-[11px] font-black tracking-[0.4em] uppercase hover:bg-white hover:text-black transition-all duration-300 shadow-2xl shadow-white/5">
                        Begin Exploration
                    </button>
                </div>
            </div>

            <x-scroll-indicator @click="step = 1" />
        </div>

        <!-- ── STAGE 1: THE VIBE ───────────────────────────────────── -->
        <div x-show="step === 1" 
             x-transition:enter="transition duration-200 ease-out" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-200 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="h-screen flex flex-col md:flex-row">
            
            @foreach([
                ['id' => 'fresh', 'title' => 'Ethereal & Fresh', 'desc' => 'Citrus · Sea Mist · Morning Dew', 'img' => 'scent-finder/vibe-fresh.png'],
                ['id' => 'woody', 'title' => 'Ancient & Woody', 'desc' => 'Sandalwood · Amber · Midnight Forest', 'img' => 'scent-finder/vibe-woody.png'],
                ['id' => 'floral', 'title' => 'Velvet & Floral', 'desc' => 'Damask Rose · Jasmine · Moonflower', 'img' => 'scent-finder/vibe-floral.png']
            ] as $vibe)
            <button @click="answers.vibe = '{{ $vibe['id'] }}'; step = 2" 
                    class="group relative flex-1 overflow-hidden flex flex-col items-center justify-center p-12 transition-all duration-500 ease-in-out hover:flex-[1.8]">
                <img src="{{ asset('storage/' . $vibe['img']) }}" 
                     class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-60 transition-all duration-700" alt="{{ $vibe['title'] }}">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-transparent transition-colors duration-500"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                
                <div class="relative z-10 text-center drop-shadow-2xl">
                    <p class="text-[10px] font-bold uppercase tracking-[0.6em] mb-6 text-white/80 group-hover:text-white transition-all">Dimension 01</p>
                    <h3 class="text-3xl md:text-5xl font-serif italic mb-6 leading-tight text-white drop-shadow-lg">{{ $vibe['title'] }}</h3>
                    <div class="h-[1px] w-0 group-hover:w-16 bg-white mx-auto mb-6 transition-all duration-500"></div>
                    <p class="text-[11px] font-light uppercase tracking-[0.3em] opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 text-white">{{ $vibe['desc'] }}</p>
                </div>
            </button>
            @endforeach
        </div>

        <!-- ── STAGE 2: INTENSITY ──────────────────────────────────── -->
        <div x-show="step === 2" 
             x-transition:enter="transition duration-200 ease-out" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-200 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="h-screen flex flex-col md:flex-row">
            
            @foreach([
                ['id' => 'subtle', 'title' => 'Intimate Whispers', 'desc' => 'Skin Scent · Gentle · Close', 'img' => 'scent-finder/intensity-subtle.png'],
                ['id' => 'bold', 'title' => 'Majestic Presence', 'desc' => 'Intense · Radiant · Command', 'img' => 'scent-finder/intensity-bold.png']
            ] as $int)
            <button @click="answers.intensity = '{{ $int['id'] }}'; step = 3" 
                    class="group relative flex-1 overflow-hidden flex flex-col items-center justify-center p-12 transition-all duration-500 ease-in-out hover:flex-[1.4]">
                <img src="{{ asset('storage/' . $int['img']) }}" 
                     class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-60 transition-all duration-700" alt="{{ $int['title'] }}">
                <div class="absolute inset-0 bg-black/50 group-hover:bg-transparent transition-colors duration-500"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                
                <div class="relative z-10 text-center drop-shadow-2xl">
                    <p class="text-[10px] font-bold uppercase tracking-[0.6em] mb-6 text-white/80 group-hover:text-white transition-all">Dimension 02</p>
                    <h3 class="text-3xl md:text-5xl font-serif italic mb-6 leading-tight text-white drop-shadow-lg">{{ $int['title'] }}</h3>
                    <div class="h-[1px] w-0 group-hover:w-16 bg-white mx-auto mb-6 transition-all duration-500"></div>
                    <p class="text-[11px] font-light uppercase tracking-[0.3em] opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 text-white">{{ $int['desc'] }}</p>
                </div>
            </button>
            @endforeach
        </div>

        <!-- ── STAGE 3: THE MOMENT ──────────────────────────────────── -->
        <div x-show="step === 3 || step === 4" 
             x-transition:enter="transition duration-200 ease-out" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition duration-200 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="h-screen flex flex-col md:flex-row">
            
            @foreach([
                ['id' => 'day', 'title' => 'Daylight Clarity', 'desc' => 'Crisp · Awakening · Professional', 'img' => 'scent-finder/moment-day.png'],
                ['id' => 'night', 'title' => 'Nocturnal Allure', 'desc' => 'Sensual · Deep · Mysterious', 'img' => 'scent-finder/moment-night.png']
            ] as $time)
            <button @click="answers.time = '{{ $time['id'] }}'; finishJourney()" 
                    class="group relative flex-1 overflow-hidden flex flex-col items-center justify-center p-12 transition-all duration-500 ease-in-out hover:flex-[1.4]">
                <img src="{{ asset('storage/' . $time['img']) }}" 
                     class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-60 transition-all duration-700" alt="{{ $time['title'] }}">
                <div class="absolute inset-0 bg-black/50 group-hover:bg-transparent transition-colors duration-500"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-80"></div>
                
                <div class="relative z-10 text-center drop-shadow-2xl">
                    <p class="text-[10px] font-bold uppercase tracking-[0.6em] mb-6 text-white/80 group-hover:text-white transition-all">Final Dimension</p>
                    <h3 class="text-3xl md:text-5xl font-serif italic mb-6 leading-tight text-white drop-shadow-lg">{{ $time['title'] }}</h3>
                    <div class="h-[1px] w-0 group-hover:w-16 bg-white mx-auto mb-6 transition-all duration-500"></div>
                    <p class="text-[11px] font-light uppercase tracking-[0.3em] opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 text-white">{{ $time['desc'] }}</p>
                </div>
            </button>
            @endforeach
        </div>


    </div>

</x-storefront-layout>
