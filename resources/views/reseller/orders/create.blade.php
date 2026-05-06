<x-app-layout title="Order Wholesale Stock">
    <div class="max-w-full pb-32">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Wholesale Catalog</h1>
                <p class="text-sm text-gray-500 mt-1">Acquire stock from HQ to manage your local inventory.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <button type="button" @click="$dispatch('open-scanner')" class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-100 text-gray-600 hover:text-black text-xs font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    Scan SKU
                </button>
                <a href="{{ route('reseller.orders.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    View History
                </a>
            </div>
        </div>

        <form id="order-form" action="{{ route('reseller.orders.store') }}" method="POST">
            @csrf

            @if($errors->any())
                <div class="mb-10 p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm border border-rose-100 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-rose-900">Ordering errors detected</h3>
                        <ul class="mt-1 text-xs text-rose-600 font-medium space-y-1 pl-4 list-disc">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php $counter = 0; @endphp
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col transition-all duration-300 hover:shadow-md overflow-hidden">
                        <!-- Product Header -->
                        <div class="p-8 bg-gray-50/30 border-b border-gray-50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $product->sku }}</p>
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $product->name }}</h3>
                        </div>

                        <!-- Product Variants -->
                        <div class="p-6 space-y-4">
                            @foreach($product->variants as $variant)
                                <div class="p-4 rounded-xl border border-gray-50 bg-gray-50/20 group transition-all hover:bg-white hover:border-gray-200">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $variant->name }} Edition</p>
                                            <p class="text-sm font-bold text-gray-900">RM{{ number_format($variant->wholesale_price, 2) }}</p>
                                            <p class="text-[9px] font-bold {{ $variant->stock > 0 ? 'text-emerald-500' : 'text-rose-400' }} uppercase mt-1 tracking-wider">
                                                {{ $variant->stock > 0 ? $variant->stock . ' units available' : 'Sold Out' }}
                                            </p>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center gap-1 bg-white border border-gray-100 p-1 rounded-xl shadow-sm shrink-0">
                                            <input type="hidden" name="variant_id[{{ $counter }}]" value="{{ $variant->id }}">
                                            <input type="hidden" class="product-price" value="{{ $variant->wholesale_price }}">
                                            
                                            <button type="button" 
                                                    class="qty-btn minus w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 text-gray-400 hover:text-black hover:bg-gray-100 transition-colors {{ $variant->stock === 0 ? 'opacity-30' : '' }}" 
                                                    {{ $variant->stock === 0 ? 'disabled' : '' }}>
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                            </button>
                                            
                                            <input type="number" 
                                                   name="quantity[{{ $counter }}]" 
                                                   class="qty-input w-10 text-center text-sm font-bold border-transparent bg-transparent p-0 focus:ring-0 text-gray-900 tabular-nums" 
                                                   data-sku="{{ $variant->sku ?? $product->sku }}"
                                                   value="0" 
                                                   min="0" 
                                                   max="{{ $variant->stock }}"
                                                   {{ $variant->stock === 0 ? 'disabled' : '' }}>
                                                   
                                            <button type="button" 
                                                    class="qty-btn plus w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 text-gray-400 hover:text-black hover:bg-gray-100 transition-colors {{ $variant->stock === 0 ? 'opacity-30' : '' }}" 
                                                    {{ $variant->stock === 0 ? 'disabled' : '' }}>
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @php $counter++; @endphp
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sticky Checkout Footer -->
            <div id="checkout-footer" class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-gray-100 px-8 py-6 transform transition-transform duration-500 translate-y-full z-50 shadow-[0_-10px_30px_rgba(0,0,0,0.03)]">
                <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-10">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Items Selected</p>
                            <p class="text-xl font-bold text-gray-900"><span id="total-items">0</span> <span class="text-xs font-bold text-gray-400 uppercase">units</span></p>
                        </div>
                        <div class="w-px h-8 bg-gray-100"></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Amount</p>
                            <p id="total-price" class="text-2xl font-bold text-gray-900 tabular-nums">RM0.00</p>
                        </div>
                    </div>
                    
                    <button type="submit" id="checkout-btn" disabled class="w-full md:w-auto px-12 py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed">
                        Proceed to Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <x-scanner-modal target-event="order-barcode-scanned" />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.qty-input');
            const totalItemsEl = document.getElementById('total-items');
            const totalPriceEl = document.getElementById('total-price');
            const checkoutBtn = document.getElementById('checkout-btn');
            const footer = document.getElementById('checkout-footer');

            function updateCart() {
                let items = 0;
                let price = 0;

                inputs.forEach(input => {
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) {
                        const priceContainer = input.closest('.flex');
                        const unitPrice = parseFloat(priceContainer.querySelector('.product-price').value) || 0;
                        items += qty;
                        price += (qty * unitPrice);
                    }
                });

                totalItemsEl.textContent = items;
                totalPriceEl.textContent = 'RM' + price.toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
                if (items > 0) {
                    footer.classList.remove('translate-y-full');
                    checkoutBtn.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                    checkoutBtn.classList.add('bg-black', 'text-white', 'hover:bg-gray-800', 'shadow-lg', 'shadow-black/10');
                    checkoutBtn.disabled = false;
                } else {
                    footer.classList.add('translate-y-full');
                    checkoutBtn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                    checkoutBtn.classList.remove('bg-black', 'text-white', 'hover:bg-gray-800', 'shadow-lg', 'shadow-black/10');
                    checkoutBtn.disabled = true;
                }
            }

            document.querySelectorAll('.qty-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const isPlus = btn.classList.contains('plus');
                    const input = btn.parentElement.querySelector('.qty-input');
                    const max = parseInt(input.max) || 0;
                    let val = parseInt(input.value) || 0;

                    if (isPlus && val < max) input.value = val + 1;
                    else if (!isPlus && val > 0) input.value = val - 1;
                    
                    updateCart();
                });
            });

            inputs.forEach(input => {
                input.addEventListener('change', () => {
                    const max = parseInt(input.max) || 0;
                    let val = parseInt(input.value) || 0;
                    if (val < 0) input.value = 0;
                    if (val > max) input.value = max;
                    updateCart();
                });
            });

            window.addEventListener('order-barcode-scanned', (e) => {
                const sku = e.detail.sku;
                inputs.forEach(input => {
                    if (input.dataset.sku === sku && !input.disabled) {
                        const max = parseInt(input.max) || 0;
                        let val = parseInt(input.value) || 0;
                        if (val < max) {
                            input.value = val + 1;
                            updateCart();
                            const container = input.closest('.p-4');
                            if (container) {
                                container.classList.add('ring-1', 'ring-black', 'bg-black/5');
                                setTimeout(() => container.classList.remove('ring-1', 'ring-black', 'bg-black/5'), 1000);
                                container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
