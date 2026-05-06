<x-guest-layout>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Side: Form -->
        <div class="w-full md:w-[45%] bg-white flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative overflow-y-auto">
            <!-- Back Button -->
            <div class="absolute top-8 left-8 sm:top-12 sm:left-12">
                <a href="{{ (url()->previous() && !str_contains(url()->previous(), 'login') && !str_contains(url()->previous(), 'register') && !str_contains(url()->previous(), 'forgot-password')) ? url()->previous() : route('storefront.index') }}" 
                   class="group flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 hover:text-black transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Boutique</span>
                </a>
            </div>

            <div class="max-w-[420px] w-full animate-fade-in-up">
                <!-- Branding -->
                <div class="mb-16 text-center md:text-left">
                    <a href="/" class="inline-block group">
                        <h2 class="text-2xl font-luxury font-black tracking-[0.3em] uppercase text-black group-hover:opacity-60 transition-opacity">
                            {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}
                        </h2>
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-12">
                    <h1 class="font-serif text-[42px] leading-tight text-gray-900 mb-4 italic">Reset Access</h1>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.4em] leading-relaxed">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="w-full bg-white border-0 border-b border-gray-100 py-4 text-sm focus:ring-0 focus:border-black transition-colors placeholder-gray-300 px-0 font-medium"
                               placeholder="your@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-6 bg-black text-white text-[11px] font-black uppercase tracking-[0.4em] hover:bg-gray-900 transition-all active:scale-[0.98] shadow-2xl shadow-black/10">
                            Email Password Reset Link
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 hover:text-black transition-colors">
                        Back to Sign In
                    </a>
                </div>
            </div>

            <!-- Absolute Copy -->
            <div class="absolute bottom-8 left-12 hidden lg:block">
                <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">&copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('brand_name', 'Laman Store') }}. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side: Imagery -->
        <div class="hidden md:block w-full md:w-[55%] bg-black relative overflow-hidden">
            <!-- Cinematic Background -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=1000&auto=format&fit=crop" 
                     class="w-full h-full object-cover opacity-60 animate-zoom-slow" 
                     alt="Luxury Fragrance">
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-r from-white via-transparent to-transparent z-10 w-32"></div>
            <div class="absolute inset-0 bg-black/10 z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center animate-fade-in-up delay-300">
                    <p class="text-white text-[11px] font-bold uppercase tracking-[0.6em] mb-6 opacity-60">SECURITY & PRIVACY</p>
                    <h3 class="font-serif text-7xl text-white italic drop-shadow-2xl opacity-90">Restore</h3>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
