<x-app-layout title="Scan & Restock">
    <div x-data="scanInController()">
        
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Scan & Restock</h1>
                <p class="text-sm text-gray-500 mt-1">Process and audit new inventory arrivals using barcode scanning.</p>
            </div>
            <button @click="$dispatch('open-scanner')" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Launch Scanner
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Intake Workspace -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Identification Area -->
                <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm relative">
                    <div x-show="loading" class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center rounded-2xl">
                        <div class="w-6 h-6 border-2 border-gray-200 border-t-black rounded-full animate-spin"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Identify Product (SKU/Barcode)</label>
                            <input type="text" x-model="skuInput" @keydown.enter.prevent="lookupProduct()" 
                                   placeholder="Scan or type SKU..." autofocus
                                   class="w-full px-4 py-3 text-sm font-bold text-gray-900 border-gray-200 rounded-xl focus:border-black focus:ring-black">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Manual Selection</label>
                            <select @change="if($event.target.value) { skuInput = $event.target.value; lookupProduct(); $event.target.value = ''; }"
                                    class="w-full px-4 py-3 text-sm font-bold text-gray-900 border-gray-200 rounded-xl focus:border-black focus:ring-black">
                                <option value="">Browse Catalog...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->sku }}">
                                        {{ $product->name }} ({{ $product->stock }} ON HAND)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product Detail & Audit Panel -->
                <div x-show="product" x-cloak class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm animate-fade-in-up">
                    <div class="flex flex-col sm:flex-row gap-8 items-start">
                        <div class="w-32 h-32 bg-gray-50 border border-gray-100 rounded-xl overflow-hidden shrink-0">
                            <template x-if="product?.image_url">
                                <img :src="product.image_url" class="w-full h-full object-cover">
                            </template>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="mb-6">
                                <h2 class="text-xl font-bold text-gray-900 tracking-tight" x-text="product?.name"></h2>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1" x-text="'SKU: ' + product?.sku"></p>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-end">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Intake Quantity</label>
                                    <input type="number" x-model="qtyToAdd" min="1" 
                                           class="w-full px-4 py-4 text-2xl font-bold text-center border-gray-200 rounded-xl focus:border-black focus:ring-black">
                                </div>
                                <button @click="restock()" :disabled="submitting || !qtyToAdd || qtyToAdd < 1"
                                        class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all disabled:opacity-20 flex items-center justify-center gap-2">
                                    <template x-if="submitting">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </template>
                                    <template x-if="!submitting">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                    </template>
                                    Confirm Intake
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-show="error" x-cloak class="p-4 bg-red-50 border border-red-100 rounded-xl text-xs font-bold text-red-600 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span x-text="error"></span>
                </div>
            </div>

            <!-- Right: Audit Log -->
            <div class="space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Session Audit Log</h3>
                    <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest" x-text="scanLogs.length + ' Entries'"></span>
                </div>
                
                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    <template x-for="log in scanLogs.slice().reverse()" :key="log.id">
                        <div class="p-4 bg-white border border-gray-100 rounded-xl flex items-center gap-4 animate-fade-in-up shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate" x-text="'+' + log.qty + ' ' + log.name"></p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5" x-text="log.time"></p>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="scanLogs.length === 0" class="text-center py-12 border-2 border-dashed border-gray-100 rounded-2xl">
                        <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">Intake Ledger Clear</p>
                    </div>
                </div>
            </div>
    </div>

    <x-scanner-modal target-event="barcode-scanned" />

    <script>
        function scanInController() {
            return {
                skuInput: '',
                qtyToAdd: 1,
                product: null,
                loading: false,
                submitting: false,
                error: '',
                scanLogs: [],

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
                    this.product = null;

                    try {
                        const response = await fetch(`/admin/api/scan/${this.skuInput}`);
                        const data = await response.json();

                        if (data.success) {
                            this.product = data.product;
                            this.qtyToAdd = 1;
                        } else {
                            this.error = data.message;
                        }
                    } catch (err) {
                        this.error = 'Network error. Please try again.';
                    } finally {
                        this.loading = false;
                    }
                },

                async restock() {
                    if (!this.product || !this.qtyToAdd) return;
                    this.submitting = true;
                    this.error = '';

                    try {
                        const response = await fetch('/admin/inventory/scan-in', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                sku: this.product.sku,
                                quantity: this.qtyToAdd
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.scanLogs.push({
                                id: Date.now(),
                                name: this.product.name,
                                qty: this.qtyToAdd,
                                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                            });
                            this.product = null;
                            this.skuInput = '';
                        } else {
                            this.error = data.message;
                        }
                    } catch (err) {
                        this.error = 'Failed to audit intake. Please check network.';
                    } finally {
                        this.submitting = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
