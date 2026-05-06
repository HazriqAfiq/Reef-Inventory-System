<x-app-layout title="Order Wholesale Stock">
    <div class="max-w-full pb-32">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Wholesale Catalog</h1>
                <p class="text-sm text-gray-500 mt-1">Acquire stock from HQ to manage your local inventory. Minimum order quantity is 15 items.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
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
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col transition-all duration-300 hover:shadow-md overflow-hidden group">
                        <!-- Product Info -->
                        <div class="p-6 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $product->sku }}</p>
                                    <h3 class="text-lg font-bold text-gray-900 leading-tight mb-2">{{ $product->name }}</h3>
                                    <p class="text-sm font-bold text-gray-900">RM{{ number_format($product->wholesale_price, 2) }}</p>
                                    <p class="text-[9px] font-bold {{ $product->stock > 0 ? 'text-emerald-500' : 'text-rose-400' }} uppercase mt-1 tracking-wider">
                                        {{ $product->stock > 0 ? $product->stock . ' units available' : 'Sold Out' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-1 bg-white border border-gray-100 p-1 rounded-xl shadow-sm mt-4 w-fit">
                                <input type="hidden" name="product_id[{{ $counter }}]" value="{{ $product->id }}">
                                <input type="hidden" class="product-price" value="{{ $product->wholesale_price }}">
                                
                                <button type="button" 
                                        class="qty-btn minus w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 text-gray-400 hover:text-black hover:bg-gray-100 transition-colors {{ $product->stock === 0 ? 'opacity-30' : '' }}" 
                                        {{ $product->stock === 0 ? 'disabled' : '' }}>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                </button>
                                
                                <input type="number" 
                                       name="quantity[{{ $counter }}]" 
                                       class="qty-input w-12 text-center text-sm font-bold border-transparent bg-transparent p-0 focus:ring-0 text-gray-900 tabular-nums" 
                                       data-sku="{{ $product->sku }}"
                                       value="0" 
                                       min="0" 
                                       max="{{ $product->stock }}"
                                       {{ $product->stock === 0 ? 'disabled' : '' }}>
                                       
                                <button type="button" 
                                        class="qty-btn plus w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 text-gray-400 hover:text-black hover:bg-gray-100 transition-colors {{ $product->stock === 0 ? 'opacity-30' : '' }}" 
                                        {{ $product->stock === 0 ? 'disabled' : '' }}>
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @php $counter++; @endphp
                @endforeach
            </div>

            <!-- Sticky Checkout Footer -->
            <div id="checkout-footer" class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md border-t border-gray-100 px-8 py-6 transform transition-transform duration-500 translate-y-full z-50 shadow-[0_-10px_30px_rgba(0,0,0,0.03)]">
                <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center gap-10 flex-wrap justify-center md:justify-start">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Items Selected</p>
                            <p class="text-xl font-bold text-gray-900"><span id="total-items">0</span> <span class="text-xs font-bold text-gray-400 uppercase">units</span></p>
                            <p id="moq-warning" class="text-[9px] font-bold text-rose-500 uppercase tracking-widest mt-1 hidden">Minimum 15 units required</p>
                        </div>
                        <div class="w-px h-8 bg-gray-100 hidden md:block"></div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Amount</p>
                            <p id="total-price" class="text-2xl font-bold text-gray-900 tabular-nums">RM0.00</p>
                        </div>
                    </div>
                    
                    <button type="submit" id="checkout-btn" disabled class="w-full md:w-auto px-12 py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center">
                        Proceed to Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('.qty-input');
            const totalItemsEl = document.getElementById('total-items');
            const totalPriceEl = document.getElementById('total-price');
            const moqWarningEl = document.getElementById('moq-warning');
            const checkoutBtn = document.getElementById('checkout-btn');
            const footer = document.getElementById('checkout-footer');

            const MIN_ORDER_QTY = 15;

            function updateCart() {
                let items = 0;
                let price = 0;

                inputs.forEach(input => {
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) {
                        const priceContainer = input.closest('.flex.flex-col'); // .p-6 container
                        const unitPrice = parseFloat(priceContainer.querySelector('.product-price').value) || 0;
                        items += qty;
                        price += (qty * unitPrice);
                    }
                });

                totalItemsEl.textContent = items;
                totalPriceEl.textContent = 'RM' + price.toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                
                if (items > 0) {
                    footer.classList.remove('translate-y-full');
                    if (items >= MIN_ORDER_QTY) {
                        moqWarningEl.classList.add('hidden');
                        checkoutBtn.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        checkoutBtn.classList.add('bg-black', 'text-white', 'hover:bg-gray-800', 'shadow-lg', 'shadow-black/10');
                        checkoutBtn.disabled = false;
                        checkoutBtn.textContent = 'Proceed to Payment';
                    } else {
                        moqWarningEl.classList.remove('hidden');
                        checkoutBtn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        checkoutBtn.classList.remove('bg-black', 'text-white', 'hover:bg-gray-800', 'shadow-lg', 'shadow-black/10');
                        checkoutBtn.disabled = true;
                        checkoutBtn.textContent = `Need ${MIN_ORDER_QTY - items} more`;
                    }
                } else {
                    footer.classList.add('translate-y-full');
                    checkoutBtn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                    checkoutBtn.classList.remove('bg-black', 'text-white', 'hover:bg-gray-800', 'shadow-lg', 'shadow-black/10');
                    checkoutBtn.disabled = true;
                    checkoutBtn.textContent = 'Proceed to Payment';
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
        });
    </script>
</x-app-layout>
