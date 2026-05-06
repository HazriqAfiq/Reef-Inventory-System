<x-account-layout>

    <div class="mb-14 pb-10 border-b border-gray-100">
        <div class="inline-flex items-center gap-6">
            <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
            <h2 class="text-3xl md:text-4xl font-light tracking-[0.2em] text-gray-900 leading-none uppercase">Account Settings</h2>
            <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
        </div>
    </div>

    {{-- Success notice --}}
    @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div class="mb-12 flex items-center gap-5 px-8 py-5 bg-white rounded-[2rem] border border-emerald-100 shadow-sm shadow-emerald-50">
            <div class="w-8 h-8 rounded-2xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-emerald-700">Profile preferences updated successfully</p>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-10 mb-16">

        {{-- ── PERSONAL INFORMATION ──────────────────────────────────────── --}}
        <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">
            <div class="flex items-start gap-5 mb-12">
                <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em] mb-1.5">Personal</p>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Public Profile</h3>
                </div>
            </div>
            <form method="post" action="{{ route('profile.update') }}" class="space-y-10">
                @csrf
                @method('patch')
                <div class="space-y-1.5 group">
                    <label for="name" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] block ml-1 transition-colors group-focus-within:text-black">Full Name</label>
                    <input id="name" name="name" type="text"
                           value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                           class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-1 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors placeholder-gray-200">
                    <x-input-error class="mt-2 text-[11px] font-bold uppercase tracking-widest text-red-400" :messages="$errors->get('name')" />
                </div>
                <div class="space-y-1.5 group">
                    <label for="email" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] block ml-1 transition-colors group-focus-within:text-black">Email Address</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-1 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                    <x-input-error class="mt-2 text-[11px] font-bold uppercase tracking-widest text-red-400" :messages="$errors->get('email')" />
                </div>
                <div class="pt-4">
                    <button type="submit"
                            class="w-full md:w-auto px-12 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50">
                        Save Preferences
                    </button>
                </div>
            </form>
        </div>

        {{-- ── CHANGE PASSWORD ───────────────────────────────────────────── --}}
        <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500">
            <div class="flex items-start gap-5 mb-12">
                <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em] mb-1.5">Security</p>
                    <h3 class="text-xl font-bold text-gray-900 tracking-tight">Access Key</h3>
                </div>
            </div>
            <form method="post" action="{{ route('password.update') }}" class="space-y-10">
                @csrf
                @method('put')
                <div class="space-y-1.5 group">
                    <label for="update_password_current_password" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] block ml-1">Current Password</label>
                    <input id="update_password_current_password" name="current_password" type="password"
                           autocomplete="current-password"
                           class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-1 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[11px] font-bold uppercase tracking-widest text-red-400" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1.5 group">
                        <label for="update_password_password" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] block ml-1">New Password</label>
                        <input id="update_password_password" name="password" type="password"
                               autocomplete="new-password"
                               class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-1 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[11px] font-bold uppercase tracking-widest text-red-400" />
                    </div>
                    <div class="space-y-1.5 group">
                        <label for="update_password_password_confirmation" class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] block ml-1">Verify Password</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                               autocomplete="new-password"
                               class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-1 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[11px] font-bold uppercase tracking-widest text-red-400" />
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit"
                            class="w-full md:w-auto px-12 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- ── DANGER ZONE ───────────────────────────────────────────────────── --}}
    <div class="bg-red-50/30 rounded-[3rem] p-10 md:p-14 border border-red-100 shadow-sm shadow-red-50/50">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-12">
            <div class="flex items-start gap-6">
                <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-red-400 uppercase tracking-[0.5em] mb-2">Danger Zone</p>
                    <h4 class="text-2xl font-light text-gray-900 mb-3 uppercase tracking-[0.1em]">Deactivate Account</h4>
                    <p class="text-[14px] text-gray-500 font-medium max-w-md leading-relaxed">Permanently removes your presence and all data from our sanctuary. This action is irreversible.</p>
                </div>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}"
                  onsubmit="return confirm('This will permanently delete your account. Proceed?')">
                @csrf
                @method('delete')
                <div class="flex flex-col gap-6">
                    <input type="password" name="password" placeholder="Confirm with password"
                           class="bg-white border-0 border-b border-red-100 py-4 px-1 text-[14px] text-gray-900 focus:ring-0 focus:border-red-400 transition-colors placeholder-gray-300 font-bold min-w-[280px]">
                    <button type="submit"
                            class="px-10 py-4 bg-red-500 text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-red-600 transition-all shadow-xl shadow-red-200/50 whitespace-nowrap">
                        Delete Account Permanently
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-account-layout>

