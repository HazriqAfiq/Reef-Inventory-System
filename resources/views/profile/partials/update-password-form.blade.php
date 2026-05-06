<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Current Password -->
            <div class="md:col-span-2">
                <label for="update_password_current_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Confirm Identity (Current Password)</label>
                <div class="relative group">
                    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full px-4 py-3.5 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-black/5 focus:border-black transition-all">
                    <button type="button" onclick="togglePassword('update_password_current_password', this)"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-black">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <label for="update_password_password" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">New Password</label>
                <div class="relative group">
                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                           placeholder="Min. 8 characters" oninput="checkStrength(this.value)"
                           class="w-full px-4 py-3.5 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-black/5 focus:border-black transition-all">
                    <button type="button" onclick="togglePassword('update_password_password', this)"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-black">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <!-- Strength Indicator -->
                <div class="mt-4 flex gap-1.5" id="strength-bars">
                    <div class="h-1 flex-1 rounded-full bg-gray-100 transition-all duration-500"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-100 transition-all duration-500"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-100 transition-all duration-500"></div>
                    <div class="h-1 flex-1 rounded-full bg-gray-100 transition-all duration-500"></div>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="update_password_password_confirmation" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Confirm New Password</label>
                <div class="relative group">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           placeholder="Re-type password"
                           class="w-full px-4 py-3.5 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-black/5 focus:border-black transition-all">
                    <button type="button" onclick="togglePassword('update_password_password_confirmation', this)"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-black">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-10 py-3.5 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                Update Password
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                   class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Security Updated</p>
            @endif
        </div>
    </form>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        function checkStrength(val) {
            const bars = document.getElementById('strength-bars').children;
            let score = 0;
            if (val.length > 5) score++;
            if (val.length > 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;

            const colors = ['bg-rose-400', 'bg-amber-400', 'bg-amber-500', 'bg-emerald-500'];
            
            for (let i = 0; i < bars.length; i++) {
                bars[i].className = `h-1 flex-1 rounded-full transition-all duration-500 ${i < score ? colors[score - 1] : 'bg-gray-100'}`;
            }
        }
    </script>
</section>
