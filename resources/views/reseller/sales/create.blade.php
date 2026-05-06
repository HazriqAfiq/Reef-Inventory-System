<x-app-layout title="Record Sale">
    <div class="max-w-full">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Record Sale</h1>
                <p class="text-sm text-gray-500 mt-1">Deduct from your local stock to record a retail sale.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('reseller.sales.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-100 text-gray-400 hover:text-black text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to History
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/20">
                <h1 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Transaction Details</h1>
            </div>

            <!-- Form Body -->
            <form id="sale-form" action="{{ route('reseller.sales.store') }}" method="POST" class="p-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Left: Input Controls -->
                    <div class="space-y-8">
                        <!-- Product Selection -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label for="product_id" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Select Product</label>
                                <button type="button" @click="$dispatch('open-scanner')" class="text-[10px] font-bold text-black hover:opacity-70 flex items-center gap-1.5 uppercase tracking-widest transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                                    Scan Barcode
                                </button>
                            </div>
                            <div class="relative group">
                                <select id="product_id" name="product_id" required
                                        class="w-full pl-4 pr-10 py-3.5 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-black/5 focus:border-black appearance-none transition-all cursor-pointer">
                                    <option value="">— Choose from your stock —</option>
                                    @foreach($products as $stock)
                                        <option value="{{ $stock->product_id }}"
                                                data-price="{{ $stock->product->retail_price }}"
                                                data-stock="{{ $stock->quantity }}"
                                                data-volume="{{ $stock->product->volume_ml }}"
                                                data-sku="{{ $stock->product->sku }}"
                                                {{ old('product_id') == $stock->product_id ? 'selected' : '' }}>
                                            {{ $stock->product->name }} ({{ $stock->product->volume_ml }}ml)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 group-hover:text-black transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            @error('product_id')
                                <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity Selector -->
                        <div>
                            <label for="quantity" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Transaction Quantity</label>
                            <div class="flex items-center gap-3">
                                <button type="button" id="qty-minus"
                                        class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-100 text-gray-400 hover:text-black hover:bg-gray-100 transition-all shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                </button>

                                <input id="quantity" name="quantity" type="number" min="1" value="{{ old('quantity', 1) }}" required
                                       class="flex-1 h-12 text-center text-lg font-bold text-gray-900 border border-gray-100 bg-gray-50 rounded-xl focus:ring-2 focus:ring-black/5 focus:border-black tabular-nums transition-all">

                                <button type="button" id="qty-plus"
                                        class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 border border-gray-100 text-gray-400 hover:text-black hover:bg-gray-100 transition-all shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>

                            <!-- Warning -->
                            <p id="stock-warning" class="hidden mt-4 p-3 bg-amber-50 border border-amber-100 text-amber-700 text-[11px] font-bold uppercase tracking-wider rounded-xl flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span id="stock-warning-text"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Right: Dynamic Analysis -->
                    <div class="space-y-6">
                        <!-- Stock Status Card -->
                        <div id="product-info" class="hidden p-6 rounded-2xl bg-gray-50/50 border border-gray-100 space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Retail Price</p>
                                    <p id="info-price" class="text-lg font-bold text-gray-900 tabular-nums">—</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1">Edition</p>
                                    <p id="info-volume" class="text-lg font-bold text-gray-900 tabular-nums">—</p>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Local Availability</p>
                                    <p id="info-stock" class="text-xs font-bold text-gray-900">—</p>
                                </div>
                                <div class="w-full h-1.5 bg-white border border-gray-100 rounded-full overflow-hidden">
                                    <div id="info-stock-bar" class="h-full bg-black transition-all duration-1000" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Preview -->
                        <div id="total-preview" class="hidden p-8 rounded-2xl bg-black flex flex-col items-center justify-center text-center shadow-lg shadow-black/10">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Total Revenue</p>
                            <p id="preview-total" class="text-3xl font-bold text-white tracking-tight tabular-nums">RM0.00</p>
                            <div class="mt-4 px-4 py-1.5 bg-white/10 border border-white/10 rounded-full">
                                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest">
                                    <span id="preview-qty">1</span> unit × <span id="preview-unit-price">RM0.00</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-end gap-3 mt-12 pt-8 border-t border-gray-50">
                    <button type="button" id="reset-btn"
                            class="px-6 py-3 text-xs font-bold text-gray-400 hover:text-black uppercase tracking-widest transition-all">
                        Clear Form
                    </button>
                    <button type="submit" id="submit-btn"
                            class="inline-flex items-center gap-2 px-10 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm disabled:opacity-30 disabled:cursor-not-allowed">
                        Record Sale
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-8 text-center text-[10px] font-bold text-gray-300 uppercase tracking-widest">
            Confirmed sales will immediately update your inventory ledger.
        </p>
    </div>

    <x-scanner-modal target-event="barcode-scanned" />

    <script>
    (function () {
        const productSelect  = document.getElementById('product_id');
        const qtyInput       = document.getElementById('quantity');
        const qtyMinus       = document.getElementById('qty-minus');
        const qtyPlus        = document.getElementById('qty-plus');
        const productInfo    = document.getElementById('product-info');
        const totalPreview   = document.getElementById('total-preview');
        const infoPrice      = document.getElementById('info-price');
        const infoStock      = document.getElementById('info-stock');
        const infoVolume     = document.getElementById('info-volume');
        const infoStockBar   = document.getElementById('info-stock-bar');
        const previewQty     = document.getElementById('preview-qty');
        const previewUnit    = document.getElementById('preview-unit-price');
        const previewTotal   = document.getElementById('preview-total');
        const stockWarning   = document.getElementById('stock-warning');
        const stockWarnText  = document.getElementById('stock-warning-text');
        const submitBtn      = document.getElementById('submit-btn');
        const resetBtn       = document.getElementById('reset-btn');

        let currentPrice = 0;
        let currentStock = 0;

        const fmt = v => 'RM' + Number(v).toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        function update() {
            const selected = productSelect.options[productSelect.selectedIndex];
            if (!selected || !selected.value) {
                productInfo.classList.add('hidden');
                totalPreview.classList.add('hidden');
                stockWarning.classList.add('hidden');
                submitBtn.disabled = true;
                return;
            }

            currentPrice = parseFloat(selected.dataset.price) || 0;
            currentStock = parseInt(selected.dataset.stock)   || 0;
            
            infoPrice.textContent  = fmt(currentPrice);
            infoStock.textContent  = currentStock + ' units';
            infoVolume.textContent = selected.dataset.volume + 'ml';
            productInfo.classList.remove('hidden');

            const pct = Math.min(100, Math.max(5, (currentStock / 50) * 100));
            infoStockBar.style.width = pct + '%';
            infoStockBar.className = `h-full transition-all duration-1000 ${currentStock <= 5 ? 'bg-rose-500' : 'bg-black'}`;

            const qty = Math.min(Math.max(1, parseInt(qtyInput.value) || 1), currentStock);
            qtyInput.value = qty;
            
            previewQty.textContent   = qty;
            previewUnit.textContent  = fmt(currentPrice);
            previewTotal.textContent = fmt(currentPrice * qty);
            totalPreview.classList.remove('hidden');

            if (qty >= currentStock && currentStock > 0) {
                stockWarnText.textContent = `Local stock limit reached (${currentStock} units).`;
                stockWarning.classList.remove('hidden');
            } else {
                stockWarning.classList.add('hidden');
            }

            submitBtn.disabled = currentStock <= 0;
        }

        qtyMinus.addEventListener('click', () => { if (parseInt(qtyInput.value) > 1) { qtyInput.value--; update(); } });
        qtyPlus.addEventListener('click', () => { if (parseInt(qtyInput.value) < currentStock) { qtyInput.value++; update(); } });
        productSelect.addEventListener('change', update);
        qtyInput.addEventListener('input', update);
        resetBtn.addEventListener('click', () => { productSelect.value = ''; qtyInput.value = 1; update(); });

        window.addEventListener('barcode-scanned', (e) => {
            const scannedSku = e.detail.sku;
            Array.from(productSelect.options).forEach(opt => {
                if (opt.dataset.sku === scannedSku) {
                    productSelect.value = opt.value;
                    qtyInput.value = (parseInt(qtyInput.value) || 0) + 1;
                    update();
                }
            });
        });

        if (productSelect.value) update();
    })();
    </script>
</x-app-layout>
