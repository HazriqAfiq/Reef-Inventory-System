<x-guest-layout>
    <div class="h-screen flex overflow-hidden bg-white">
        <!-- Left Side: Form -->
        <div class="w-full lg:w-[45%] flex flex-col items-center justify-center p-8 sm:p-12 lg:p-20 relative bg-white">
            <!-- Back Link -->
            <div class="absolute top-12 left-12 hidden md:block">
                @php
                    $prev = url()->previous();
                    $isAuth = str_contains($prev, 'login') || str_contains($prev, 'register') || str_contains($prev, 'forgot-password') || str_contains($prev, 'reset-password');
                    $backUrl = ($prev && !$isAuth) ? $prev : route('storefront.index');
                @endphp
                <a href="{{ $backUrl }}" 
                   class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 hover:text-black transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Shop</span>
                </a>
            </div>

            <div class="w-full max-w-[440px] animate-fade-in-up">
                <!-- Branding -->
                <div class="mb-12 text-center lg:text-left">
                    <a href="/" class="inline-block group mb-10">
                        <h2 class="text-xl font-luxury font-black tracking-[0.3em] uppercase text-black">
                            {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                        </h2>
                    </a>
                    
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-2">
                        <p class="w-6 h-[1px] bg-gray-100"></p>
                        <h1 class="text-gray-400 text-xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                            SIGN <span class="text-gray-800 font-medium">IN</span>
                        </h1>
                        <p class="w-6 h-[1px] bg-gray-100"></p>
                    </div>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-4 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                               placeholder="your@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px]" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-300 hover:text-black transition-colors">Forgot?</a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required 
                               class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-4 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px]" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-5 bg-black text-white rounded-2xl text-[12px] font-black uppercase tracking-[0.4em] hover:bg-gray-900 transition-all active:scale-[0.98] shadow-2xl shadow-black/10">
                            Enter Store
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-12 text-center lg:text-left pt-8 border-t border-gray-50">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">New here?</p>
                    <a href="{{ route('register') }}" class="text-[11px] font-black uppercase tracking-[0.3em] text-black border-b-2 border-black pb-1 hover:opacity-50 transition-opacity inline-block">Create Account</a>
                </div>
            </div>
        </div>

        <!-- Right Side: Imagery -->
        <div class="hidden lg:block w-[55%] bg-black relative overflow-hidden">
            <img src="{{ asset('storage/' . (\App\Models\Setting::getValue('sign_in_image', 'hero/hero_cinematic.png'))) }}" 
                 class="w-full h-full object-cover opacity-60 animate-zoom-slow" 
                 alt="Luxury Fragrance">
            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center animate-fade-in-up delay-300">
                    <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.6em] mb-6">Established MMXXIV</p>
                    <h3 class="font-serif text-6xl text-white italic drop-shadow-2xl opacity-90">
                        {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
