<x-app-layout title="Promotion Management">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Promotion Management</h1>
            <p class="text-sm text-gray-500 mt-1">Create and manage store-wide sales or individual product discounts.</p>
        </div>
        @php
            $isGlobalSaleActive = \App\Models\Setting::where('key', 'is_global_sale_active')->first()?->value === '1';
        @endphp
        @if($isGlobalSaleActive)
            <form action="{{ route('admin.settings.endGlobalSale') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-50 text-rose-600 px-6 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-rose-100 hover:bg-rose-100 transition-all" onclick="return confirm('End all active promotions?')">
                    End All Promotions
                </button>
            </form>
        @endif
    </div>



    <div class="space-y-16 pb-32">
        
        <!-- New Promotion Section -->
        <div class="space-y-8" x-data="{ 
                promoType: 'discount_percent', 
                targetScope: 'all',
                discountPercent: '', 
                showModal: false,
                search: '',
                searchResults: [],
                selectedProducts: [],
                
                async searchProducts() {
                    if (this.search.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    const response = await fetch(`{{ route('admin.api.products.search') }}?q=${this.search}`);
                    this.searchResults = await response.json();
                },
                
                addProduct(product) {
                    const exists = this.selectedProducts.find(p => p.id === product.id);
                    if (!exists) {
                        this.selectedProducts.push(product);
                    } else {
                        this.removeProduct(product.id);
                    }
                },
                
                removeProduct(id) {
                    this.selectedProducts = this.selectedProducts.filter(p => p.id !== id);
                },
                
                getImpactText() {
                    let base = '';
                    if (this.promoType === 'bogo') base = 'Buy 1 Free 1 (BOGO)';
                    else if (this.discountPercent) base = this.discountPercent + '% Discount';
                    else return 'Configure rules to see impact.';

                    if (this.targetScope === 'all') return `${base} for ALL products.`;
                    if (this.targetScope === 'category') return `${base} for the selected category.`;
                    if (this.targetScope === 'individual') return `${base} for ${this.selectedProducts.length} product(s).`;
                    return base;
                }
            }">
            
            <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Campaign Creation</h2>
            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <form action="{{ route('admin.settings.globalPromotion') }}" method="POST" id="globalPromoForm" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                        <!-- Strategy -->
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Promotion Strategy</label>
                                <select name="promotion_type" x-model="promoType" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:border-black focus:ring-0">
                                    <option value="discount_percent">Percentage Discount</option>
                                    <option value="bogo">Buy 1 Free 1 (BOGO)</option>
                                </select>
                            </div>

                            <div class="space-y-2" x-show="promoType === 'discount_percent'">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Discount Percentage</label>
                                <div class="relative">
                                    <input type="number" name="discount_percentage" x-model="discountPercent" min="1" max="100" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:border-black focus:ring-0" placeholder="0">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Start Date</label>
                                    <input type="datetime-local" name="promotion_starts_at" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-[11px] font-bold focus:border-black focus:ring-0">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">End Date</label>
                                    <input type="datetime-local" name="promotion_ends_at" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-[11px] font-bold focus:border-black focus:ring-0">
                                </div>
                            </div>
                        </div>

                        <!-- Reach -->
                        <div class="space-y-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Campaign Scope</label>
                                <select name="target_scope" x-model="targetScope" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:border-black focus:ring-0">
                                    <option value="all">Global (All Products)</option>
                                    <option value="category">Category-Specific</option>
                                    <option value="individual">Product-Specific</option>
                                </select>
                            </div>

                            <div x-show="targetScope === 'category'" x-cloak class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Target Category</label>
                                <select name="target_category" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:border-black focus:ring-0">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div x-show="targetScope === 'individual'" x-cloak class="space-y-4"
                                 x-data="{ isOpen: false, allProducts: [], async init() { const r = await fetch(`{{ route('admin.api.products.search') }}`); this.allProducts = await r.json(); } }"
                                 @click.away="isOpen = false">
                                
                                <div class="relative">
                                    <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest block mb-2">Selected Products</label>
                                    <div @click="isOpen = !isOpen" 
                                         class="w-full rounded-xl border border-gray-100 bg-gray-50 px-4 py-3 flex items-center justify-between cursor-pointer hover:border-black transition-all text-sm font-bold">
                                        <span class="text-gray-900" x-text="selectedProducts.length > 0 ? `${selectedProducts.length} items selected` : 'Browse catalog...'"></span>
                                        <svg class="w-4 h-4 text-gray-400" :class="isOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </div>

                                    <div x-show="isOpen" class="absolute z-30 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                        <div class="p-4 bg-gray-50 border-b border-gray-100">
                                            <input type="text" x-model="search" @input.debounce.300ms="searchProducts()" placeholder="Search by name or SKU..." 
                                                   class="w-full rounded-xl border-gray-100 text-xs font-bold py-2.5 focus:ring-0 focus:border-black">
                                        </div>
                                        <div class="max-h-60 overflow-y-auto scrollbar-hide">
                                            <template x-for="product in (search ? searchResults : allProducts)" :key="product.id">
                                                <div @click="addProduct(product)" 
                                                     class="px-5 py-3 hover:bg-gray-50 cursor-pointer flex items-center justify-between border-b border-gray-50 last:border-0"
                                                     :class="selectedProducts.find(p => p.id === product.id) ? 'bg-gray-50' : ''">
                                                    <div>
                                                        <p class="text-xs font-bold text-gray-900" x-text="product.name"></p>
                                                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest" x-text="product.sku"></p>
                                                    </div>
                                                    <div x-show="selectedProducts.find(p => p.id === product.id)" class="text-black">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <template x-for="product in selectedProducts" :key="product.id">
                                        <div class="inline-flex items-center gap-2 bg-black text-white px-3 py-1 rounded-full">
                                            <span class="text-[9px] font-bold uppercase tracking-widest" x-text="product.sku"></span>
                                            <button type="button" @click="removeProduct(product.id)" class="text-white/60 hover:text-white">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"/></svg>
                                            </button>
                                            <input type="hidden" name="target_products[]" :value="product.id">
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest">Target Audience</label>
                                <select name="promotion_target" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl text-sm font-bold focus:border-black focus:ring-0">
                                    <option value="all">Public (All Users)</option>
                                    <option value="direct">Direct Customers Only</option>
                                    <option value="reseller">B2B Resellers Only</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-8 border-t border-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                Status: <span class="text-gray-900" x-text="getImpactText()"></span>
                            </div>
                        </div>
                        <button type="button" @click="if ($event.target.closest('form').reportValidity()) { showModal = true }" class="bg-black text-white px-12 py-4 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-gray-800 transition-all shadow-sm">
                            Launch Campaign
                        </button>
                    </div>

                    <!-- Confirmation Modal -->
                    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px]">
                        <div class="bg-white rounded-2xl p-10 max-w-sm w-full shadow-2xl border border-gray-100 animate-in fade-in zoom-in duration-300">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Final Confirmation</h3>
                            <p class="text-sm text-gray-500 mb-8" x-text="getImpactText()"></p>
                            <div class="flex gap-4">
                                <button type="button" @click="showModal = false" class="flex-1 py-4 border border-gray-100 rounded-xl text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:bg-gray-50">Back</button>
                                <button type="button" @click="$event.target.closest('form').submit()" class="flex-1 py-4 bg-black text-white rounded-xl text-[10px] font-bold uppercase tracking-widest">Launch</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Ledger of Active Promos -->
        <div class="space-y-8">
            <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Active Promotion Ledger</h2>
            
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-50">
                                <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Target Product</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Strategy</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Impact Value</th>
                                <th class="px-8 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($productsOnPromotion as $product)
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 p-1 shrink-0 overflow-hidden">
                                                @if($product->primaryImage)
                                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-cover rounded-lg">
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-gray-900">{{ $product->name }}</p>
                                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ $product->sku }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $product->promotion_type === 'bogo' ? 'bg-black text-white' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $product->promotion_type === 'bogo' ? 'BOGO' : 'Discount' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-bold text-gray-900">{{ $product->promotion_type === 'discount_percent' ? $product->promotion_value . '%' : 'Buy 1 Get 1' }}</p>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <form action="{{ route('admin.settings.removeProductPromotion', $product) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="p-2 text-gray-300 hover:text-red-600 transition-colors" title="Terminate Promotion">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-24 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-200">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            </div>
                                            <p class="text-[10px] font-bold text-gray-300 uppercase tracking-[0.2em]">No Active Campaigns</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
