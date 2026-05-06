<x-app-layout title="Profile Settings">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Account Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your identity, security, and notification preferences.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-[10px] font-bold text-gray-900 uppercase tracking-widest shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-black"></span>
                {{ auth()->user()->role }} Account
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Profile Information -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/20">
                    <h2 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Profile Information</h2>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Security Access -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/20">
                    <h2 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Security & Password</h2>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Danger Zone -->
            @if(auth()->user()->role === 'reseller')
                <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-rose-50 bg-rose-50/20">
                        <h2 class="text-xs font-bold text-rose-900 uppercase tracking-widest">Dangerous Operations</h2>
                    </div>
                    <div class="p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Summary Column -->
        <div class="space-y-8">
            <!-- User Summary -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-10 flex flex-col items-center border-b border-gray-50">
                    <div class="w-20 h-20 rounded-2xl bg-black flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-black/10 mb-6">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">{{ auth()->user()->name }}</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">{{ auth()->user()->role }} Member</p>
                </div>
                <div class="p-8 space-y-5">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Member Since</span>
                        <span class="text-xs font-bold text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Verification Status</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold uppercase tracking-widest rounded-lg border border-emerald-100">
                            Verified
                        </span>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50">
                    <h2 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Preferences</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900">Low Stock Alerts</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-relaxed">Notify when levels are critical.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-100 rounded-full peer peer-checked:after:translate-x-5 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-black"></div>
                        </label>
                    </div>
                    <div class="h-px bg-gray-50"></div>
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold text-gray-900">New Sales</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 leading-relaxed">Alerts for every transaction.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-10 h-5 bg-gray-100 rounded-full peer peer-checked:after:translate-x-5 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-black"></div>
                        </label>
                    </div>
                    <p class="text-[9px] text-gray-400 italic">Preferences are saved to this browser.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
