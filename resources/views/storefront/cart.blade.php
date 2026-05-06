<x-storefront-layout>
    <x-slot name="title">Your Shopping Cart</x-slot>

    <div class="bg-white py-16 lg:py-24" x-data="{
        selectedIds: {{ json_encode(array_map('strval', $selectedItems)) }},
        allIds: {{ json_encode(array_map('strval', $variantIds)) }},
        cartItems: [
            @foreach($cartData as $item)
                { id: '{{ $item['variant']->id }}', subtotal: {{ $item['subtotal'] }}, original: {{ $item['original_subtotal'] }} },
            @endforeach
        ],
        get total() {
            return this.cartItems
                .filter(item => this.selectedIds.includes(item.id))
                .reduce((sum, item) => sum + item.subtotal, 0);
        },
        get originalTotal() {
            return this.cartItems
                .filter(item => this.selectedIds.includes(item.id))
                .reduce((sum, item) => sum + item.original, 0);
        },
        get totalDiscount() {
            return this.originalTotal - this.total;
        },
        get allSelected() {
            return this.selectedIds.length === this.allIds.length;
        },
        toggleAll() {
            if (this.allSelected) {
                this.selectedIds = [];
            } else {
                this.selectedIds = [...this.allIds];
            }
            this.syncSelection();
        },
        syncSelection() {
            fetch('{{ route('cart.selection.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ selected_ids: this.selectedIds })
            });
        },
        formatCurrency(val) {
            return 'RM ' + new Intl.NumberFormat('en-MY', { minimumFractionDigits: 2 }).format(val);
        }
    }">
        <div class="max-w-[1600px] mx-auto w-full px-4 sm:px-8 lg:px-12 xl:px-16">
            {{-- Header --}}
            <div class="text-center mb-16 reveal">
                <div class="inline-flex gap-8 items-center mb-4">
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                    <h1 class="text-gray-400 text-2xl md:text-3xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                        SHOPPING <span class="text-gray-800 font-medium">CART</span>
                    </h1>
                    <p class="w-8 md:w-16 h-[1px] bg-gray-300"></p>
                </div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.3em]">{{ count($cartData) }} Items in your sanctuary</p>
            </div>

            @if(empty($cartData))
                <div class="py-40 text-center bg-gray-50/50 border border-gray-100 rounded-[40px] reveal">
                    <div class="w-24 h-24 bg-white border border-gray-100 flex items-center justify-center mx-auto mb-10 rounded-3xl shadow-xl shadow-black/5">
                        <svg class="w-10 h-10 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <h2 class="text-3xl font-light uppercase tracking-[0.3em] text-gray-900 mb-6 italic">Your cart is empty</h2>
                    <p class="text-[12px] text-gray-400 font-medium uppercase tracking-[0.2em] mb-12 max-w-sm mx-auto leading-relaxed">Discover your next signature scent and begin your olfactory journey.</p>
                    <a href="{{ route('storefront.collection') }}" class="inline-block px-16 py-6 bg-black text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.4em] hover:bg-gray-800 transition-all duration-500 shadow-2xl shadow-black/20">Begin Discovery</a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-20 items-start">
                    
                    <!-- ── ITEMS LIST ─────────────────────────────────────────── -->
                    <div class="flex-1 w-full reveal">
                        {{-- Select All Header --}}
                        <div class="flex items-center justify-between mb-4 px-6">
                            <label class="flex items-center gap-4 cursor-pointer group">
                                <div class="relative flex items-center justify-center w-5 h-5 border-2 rounded-lg transition-all duration-300" 
                                     :class="allSelected ? 'bg-black border-black' : 'border-gray-200 group-hover:border-gray-400'">
                                    <input type="checkbox" class="hidden" @change="toggleAll()">
                                    <svg x-show="allSelected" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-900 group-hover:text-black transition-colors" x-text="allSelected ? 'Deselect All' : 'Select All Items'"></span>
                            </label>

                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest" x-text="selectedIds.length + ' item(s) selected'"></p>
                        </div>

                        <div class="space-y-2">
                            @foreach($cartData as $item)
                                <div class="py-3 border-b border-gray-100 flex flex-col sm:flex-row gap-6 items-start sm:items-center relative group transition-all duration-700 px-6 -mx-6 rounded-[24px]"
                                     :class="selectedIds.includes('{{ $item['variant']->id }}') ? 'bg-gray-50/50 opacity-100' : 'opacity-60 grayscale-[0.5]'">
                                    
                                    {{-- Checkbox --}}
                                    <label class="absolute left-[-15px] sm:relative sm:left-0 flex items-center justify-center w-5 h-5 border-2 rounded-lg cursor-pointer transition-all duration-300 flex-shrink-0"
                                         :class="selectedIds.includes('{{ $item['variant']->id }}') ? 'bg-black border-black' : 'border-gray-200 hover:border-gray-400'">
                                        <input type="checkbox" value="{{ $item['variant']->id }}" x-model="selectedIds" @change="syncSelection()" class="hidden">
                                        <svg x-show="selectedIds.includes('{{ $item['variant']->id }}')" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </label>

                                    {{-- Image Container --}}
                                    <div class="w-full sm:w-24 aspect-[4/5] bg-[#FAFAFA] border border-gray-100 overflow-hidden flex-shrink-0 rounded-xl group-hover:shadow-2xl group-hover:shadow-black/5 transition-all duration-700">
                                        <img src="{{ $item['product']->primaryImage ? asset('storage/' . $item['product']->primaryImage->image_path) : 'https://placehold.co/400x500?text=' . urlencode($item['product']->name) }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $item['product']->name }}">
                                    </div>

                                    {{-- Info Container --}}
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex flex-col gap-1.5">
                                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">{{ $item['product']->category?->name }}</span>
                                                @if($item['product']->effective_promotion_badge)
                                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] px-2 py-0.5 bg-amber-400 text-black rounded shadow-sm inline-block w-fit">{{ $item['product']->effective_promotion_badge }}</span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                @if($item['discount'] > 0)
                                                    <p class="text-[11px] font-medium tracking-widest text-gray-300 line-through mb-1">RM {{ number_format($item['original_subtotal'], 2) }}</p>
                                                    <p class="text-[18px] font-bold tracking-tighter text-red-700">RM {{ number_format($item['subtotal'], 2) }}</p>
                                                @else
                                                    <p class="text-[18px] font-medium tracking-tighter text-gray-900">RM {{ number_format($item['subtotal'], 2) }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <h3 class="text-lg font-light text-gray-900 mb-0.5 uppercase tracking-[0.1em] italic font-serif">{{ $item['product']->name }}</h3>
                                        
                                        <div class="flex items-center gap-4 mb-2">
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Volume: {{ $item['variant']->name }}</span>
                                            @if($item['free_items'] > 0)
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                                <span class="text-[11px] font-bold text-amber-600 uppercase tracking-widest">+{{ $item['free_items'] }} Complimentary Gift(s)</span>
                                            @endif
                                        </div>

                                        <div class="flex flex-wrap items-center gap-6 mt-auto">
                                            <!-- Quantity Update -->
                                            <form action="{{ route('cart.update') }}" method="POST" x-data="{ qty: {{ $item['quantity'] }} }" class="flex items-center gap-4 bg-white border border-gray-100 rounded-lg px-3 py-1.5 shadow-sm">
                                                @csrf
                                                <input type="hidden" name="variant_id" value="{{ $item['variant']->id }}">
                                                <button type="submit" name="quantity" :value="qty - 1" class="text-gray-300 hover:text-black transition-colors p-0.5">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                                </button>
                                                <span class="text-[12px] font-bold w-5 text-center text-gray-900" x-text="qty"></span>
                                                <button type="submit" name="quantity" :value="qty + 1" class="text-gray-300 hover:text-black transition-colors p-0.5">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                </button>
                                            </form>

                                            <div class="flex items-center gap-6">
                                                <!-- Save for Later -->
                                                <form action="{{ route('cart.wishlist', $item['variant']->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black transition-colors border-b border-transparent hover:border-black pb-0.5">Save for later</button>
                                                </form>

                                                <!-- Remove -->
                                                <form action="{{ route('cart.remove', $item['variant']->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-300 hover:text-red-500 transition-colors">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- ── SUMMARY ────────────────────────────────────────────── -->
                    <div class="w-full lg:w-[420px] sticky top-24 self-start reveal reveal-delay-200">
                        <div class="bg-white border border-gray-100 p-8 sm:p-10 rounded-[40px] shadow-2xl shadow-black/[0.03]">
                            <div class="flex items-center gap-4 mb-8">
                                <h2 class="text-[12px] font-black uppercase tracking-[0.4em] text-gray-900">Order Summary</h2>
                                <div class="flex-1 h-[1px] bg-gray-100"></div>
                            </div>
                            
                            <div class="space-y-6 mb-8 pb-8 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">Subtotal</span>
                                    <span class="text-[15px] font-medium tracking-widest text-gray-900" x-text="formatCurrency(originalTotal)"></span>
                                </div>
                                <div class="flex justify-between items-center bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100/50" x-show="totalDiscount > 0">
                                    <span class="text-[11px] font-black text-emerald-600 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                        Privilege Savings
                                    </span>
                                    <span class="text-[15px] font-bold tracking-widest text-emerald-600" x-text="'-' + formatCurrency(totalDiscount)"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">Shipping</span>
                                    <span class="text-[11px] font-black tracking-[0.2em] text-emerald-600 uppercase bg-emerald-50 px-3 py-1 rounded-full">Complimentary</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[12px] font-bold text-gray-400 uppercase tracking-widest">Tax (SST)</span>
                                    <span class="text-[11px] font-medium tracking-widest text-gray-300 uppercase">Calculated at checkout</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end mb-10">
                                <div>
                                    <span class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-300 block mb-0.5">Estimated Total</span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Inc. all taxes</span>
                                </div>
                                <span class="text-3xl font-light tracking-tighter text-gray-900 uppercase italic font-serif" x-text="formatCurrency(total)"></span>
                            </div>

                            <a href="{{ route('checkout.index') }}" 
                               class="group relative block w-full py-5 bg-black text-white text-center rounded-[20px] text-[12px] font-black uppercase tracking-[0.5em] hover:bg-gray-800 transition-all duration-500 shadow-2xl shadow-black/20 overflow-hidden"
                               :class="selectedIds.length === 0 ? 'opacity-50 cursor-not-allowed grayscale' : ''"
                               :onclick="selectedIds.length === 0 ? 'event.preventDefault()' : ''">
                                <span class="relative z-10 group-hover:tracking-[0.6em] transition-all duration-500">Checkout Securely</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            </a>

                            <p x-show="selectedIds.length === 0" class="text-center text-[10px] text-red-400 font-bold uppercase tracking-widest mt-4">Please select at least one item to proceed</p>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-storefront-layout>
