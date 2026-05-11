<x-app-layout title="Profile Settings">
    <!-- Page Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Aesthetic Settings Live</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Account Settings</h1>
            <p class="text-xs text-gray-400 mt-1">Manage your identity, security, and notification preferences.</p>
        </div>
        
        <div class="flex items-center gap-3 shrink-0">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-100 rounded-xl text-[10px] font-black text-gray-900 uppercase tracking-widest shadow-sm">
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
                <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
                    <h2 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Profile Details</h2>
                    <p class="text-[9px] text-gray-400 uppercase tracking-wider mt-0.5">Configure your primary account name and email address</p>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Delivery Addresses (Reseller only) --}}
            @if(auth()->user()->isReseller())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20 flex items-center justify-between">
                    <div>
                        <h2 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Delivery Addresses</h2>
                        <p class="text-[9px] text-gray-400 uppercase tracking-wider mt-0.5">Saved shipping destinations for wholesale orders</p>
                    </div>
                    @if(session('status') === 'address-saved')
                        <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-3 py-1 rounded-lg border border-emerald-100">Saved</span>
                    @endif
                </div>

                <div class="p-8 space-y-6">
                    {{-- Saved Address Cards --}}
                    @forelse($addresses as $addr)
                        <div class="flex items-start justify-between gap-4 p-4 rounded-xl border {{ $addr->is_default ? 'border-black bg-gray-50/60' : 'border-gray-100 bg-white' }}">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-xs font-black text-gray-900">{{ $addr->label }}</span>
                                    @if($addr->is_default)
                                        <span class="text-[8px] font-black uppercase tracking-widest px-2 py-0.5 bg-black text-white rounded">Default</span>
                                    @endif
                                </div>
                                <p class="text-xs font-medium text-gray-700">{{ $addr->recipient_name }} · {{ $addr->phone }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5 leading-relaxed">
                                    {{ $addr->address_line_1 }}{{ $addr->address_line_2 ? ', ' . $addr->address_line_2 : '' }},
                                    {{ $addr->city }}, {{ $addr->state }} {{ $addr->postal_code }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if(!$addr->is_default)
                                    <form method="POST" action="{{ route('reseller.addresses.default', $addr) }}">
                                        @csrf
                                        <button type="submit" class="text-[9px] font-black uppercase tracking-wider text-gray-400 hover:text-black border border-gray-100 px-2.5 py-1.5 rounded-lg hover:bg-gray-50 transition-all">
                                            Set Default
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('reseller.addresses.destroy', $addr) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-[9px] font-black uppercase tracking-wider text-rose-400 hover:text-rose-600 border border-rose-100 px-2.5 py-1.5 rounded-lg hover:bg-rose-50 transition-all"
                                            onclick="return confirm('Remove this address?')">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                            No delivery addresses saved yet.
                        </div>
                    @endforelse

                    {{-- Add New Address Form --}}
                    <div class="border-t border-gray-50 pt-6" x-data="{ open: false }">
                        <button type="button" @click="open = !open"
                                class="flex items-center gap-2 text-[10px] font-black text-gray-900 uppercase tracking-widest hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-45' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add New Address
                        </button>

                        <form method="POST" action="{{ route('reseller.addresses.store') }}" x-show="open" x-cloak
                              class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            @csrf

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Label (e.g. Home, Office)</label>
                                <input name="label" type="text" placeholder="Home" value="{{ old('label') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Recipient Name <span class="text-rose-500">*</span></label>
                                <input name="recipient_name" type="text" required value="{{ old('recipient_name') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @error('recipient_name') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Phone <span class="text-rose-500">*</span></label>
                                <input name="phone" type="text" required value="{{ old('phone') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @error('phone') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Address Line 1 <span class="text-rose-500">*</span></label>
                                <input name="address_line_1" type="text" required value="{{ old('address_line_1') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @error('address_line_1') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Address Line 2</label>
                                <input name="address_line_2" type="text" value="{{ old('address_line_2') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">City <span class="text-rose-500">*</span></label>
                                <input name="city" type="text" required value="{{ old('city') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @error('city') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">State <span class="text-rose-500">*</span></label>
                                <select name="state" required class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all cursor-pointer">
                                    <option value="">Select State...</option>
                                    @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','W.P. Kuala Lumpur','W.P. Labuan','W.P. Putrajaya'] as $state)
                                        <option value="{{ $state }}" {{ old('state') === $state ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('state') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Postcode <span class="text-rose-500">*</span></label>
                                <input name="postal_code" type="text" required maxlength="10" value="{{ old('postal_code') }}"
                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @error('postal_code') <p class="text-[9px] text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-8 py-3 bg-black text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Save Address
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Security Access -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
                    <h2 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">Security & Credentials</h2>
                    <p class="text-[9px] text-gray-400 uppercase tracking-wider mt-0.5">Update password and configure authentication strength</p>
                </div>
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Danger Zone -->
            @if(auth()->user()->role === 'reseller')
                <div class="bg-white rounded-2xl border border-rose-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-4 border-b border-rose-100 bg-rose-50/20">
                        <h2 class="text-[10px] font-black text-rose-900 uppercase tracking-widest">Dangerous Operations</h2>
                        <p class="text-[9px] text-rose-500 uppercase tracking-wider mt-0.5">Irreversible partner account deletion procedures</p>
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
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-900 to-black flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-black/10 mb-6">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <h3 class="text-lg font-black text-gray-900 tracking-tight">{{ auth()->user()->name }}</h3>
                    <p class="text-[9px] font-black text-indigo-600 uppercase tracking-widest bg-indigo-50 border border-indigo-100/50 px-2.5 py-1 rounded-full mt-2.5 leading-none">{{ auth()->user()->role }} member</p>
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
                <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
                    <h2 class="text-[10px] font-black text-gray-900 uppercase tracking-widest">System Preferences</h2>
                    <p class="text-[9px] text-gray-400 uppercase tracking-wider mt-0.5">Control live notifications and browser-cached toggles</p>
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
