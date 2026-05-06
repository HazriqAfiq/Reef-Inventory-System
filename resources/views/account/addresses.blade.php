<x-account-layout>
    <div x-data="{ open: false }">

        {{-- ── PAGE HEADER ──────────────────────────────────────────────── --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-16">
            <div>
            <div class="inline-flex items-center gap-6">
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
                <h2 class="text-3xl md:text-4xl font-light tracking-[0.2em] text-gray-900 leading-none uppercase">Addresses</h2>
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
            </div>
            </div>
            <button @click="open = true"
                    class="inline-flex items-center gap-4 px-10 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50 group">
                <span class="text-lg leading-none">+</span>
                Add New Address
            </button>
        </div>

        {{-- ── ADD ADDRESS MODAL ──────────────────────────────────────────── --}}
        <div x-show="open" x-cloak
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md">
            <div @click.away="open = false"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100">
                <div class="flex justify-between items-center px-12 py-10 border-b border-gray-50">
                    <div>
                        <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.4em] mb-2">New Entry</p>
                        <h3 class="text-3xl font-light text-gray-900 uppercase tracking-[0.1em]">Add Address</h3>
                    </div>
                    <button @click="open = false" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:text-black transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form action="{{ route('account.addresses.store') }}" method="POST" class="px-12 py-10">
                    @csrf
                    <div class="grid grid-cols-2 gap-x-10 gap-y-8 mb-10">
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">Label (e.g. Home, Office)</label>
                            <input type="text" name="label" placeholder="Home" class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] text-gray-900 font-bold focus:ring-0 focus:border-black transition-colors placeholder-gray-200">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">Recipient Name</label>
                            <input type="text" name="recipient_name" required class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">Phone Number</label>
                            <input type="text" name="phone" required class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">Street Address</label>
                            <input type="text" name="address_line_1" required placeholder="Street name and building number" class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors placeholder-gray-200">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">City</label>
                            <input type="text" name="city" required class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">Postcode</label>
                            <input type="text" name="postal_code" required class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div class="col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.4em] block mb-3">State</label>
                            <input type="text" name="state" required class="w-full bg-gray-50/50 border-0 border-b border-gray-100 py-4 px-0 text-[15px] font-bold text-gray-900 focus:ring-0 focus:border-black transition-colors">
                        </div>
                        <div class="col-span-2 flex items-center gap-4 pt-2">
                            <input type="checkbox" name="is_default" id="is_default" value="1" class="w-5 h-5 rounded-lg border-gray-200 text-black focus:ring-0 cursor-pointer">
                            <label for="is_default" class="text-[11px] font-bold text-gray-500 uppercase tracking-[0.2em] cursor-pointer">Set as primary shipping address</label>
                        </div>
                    </div>
                    <div class="flex justify-end items-center gap-10">
                        <button type="button" @click="open = false" class="text-[11px] font-bold uppercase tracking-[0.3em] text-gray-400 hover:text-black transition-colors">Cancel</button>
                        <button type="submit" class="px-12 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50">Save Address</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── ADDRESS CARDS ─────────────────────────────────────────────── --}}
        @if($addresses->isEmpty())
            <div class="py-40 bg-white rounded-[3rem] text-center border border-gray-100/50 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                    </svg>
                </div>
                <p class="text-3xl font-light text-gray-900 mb-4 uppercase tracking-[0.1em]">No addresses saved</p>
                <p class="text-[13px] text-gray-400 font-medium mb-10 tracking-wide max-w-xs mx-auto">Add a location to simplify your future checkout experience.</p>
                <button @click="open = true" class="inline-flex items-center gap-4 px-8 py-4 bg-black text-white rounded-full text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gray-900 transition-all shadow-xl shadow-gray-200/50">
                    Add Your First Address
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-gray-100/50 group hover:shadow-[0_20px_40px_rgb(0,0,0,0.04)] transition-all duration-500 relative flex flex-col h-full">

                        {{-- Default badge --}}
                        @if($address->is_default)
                            <div class="absolute top-8 right-8">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold text-emerald-700 bg-emerald-50 uppercase tracking-[0.1em]">Primary</span>
                            </div>
                        @endif

                        {{-- Icon --}}
                        <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center mb-8 group-hover:bg-black transition-colors duration-500">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>

                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em] mb-3">{{ $address->label ?? 'Location' }}</p>
                            <h3 class="text-xl font-bold text-gray-900 mb-1 leading-tight tracking-tight">{{ $address->recipient_name }}</h3>
                            <p class="text-[12px] text-gray-400 font-medium mb-6 tracking-wide">{{ $address->phone }}</p>

                            <div class="space-y-1 py-6 border-t border-gray-50">
                                <p class="text-[14px] text-gray-600 font-medium leading-relaxed">{{ $address->address_line_1 }}</p>
                                <p class="text-[14px] text-gray-600 font-medium leading-relaxed">{{ $address->city }}, {{ $address->postal_code }}</p>
                                @if($address->state)
                                    <p class="text-[12px] text-gray-300 font-bold uppercase tracking-[0.1em] mt-2">{{ $address->state }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-gray-50">
                            <form action="{{ route('account.addresses.delete', $address) }}" method="POST"
                                  onsubmit="return confirm('Remove this address? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-300 hover:text-red-500 transition-colors">
                                    Remove Entry
                                </button>
                            </form>
                            @if(!$address->is_default)
                                <form action="{{ route('account.addresses.update', $address) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_default" value="1">
                                    <button type="submit" class="text-[10px] font-bold uppercase tracking-[0.2em] text-gray-900 hover:opacity-50 transition-opacity">
                                        Set as Primary
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-account-layout>
