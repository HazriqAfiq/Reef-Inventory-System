<x-app-layout title="Add Reseller">

    <!-- Back Navigation -->
    <a href="{{ route('admin.resellers.index') }}"
       class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black mb-8 transition-colors uppercase tracking-widest">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Resellers
    </a>

    <!-- Page Content Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/20">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Register New Reseller</h1>
            <p class="text-sm text-gray-500 mt-1">Configure credentials and standard commission rate for the new network partner.</p>
        </div>

        <form action="{{ route('admin.resellers.store') }}" method="POST" class="p-8 space-y-12">
            @csrf

            <!-- Identity Section -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Reseller Identity</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Full Name --}}
                    <div class="space-y-2">
                        <label for="name" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Full Name <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autofocus placeholder="e.g. Ahmad Rizal" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-2">
                        <label for="email" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="reseller@example.com" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all @error('email') border-red-400 @enderror">
                        @error('email')<p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>@enderror
                    </div>

                    {{-- Commission Rate --}}
                    <div class="space-y-2">
                        <label for="commission_rate" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Commission Rate (%) <span class="text-red-500">*</span></label>
                        <input id="commission_rate" name="commission_rate" type="number" step="0.01" value="{{ old('commission_rate', 15.00) }}" placeholder="e.g. 15.00" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all @error('commission_rate') border-red-400 @enderror">
                        @error('commission_rate')<p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Credentials Section -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Credentials</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Password --}}
                    <div class="space-y-2">
                        <label for="password" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Password <span class="text-red-500">*</span></label>
                        <input id="password" name="password" type="password" placeholder="Min. 8 characters" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all @error('password') border-red-400 @enderror">
                        @error('password')<p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase">{{ $message }}</p>@enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Confirm Password <span class="text-red-500">*</span></label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-type password" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50 mt-12">
                <a href="{{ route('admin.resellers.index') }}"
                   class="px-8 py-3 bg-white border border-gray-100 hover:bg-gray-50 text-gray-400 hover:text-black rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-300">
                    Cancel
                </a>
                <button type="submit"
                        class="px-10 py-3 bg-black hover:bg-gray-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                    Register Reseller
                </button>
            </div>
        </form>
    </div>

</x-app-layout>
