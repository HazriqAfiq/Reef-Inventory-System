<x-app-layout title="Counter Sales">
    <div x-data="posController()">
        
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Counter Sales</h1>
                <p class="text-sm text-gray-500 mt-1">Record direct B2C transactions and update inventory in real-time.</p>
            </div>
            <button @click="$dispatch('open-scanner')" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Launch Scanner
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Input & Cart -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Input Area -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative">
                    <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center rounded-2xl">
                        <div class="w-6 h-6 border-2 border-gray-200 border-t-black rounded-full animate-spin"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">SKU / Barcode</label>
                            <div class="relative">
                                <input type="text" x-model="skuInput" @keydown.enter.prevent="lookupProduct()" 
                                       placeholder="Ready for Input..." autofocus
                                       class="w-full pl-4 pr-10 py-3 text-sm font-bold text-gray-900 border-gray-200 rounded-xl focus:border-black focus:ring-black">
                                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Manual Search</label>
                            <select @change="if($event.target.value) { skuInput = $event.target.value; lookupProduct(); $event.target.value = ''; }"
                                    class="w-full px-4 py-3 text-sm font-bold text-gray-900 border-gray-200 rounded-xl focus:border-black focus:ring-black">
                                <option value="">Browse Catalog...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->sku }}">
                                        {{ $product->name }} ({{ $product->stock }} LEFT)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div x-show="error" x-cloak class="mt-4 text-xs font-bold text-red-600 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span x-text="error"></span>
                    </div>
                </div>

                <!-- Active Register -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                        <h2 class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Active Register</h2>
                        <button @click="cart = []" x-show="cart.length > 0" class="text-[10px] font-bold text-gray-400 hover:text-red-600 uppercase tracking-wider transition-colors">Clear All</button>
                    </div>
                    
                    <div class="divide-y divide-gray-50">
                        <template x-for="(item, index) in cart" :key="item.id">
                            <div class="px-8 py-5 flex items-center gap-6 hover:bg-gray-50/30 transition-all">
                                <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-lg overflow-hidden shrink-0">
                                    <template x-if="item.image_url"><img :src="item.image_url" class="w-full h-full object-cover"></template>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900" x-text="item.name"></p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-0.5" x-text="item.sku"></p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button @click="updateQty(index, -1)" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-black hover:border-black">-</button>
                                    <span class="text-sm font-bold text-gray-900 w-6 text-center" x-text="item.quantity"></span>
                                    <button @click="updateQty(index, 1)" class="w-7 h-7 rounded-lg border border-gray-200 flex items-center justify-center text-gray-400 hover:text-black hover:border-black">+</button>
                                </div>
                                <div class="w-24 text-right">
                                    <p class="text-sm font-bold text-gray-900" x-text="fmt(item.price * item.quantity)"></p>
                                </div>
                                <button @click="removeItem(index)" class="text-gray-300 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                        
                        <div x-show="cart.length === 0" class="py-20 text-center">
                            <p class="text-xs font-bold text-gray-300 uppercase tracking-[0.2em]">Register Empty</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Checkout -->
            <div class="space-y-8">
                <div class="bg-gray-900 rounded-2xl p-8 text-white shadow-xl sticky top-24">
                    <h2 class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em] mb-8 border-b border-white/5 pb-4">Transaction Summary</h2>
                    
                    <div class="space-y-4 mb-10">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-gray-500 uppercase">Items:</span>
                            <span x-text="totalItems()"></span>
                        </div>
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-gray-500 uppercase">Tax:</span>
                            <span>RM 0.00</span>
                        </div>
                    </div>
                    
                    <div class="bg-white/5 rounded-xl p-6 mb-10 border border-white/5">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Receivable</p>
                        <p class="text-3xl font-bold tracking-tight" x-text="fmt(totalRevenue())"></p>
                    </div>

                    <button @click="checkout()" :disabled="cart.length === 0 || submitting"
                            class="w-full py-4 bg-white text-black hover:bg-gray-100 text-xs font-bold uppercase tracking-widest rounded-xl transition-all disabled:opacity-20 flex items-center justify-center gap-2">
                        <template x-if="submitting">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </template>
                        <template x-if="!submitting">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </template>
                        Complete Order
                    </button>
                    
                    <div x-show="checkoutSuccess" x-cloak class="mt-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-[10px] font-bold uppercase tracking-widest text-center">
                        Order Recorded Successfully
                    </div>
                </div>
            </div>
    </div>

    <x-scanner-modal target-event="barcode-scanned" />

    <script>
        function posController() {
            return {
                skuInput: '',
                cart: [],
                loading: false,
                submitting: false,
                error: '',
                checkoutSuccess: false,

                init() {
                    window.addEventListener('barcode-scanned', (e) => {
                        this.skuInput = e.detail.sku;
                        this.lookupProduct();
                    });
                },

                async lookupProduct() {
                    if (!this.skuInput) return;
                    
                    this.loading = true;
                    this.error = '';
                    this.checkoutSuccess = false;

                    try {
                        const response = await fetch(`/admin/api/scan/${this.skuInput}`);
                        const data = await response.json();

                        if (data.success) {
                            this.addToCart(data.product);
                            this.skuInput = '';
                        } else {
                            this.error = data.message;
                        }
                    } catch (err) {
                        this.error = 'Network error. Please try again.';
                    } finally {
                        this.loading = false;
                    }
                },

                addToCart(product) {
                    const existing = this.cart.find(item => item.id === product.id);
                    if (existing) {
                        existing.quantity++;
                    } else {
                        this.cart.push({
                            id: product.id,
                            name: product.name,
                            sku: product.sku,
                            price: product.retail_price,
                            image_url: product.image_url,
                            quantity: 1,
                            stock: product.stock
                        });
                    }
                },

                updateQty(index, delta) {
                    const item = this.cart[index];
                    const newQty = item.quantity + delta;
                    if (newQty > 0 && newQty <= item.stock) {
                        item.quantity = newQty;
                    }
                },

                validateQty(index) {
                    const item = this.cart[index];
                    if (item.quantity > item.stock) item.quantity = item.stock;
                    if (item.quantity < 1) item.quantity = 1;
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                totalItems() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },

                totalRevenue() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                fmt(val) {
                    return 'RM' + parseFloat(val).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                },

                async checkout() {
                    if (this.cart.length === 0) return;
                    
                    this.submitting = true;
                    this.error = '';

                    try {
                        const response = await fetch('/admin/sales/pos', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                items: this.cart.map(item => ({
                                    id: item.id,
                                    quantity: item.quantity
                                }))
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.checkoutSuccess = true;
                            this.cart = [];
                            setTimeout(() => this.checkoutSuccess = false, 5000);
                        } else {
                            this.error = data.message;
                        }
                    } catch (err) {
                        this.error = 'Transaction failed. Please check network.';
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
