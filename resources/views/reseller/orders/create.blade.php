<x-app-layout title="Wholesale Fragrance Restock">
    <!-- Premium Minimalist Scrollbar Styles -->
    <style>
        .cart-items-list::-webkit-scrollbar,
        .cart-scroll-container::-webkit-scrollbar,
        .address-scroll-container::-webkit-scrollbar {
            width: 4px;
        }
        .cart-items-list::-webkit-scrollbar-track,
        .cart-scroll-container::-webkit-scrollbar-track,
        .address-scroll-container::-webkit-scrollbar-track {
            background: transparent;
        }
        .cart-items-list::-webkit-scrollbar-thumb,
        .cart-scroll-container::-webkit-scrollbar-thumb,
        .address-scroll-container::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 9999px;
        }
        .cart-items-list::-webkit-scrollbar-thumb:hover,
        .cart-scroll-container::-webkit-scrollbar-thumb:hover,
        .address-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>

    <div class="max-w-full pb-44" x-data="{ 
        cartOpen: false, 
        search: '', 
        activeCategory: 'all'
    }">
        
        <!-- Page Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">B2B Reseller Portal Live</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight">Wholesale Restock HQ</h1>
                <p class="text-xs text-gray-400 mt-1">Replenish your local stock directly from HQ. Orders require a Minimum Order Quantity (MOQ) of {{ $totalMoq }} items total.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-10 p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4 animate-fade-in-up">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm border border-rose-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-rose-900">Restocking errors detected</h3>
                    <ul class="mt-1 text-xs text-rose-600 font-medium space-y-1 pl-4 list-disc">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form id="order-form" action="{{ route('reseller.orders.store') }}" method="POST">
            @csrf

            <!-- Workspace Layout (Desktop: Side-by-side products and static cart, Mobile: stacked) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Product Catalog Grid -->
                <div class="lg:col-span-8 xl:col-span-9 space-y-8">
                    
                    <!-- Search and Category Filter Controls Bar (Placed inside left column so Wholesale Cart sits level next to it) -->
                    <div class="bg-white border border-gray-100 rounded-3xl p-4 md:p-6 shadow-sm flex flex-col xl:flex-row items-stretch xl:items-center justify-between gap-6">
                        <!-- Real-time Search Box -->
                        <div class="relative flex-1 max-w-xl">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   x-model="search"
                                   placeholder="Search catalog by product name..." 
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50/50 border border-gray-100 rounded-xl focus:bg-white focus:border-black focus:ring-0 text-sm font-medium text-gray-800 placeholder-gray-400 transition-all">
                            <button type="button" 
                                    x-show="search.length > 0" 
                                    @click="search = ''" 
                                    class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-black">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Dynamic Category Filter Tabs -->
                        @php
                            $categories = $products->map(fn($p) => $p->category)->filter()->unique('id');
                        @endphp
                        <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-hide py-1">
                            <button type="button" 
                                    @click="activeCategory = 'all'"
                                    :class="activeCategory === 'all' ? 'bg-black text-white shadow-md shadow-black/10' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" 
                                    class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shrink-0">
                                All Fragrances
                            </button>
                            @foreach($categories as $cat)
                                <button type="button" 
                                        @click="activeCategory = '{{ $cat->id }}'"
                                        :class="activeCategory === '{{ $cat->id }}' ? 'bg-black text-white shadow-md shadow-black/10' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" 
                                        class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shrink-0">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Catalog Grid inside left column - Upgraded to 4 columns per row on desktop -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @php $counter = 0; @endphp
                        @foreach($products as $product)
                            @php
                                $isLowStock = $product->stock < $productMoq;
                                $effectiveMoq = $isLowStock ? $product->stock : $productMoq;
                            @endphp
                            <div class="product-card bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between transition-all duration-300 hover:shadow-xl overflow-hidden group"
                                 x-show="(search === '' || {{ json_encode(strtolower($product->name)) }}.includes(search.toLowerCase()) || {{ json_encode(strtolower($product->sku)) }}.includes(search.toLowerCase())) && (activeCategory === 'all' || activeCategory === '{{ $product->category_id }}')">
                                
                                <!-- Premium Product Media (Clickable) -->
                                <a href="{{ route('reseller.products.show', $product->slug) }}" class="block relative aspect-square bg-gray-50 flex items-center justify-center overflow-hidden shrink-0 group/media">
                                    @if($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-50/50 flex flex-col items-center justify-center p-6 text-center">
                                            <svg class="w-12 h-12 text-gray-300 mb-2 transition-transform duration-500 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                            </svg>
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">No Image Available</span>
                                        </div>
                                    @endif
                                </a>

                                <!-- Product Summary & Actions -->
                                <div class="p-4 md:p-5 flex-1 flex flex-col justify-between">
                                    <!-- Clickable Metadata Body -->
                                    <a href="{{ route('reseller.products.show', $product->slug) }}" class="block space-y-4 group/text">
                                        <!-- Category & Stock Badges Row -->
                                        <div class="flex items-center justify-between gap-2">
                                            @if($product->category)
                                                <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2.5 py-1 rounded-md leading-none">{{ $product->category->name }}</span>
                                            @else
                                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 px-2.5 py-1 rounded-md leading-none">Catalog</span>
                                            @endif

                                            @if($product->stock > 0)
                                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase tracking-widest rounded border border-emerald-100 leading-none">In Stock ({{ $product->stock }})</span>
                                            @else
                                                <span class="px-2 py-1 bg-rose-50 text-rose-600 text-[8px] font-black uppercase tracking-widest rounded border border-rose-100 leading-none">Sold Out</span>
                                            @endif
                                        </div>

                                        <!-- Name & Volume next to each other -->
                                        <h3 class="text-[15px] font-bold text-gray-900 leading-snug tracking-tight group-hover/text:text-emerald-600 transition-colors">
                                            {{ $product->name }}
                                            @if($product->volume_ml)
                                                <span class="text-[11px] font-bold text-gray-400 ml-1">({{ $product->volume_ml }}ML)</span>
                                            @endif
                                        </h3>
                                    </a>
                                    <!-- Price, MOQ & Add to Cart Trigger -->
                                    <div class="pt-4 mt-5 border-t border-gray-100 flex flex-col gap-4">
                                        <!-- Price & Badge Row -->
                                        <div class="flex items-start justify-between gap-2">
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-wider leading-none">Price per Unit</p>
                                                <p class="text-base font-black text-gray-900 mt-1 leading-none">RM{{ number_format($product->wholesale_price, 2) }}</p>
                                            </div>
                                            <div class="text-right">
                                                @if($isLowStock)
                                                    <span class="inline-block text-[8px] font-black text-rose-600 uppercase tracking-wider bg-rose-50 border border-rose-100 px-2 py-1 rounded-md leading-none whitespace-nowrap animate-pulse">Clear Stock: Buy All ({{ $product->stock }})</span>
                                                @else
                                                    <span class="inline-block text-[8px] font-black text-amber-600 uppercase tracking-wider bg-amber-50 border border-amber-100 px-2 py-1 rounded-md leading-none whitespace-nowrap">Min. {{ $productMoq }} units</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Dedicated Action Row (Full Width Button/Widget) -->
                                        <div class="relative w-full">
                                            <!-- Hidden fields for cart calculation scripts -->
                                            <input type="hidden" class="product-id" value="{{ $product->id }}">
                                            <input type="hidden" class="product-price" value="{{ $product->wholesale_price }}">
                                            <input type="hidden" class="product-name" value="{{ $product->name }}">
                                            <input type="hidden" class="product-sku" value="{{ $product->sku }}">
                                            <input type="hidden" class="product-image" value="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : '' }}">
                                            <input type="hidden" class="product-max" value="{{ $product->stock }}">
                                            <input type="hidden" class="product-effective-moq" value="{{ $effectiveMoq }}">
                                            <input type="hidden" class="product-buy-all" value="{{ $isLowStock ? 'true' : 'false' }}">

                                            <!-- State 1: Sleek "Add to Cart" Button (Displayed when quantity is 0) -->
                                            <button type="button" 
                                                    class="add-to-cart-btn w-full py-3 bg-black hover:bg-gray-800 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-sm active:scale-[0.98] flex items-center justify-center gap-1.5 {{ $product->stock === 0 ? 'opacity-30 cursor-not-allowed pointer-events-none' : '' }}"
                                                    data-counter="{{ $counter }}"
                                                    onclick="addToCartAction({{ $counter }})">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span>Add To Cart</span>
                                            </button>

                                            <!-- State 2: Active Quantity Selector (Visible when quantity > 0) -->
                                            <div class="qty-counter-widget hidden items-center justify-between bg-gray-50 border border-gray-100 p-1.5 rounded-xl w-full">
                                                <!-- Decrement / Complete Removal Trash Selector -->
                                                <button type="button" 
                                                        class="qty-btn minus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-100 text-gray-400 hover:text-black hover:border-black transition-all shadow-sm"
                                                        onclick="adjustQty({{ $counter }}, false)">
                                                    @if($isLowStock)
                                                        <!-- Elegant trash bin icon when Buy-All is active -->
                                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                                        </svg>
                                                    @endif
                                                </button>
                                                
                                                <div class="flex-1 flex items-center justify-center">
                                                    <input type="number" 
                                                           name="quantity[{{ $counter }}]" 
                                                           class="qty-input w-12 text-center text-xs font-black border-transparent bg-transparent p-0 focus:ring-0 text-gray-900 tabular-nums {{ $isLowStock ? 'pointer-events-none bg-rose-50/50 rounded text-rose-600' : '' }}" 
                                                           data-counter="{{ $counter }}"
                                                           value="{{ old('quantity.' . $counter, $cartItems[$product->id] ?? 0) }}" 
                                                           min="0" 
                                                           max="{{ $product->stock }}"
                                                           onchange="validateInput({{ $counter }})"
                                                           {{ $product->stock === 0 ? 'disabled' : '' }}
                                                           {{ $isLowStock ? 'readonly' : '' }}>
                                                </div>
                                                       
                                                <input type="hidden" name="product_id[{{ $counter }}]" value="{{ $product->id }}">

                                                <!-- Increment Button (Hidden entirely if Low-Stock is active and buying all is locked) -->
                                                <button type="button" 
                                                        class="qty-btn plus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-100 text-gray-400 hover:text-black hover:border-black transition-all shadow-sm {{ $isLowStock ? 'hidden' : '' }}"
                                                        onclick="adjustQty({{ $counter }}, true)">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $counter++; @endphp
                        @endforeach
                    </div>
                </div>

                <!-- Right Column: Static Wholesale Cart Sidebar (Desktop only) -->
                <div class="hidden lg:block lg:col-span-4 xl:col-span-3 lg:sticky lg:top-6">
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col gap-6">
                        <!-- Sidebar Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <span class="relative">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span class="cart-badge-count absolute -top-1.5 -right-1.5 bg-black text-white text-[8px] font-black w-4 h-4 rounded-full flex items-center justify-center border border-white">0</span>
                                </span>
                                <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Wholesale Cart</h2>
                            </div>
                            <span class="cart-items-count-text text-[9px] font-bold text-gray-400 uppercase tracking-wider">0 Items</span>
                        </div>

                        <!-- Scrollable Selected Wholesale Items List -->
                        <div class="cart-items-list space-y-4 pr-3 py-2 divide-y divide-gray-50">
                            <!-- Populated in real-time via JS -->
                        </div>

                        <!-- Progress and MOQ Tracker Indicator -->
                        <div class="border-t border-gray-100 pt-5 space-y-3">
                            <div class="flex justify-between items-baseline">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">MOQ Progress ({{ $totalMoq }} Min)</p>
                                <p class="text-xs font-black text-gray-900 tabular-nums"><span class="cart-total-items text-sm font-black">0</span> / {{ $totalMoq }}</p>
                            </div>
                            <!-- Progress Line Bar -->
                            <div class="w-full bg-gray-50 h-2 rounded-full overflow-hidden shadow-inner relative">
                                <div class="cart-moq-progress h-full bg-gradient-to-r from-amber-400 to-indigo-500 rounded-full transition-all duration-500 w-0"></div>
                            </div>
                            <div class="cart-moq-warning text-[9px] font-bold text-rose-500 uppercase tracking-wider flex items-center gap-1.5 leading-tight">
                                <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>Wholesale orders require a minimum of {{ $totalMoq }} items.</span>
                            </div>
                        </div>

                        <!-- Subtotal and Submit -->
                        <div class="border-t border-gray-100 pt-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Total Price</span>
                                <span class="cart-total-price text-xl font-black text-gray-900 tabular-nums">RM0.00</span>
                            </div>
                            <button type="submit" 
                                    class="cart-checkout-btn w-full py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center"
                                    disabled>
                                Need {{ $totalMoq }} Items
                            </button>
                        </div>
                    </div>
                </div>

            </div>

                <!-- Backdrop Overlay for Slide-Out Drawer (Mobile/Tablet only) -->
                <div x-show="cartOpen" 
                     x-on:click="cartOpen = false" 
                     class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 transition-opacity lg:hidden" 
                     x-cloak></div>

                <!-- Premium Universal Slide-Out Drawer (Mobile/Tablet only) -->
                <div id="cart-sidebar" 
                     :class="cartOpen ? 'translate-x-0' : 'translate-x-full'"
                     class="fixed inset-y-0 right-0 w-full max-w-md bg-white z-50 shadow-2xl p-6 overflow-y-auto transform transition-transform duration-300 ease-in-out lg:hidden"
                     x-cloak>
                    
                    <div class="bg-white lg:border lg:border-gray-100 lg:rounded-3xl p-2 lg:p-6 shadow-none lg:shadow-sm flex flex-col gap-6">
                        
                        <!-- Drawer Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                            <div class="flex items-center gap-2.5">
                                <span class="relative">
                                    <svg class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span id="cart-badge" class="cart-badge-count absolute -top-1.5 -right-1.5 bg-black text-white text-[8px] font-black w-4 h-4 rounded-full flex items-center justify-center">0</span>
                                </span>
                                <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Wholesale Cart</h2>
                            </div>
                            <div class="flex items-center gap-3">
                                <span id="cart-items-count-text" class="cart-items-count-text text-[9px] font-bold text-gray-400 uppercase tracking-wider">0 Items</span>
                                <!-- Close button -->
                                <button type="button" x-on:click="cartOpen = false" class="text-gray-400 hover:text-black">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Scrollable Selected Wholesale Items List -->
                        <div id="cart-items-list" class="cart-items-list space-y-4 max-h-[380px] overflow-y-auto pr-3 py-2 divide-y divide-gray-50">
                            <!-- Populated in real-time via JS -->
                        </div>

                        <!-- Progress and MOQ Tracker Indicator -->
                        <div class="border-t border-gray-100 pt-5 space-y-3">
                            <div class="flex justify-between items-baseline">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">MOQ Progress ({{ $totalMoq }} Min)</p>
                                <p class="text-xs font-black text-gray-900 tabular-nums"><span id="total-items" class="cart-total-items text-sm font-black">0</span> / {{ $totalMoq }}</p>
                            </div>
                            <!-- Graphical Progress Bar -->
                            <div class="w-full h-2 bg-gray-50 rounded-full overflow-hidden shadow-inner relative">
                                <div id="moq-progress" class="cart-moq-progress h-full bg-gradient-to-r from-amber-400 to-indigo-500 rounded-full transition-all duration-500 w-0"></div>
                            </div>
                            <p id="moq-warning" class="cart-moq-warning text-[9px] font-bold text-amber-500 uppercase tracking-wider flex items-center gap-1.5 leading-tight">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>Wholesale orders require a minimum of {{ $totalMoq }} items.</span>
                            </p>
                        </div>

                        <!-- Checkout & Subtotal Summary Panel -->
                        <div class="border-t border-gray-100 pt-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Wholesale Subtotal</span>
                                <span id="total-price" class="cart-total-price text-xl font-black text-gray-900 tracking-tight tabular-nums">RM0.00</span>
                            </div>
                            
                            <!-- Form Submission Checkout Button -->
                            <button type="submit" 
                                    id="checkout-btn" 
                                    disabled 
                                    class="cart-checkout-btn w-full py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center">
                                Need {{ $totalMoq }} Items
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>

        <!-- Static Floating Checkout Summary Panel (Right Bottom, Premium Minimalist Luxury - Hidden on desktop) -->
        <div id="floating-cart-panel" 
             class="fixed bottom-6 right-6 z-30 bg-white border border-gray-100 rounded-3xl p-5 shadow-2xl flex flex-col gap-4 w-80 max-w-[calc(100vw-3rem)] transition-all duration-300 hover:shadow-3xl lg:hidden">
            <!-- Header with Subtotal -->
            <div class="flex items-center justify-between">
                <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Wholesale Subtotal</span>
                <span id="floating-total-price" class="text-base font-black text-gray-900 tabular-nums">RM0.00</span>
            </div>
            
            <!-- MOQ Progress Tracker -->
            <div class="space-y-1.5">
                <div class="flex justify-between items-baseline">
                    <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">MOQ Progress ({{ $totalMoq }} Min)</span>
                    <span class="text-[10px] font-black text-gray-900 tabular-nums"><span id="floating-total-items" class="text-xs font-black">0</span> / {{ $totalMoq }}</span>
                </div>
                <!-- Progress Line Bar -->
                <div class="w-full bg-gray-50 h-1.5 rounded-full overflow-hidden shadow-inner relative">
                    <div id="floating-moq-progress" class="h-full bg-gradient-to-r from-amber-400 to-indigo-500 rounded-full transition-all duration-500 w-0"></div>
                </div>
                <div id="floating-moq-warning" class="text-[8px] font-bold text-amber-500 uppercase tracking-wider flex items-center gap-1 leading-tight">
                    <!-- Dynamic state injected via JS -->
                </div>
            </div>

            <!-- View Cart & Proceed Payment Buttons -->
            <div class="flex items-center gap-3 mt-1">
                <!-- Circular Cart Icon Button for View Cart -->
                <button type="button" 
                        x-on:click="cartOpen = true"
                        class="relative flex items-center justify-center w-12 h-12 bg-white border border-gray-200 text-gray-900 hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50/30 rounded-xl active:scale-95 transition-all shrink-0 shadow-sm"
                        title="View Cart">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span id="floating-cart-badge" class="absolute -top-1 -right-1 bg-rose-500 text-white text-[9px] font-black w-4 h-4 rounded-full flex items-center justify-center border-2 border-white shadow-sm">0</span>
                </button>

                <!-- Proceed Payment Button -->
                <button type="button" 
                        id="floating-checkout-btn" 
                        disabled 
                        class="flex-1 py-3.5 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center shadow-sm">
                    Need {{ $totalMoq }} Items
                </button>
            </div>
        </div>

    </div>

    <!-- Real-time E-Commerce Bidirectional Cart Sync JavaScript Engine -->
    <script>
        function initializeCartEngine() {
            const inputs = document.querySelectorAll('.qty-input');
            const totalItemsEl = document.getElementById('total-items');
            const totalPrices = document.querySelectorAll('#total-price');
            const moqWarningEl = document.getElementById('moq-warning');
            const checkoutBtn = document.getElementById('checkout-btn');
            const floatingCheckoutBtn = document.getElementById('floating-checkout-btn');
            const moqProgress = document.getElementById('moq-progress');
            const cartBadge = document.getElementById('cart-badge');
            const floatingCartBadge = document.getElementById('floating-cart-badge');
            const cartItemsCountText = document.getElementById('cart-items-count-text');
            const cartItemsList = document.getElementById('cart-items-list');

            const MIN_ORDER_QTY = {{ $totalMoq }};
            const MIN_PRODUCT_QTY = {{ $productMoq }};

            // Bidirectional State Synchronizer
            window.syncCardState = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const val = parseInt(input.value) || 0;
                const parentContainer = input.closest('.relative');
                if (!parentContainer) return;

                const addToCartBtn = parentContainer.querySelector('.add-to-cart-btn');
                const qtyWidget = parentContainer.querySelector('.qty-counter-widget');

                if (addToCartBtn && qtyWidget) {
                    if (val > 0) {
                        addToCartBtn.classList.add('hidden');
                        qtyWidget.classList.remove('hidden');
                        qtyWidget.classList.add('flex');
                    } else {
                        addToCartBtn.classList.remove('hidden');
                        qtyWidget.classList.add('hidden');
                        qtyWidget.classList.remove('flex');
                    }
                }
            };

            // Sync current item quantity to database cart via AJAX
            function syncCartToDatabase(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const parent = input.closest('.relative');
                if (!parent) return;
                const pidEl = parent.querySelector('.product-id');
                if (!pidEl) return;
                const productId = pidEl.value;
                const quantity = parseInt(input.value) || 0;

                fetch("{{ route('reseller.cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Cart saved to DB:', data);
                })
                .catch(err => {
                    console.error('Failed to sync cart:', err);
                });
            }

            // "Add to Cart" Initial Trigger Click
            window.addToCartAction = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const max = parseInt(input.max) || 0;
                if (max <= 0) return; // Prevent out of stock trigger

                const parent = input.closest('.relative');
                const effectiveMoq = parseInt(parent.querySelector('.product-effective-moq').value) || MIN_PRODUCT_QTY;

                // Instantly set to effective MOQ (which is exactly all available stock for stock < 10)
                input.value = Math.min(max, effectiveMoq);
                
                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

            // Increments or decrements item quantities
            window.adjustQty = function(counter, isPlus) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const max = parseInt(input.max) || 0;
                let val = parseInt(input.value) || 0;

                const parent = input.closest('.relative');
                const buyAll = parent.querySelector('.product-buy-all').value === 'true';
                const effectiveMoq = parseInt(parent.querySelector('.product-effective-moq').value) || MIN_PRODUCT_QTY;

                if (buyAll) {
                    // For Buy-All Low Stock Items, we toggle strictly between 0 and effectiveMoq (full stock)
                    if (isPlus) {
                        input.value = effectiveMoq;
                    } else {
                        input.value = 0;
                    }
                } else {
                    if (isPlus) {
                        if (val < max) {
                            input.value = val + 1;
                        }
                    } else {
                        if (val <= effectiveMoq) {
                            // Drop beneath MOQ snaps back to zero (and resets to button view)
                            input.value = 0;
                        } else if (val > 0) {
                            input.value = val - 1;
                        }
                    }
                }

                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

            // Handles keyboard wedge direct quantity inputs
            window.validateInput = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const max = parseInt(input.max) || 0;
                let val = parseInt(input.value) || 0;

                const parent = input.closest('.relative');
                const buyAll = parent.querySelector('.product-buy-all').value === 'true';
                const effectiveMoq = parseInt(parent.querySelector('.product-effective-moq').value) || MIN_PRODUCT_QTY;

                if (buyAll) {
                    if (val > 0) {
                        input.value = effectiveMoq; // Snaps to full stock always
                    } else {
                        input.value = 0;
                    }
                } else {
                    if (val < 0) {
                        input.value = 0;
                    } else if (val > max) {
                        input.value = max;
                    } else if (val > 0 && val < effectiveMoq) {
                        // Snaps to MOQ if input is set below minimum per-product requirement
                        input.value = Math.min(max, effectiveMoq);
                    }
                }

                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

            // Outer Sidebar Actions
            window.adjustCartQty = function(counter, isPlus) {
                adjustQty(counter, isPlus);
            };

            window.removeFromCart = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                input.value = 0;
                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

            // Recalculates cart subtotals and renders checkout layout
            function updateCart() {
                let items = 0;
                let price = 0;
                let listHtml = '';

                inputs.forEach(input => {
                    const qty = parseInt(input.value) || 0;
                    if (qty > 0) {
                        const parent = input.parentElement ? input.parentElement.closest('.relative') : null;
                        if (!parent) return;

                        const priceEl = parent.querySelector('.product-price');
                        const nameEl = parent.querySelector('.product-name');
                        const skuEl = parent.querySelector('.product-sku');
                        const imgEl = parent.querySelector('.product-image');
                        const buyAllEl = parent.querySelector('.product-buy-all');

                        const unitPrice = priceEl ? (parseFloat(priceEl.value) || 0) : 0;
                        const pName = nameEl ? nameEl.value : 'Fragrance';
                        const pSku = skuEl ? skuEl.value : '';
                        const pImg = imgEl ? imgEl.value : '';
                        const buyAll = buyAllEl ? (buyAllEl.value === 'true') : false;
                        const counterIndex = input.getAttribute('data-counter');

                        items += qty;
                        price += (qty * unitPrice);

                        // Render elegant item card details inside checkout drawer/sidebar
                        let qtyControlsHtml = '';
                        if (buyAll) {
                            qtyControlsHtml = `
                                <div class="flex items-center gap-1.5 bg-rose-50 text-rose-600 border border-rose-100 px-2 py-1 rounded-lg">
                                    <span class="text-[8px] font-black uppercase tracking-widest animate-pulse">Clearing Stock</span>
                                </div>
                                <span class="text-xs font-black text-gray-900 tabular-nums">&times; ${qty}</span>
                            `;
                        } else {
                            qtyControlsHtml = `
                                <div class="flex items-center gap-1.5 bg-white border border-gray-100 p-0.5 rounded-lg">
                                    <button type="button" onclick="adjustCartQty(${counterIndex}, false)" class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-black hover:bg-gray-50 transition-all">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    <span class="text-xs font-black text-gray-900 w-6 text-center tabular-nums">${qty}</span>
                                    <button type="button" onclick="adjustCartQty(${counterIndex}, true)" class="w-6 h-6 rounded flex items-center justify-center text-gray-400 hover:text-black hover:bg-gray-50 transition-all">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </div>
                            `;
                        }

                        listHtml += `
                            <div class="py-4 flex flex-col gap-3 group">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                            ${pImg ? `<img src="${pImg}" class="w-full h-full object-cover">` : `
                                                <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            `}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900 line-clamp-1 leading-snug">${pName}</p>
                                            <p class="text-[10px] font-black text-gray-900 mt-1">RM${unitPrice.toFixed(2)}/unit</p>
                                        </div>
                                    </div>
                                    
                                    <button type="button" onclick="removeFromCart(${counterIndex})" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 transition-all" title="Remove Item">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between bg-gray-50/50 rounded-xl p-2 border border-gray-100">
                                    <!-- Sidebar Quantity Controllers -->
                                    ${qtyControlsHtml}
                                    <p class="text-xs font-black text-gray-900 tabular-nums">RM${(qty * unitPrice).toFixed(2)}</p>
                                </div>
                            </div>
                        `;
                    }
                });

                // Update all elements displaying total items count
                const totalItemsEls = document.querySelectorAll('.cart-total-items');
                totalItemsEls.forEach(el => el.textContent = items);

                // Update all badge counts
                const cartBadgeEls = document.querySelectorAll('.cart-badge-count');
                cartBadgeEls.forEach(el => el.textContent = items);
                
                // Update global header shopping cart icon count badge in real-time
                const globalHeaderBadge = document.getElementById('global-header-cart-badge');
                if (globalHeaderBadge) {
                    globalHeaderBadge.textContent = items;
                    if (items > 0) {
                        globalHeaderBadge.classList.remove('hidden');
                    } else {
                        globalHeaderBadge.classList.add('hidden');
                    }
                }
                
                // Update items count labels
                const cartItemsCountTexts = document.querySelectorAll('.cart-items-count-text');
                cartItemsCountTexts.forEach(el => {
                    el.textContent = items === 1 ? '1 Item Selected' : `${items} Items Selected`;
                });
                
                // Update all price elements
                const subtotalStr = 'RM' + price.toLocaleString('en-MY', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                const totalPriceEls = document.querySelectorAll('.cart-total-price');
                totalPriceEls.forEach(el => el.textContent = subtotalStr);
                
                // Update lists
                const cartItemsListEls = document.querySelectorAll('.cart-items-list');
                cartItemsListEls.forEach(el => {
                    el.innerHTML = listHtml || `
                        <div class="py-10 text-center flex flex-col items-center justify-center gap-3">
                            <svg class="w-8 h-8 text-gray-300 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p class="text-xs font-semibold text-gray-400">Your shopping cart is currently empty. Click "Add to Cart" on fragrances to begin purchasing.</p>
                        </div>
                    `;
                });

                // Update MOQ linear progress bar
                const pct = Math.min(100, (items / MIN_ORDER_QTY) * 100);
                const moqProgressBars = document.querySelectorAll('.cart-moq-progress');
                moqProgressBars.forEach(el => {
                    el.style.width = pct + '%';
                });

                const moqWarningEls = document.querySelectorAll('.cart-moq-warning');
                const checkoutButtons = document.querySelectorAll('.cart-checkout-btn');

                if (items >= MIN_ORDER_QTY) {
                    moqWarningEls.forEach(el => {
                        el.innerHTML = `
                            <svg class="w-3 h-3 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-emerald-600 text-[9px] font-bold uppercase tracking-wider">Minimum order requirement met! Ready to purchase.</span>
                        `;
                    });

                    moqProgressBars.forEach(el => {
                        el.classList.remove('from-amber-400', 'to-indigo-500');
                        el.classList.add('bg-emerald-500');
                    });

                    checkoutButtons.forEach(btn => {
                        btn.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        btn.classList.add('bg-black', 'text-white', 'hover:bg-gray-800', 'active:scale-95');
                        btn.disabled = false;
                        btn.textContent = 'Proceed to Checkout';
                    });
                } else {
                    const remaining = MIN_ORDER_QTY - items;
                    moqWarningEls.forEach(el => {
                        el.innerHTML = `
                            <svg class="w-3 h-3 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-amber-600 text-[9px] font-bold uppercase tracking-wider">Add ${remaining} more items to satisfy wholesale MOQ.</span>
                        `;
                    });

                    moqProgressBars.forEach(el => {
                        el.classList.add('from-amber-400', 'to-indigo-500');
                        el.classList.remove('bg-emerald-500');
                    });

                    checkoutButtons.forEach(btn => {
                        btn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        btn.classList.remove('bg-black', 'text-white', 'hover:bg-gray-800', 'active:scale-95');
                        btn.disabled = true;
                        btn.textContent = `Need ${remaining} more`;
                    });
                }

                // Update mobile/tablet floating checkout summary panel elements too
                const floatingTotalPriceEl = document.getElementById('floating-total-price');
                if (floatingTotalPriceEl) floatingTotalPriceEl.textContent = subtotalStr;

                const floatingTotalItemsEl = document.getElementById('floating-total-items');
                if (floatingTotalItemsEl) floatingTotalItemsEl.textContent = items;

                const floatingCartBadgeEl = document.getElementById('floating-cart-badge');
                if (floatingCartBadgeEl) floatingCartBadgeEl.textContent = items;

                const floatingMoqProgress = document.getElementById('floating-moq-progress');
                if (floatingMoqProgress) {
                    floatingMoqProgress.style.width = pct + '%';
                    if (items >= MIN_ORDER_QTY) {
                        floatingMoqProgress.classList.remove('from-amber-400', 'to-indigo-500');
                        floatingMoqProgress.classList.add('bg-emerald-500');
                    } else {
                        floatingMoqProgress.classList.add('from-amber-400', 'to-indigo-500');
                        floatingMoqProgress.classList.remove('bg-emerald-500');
                    }
                }

                const floatingMoqWarningEl = document.getElementById('floating-moq-warning');
                if (floatingMoqWarningEl) {
                    if (items >= MIN_ORDER_QTY) {
                        floatingMoqWarningEl.innerHTML = `
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-emerald-600 font-bold">MOQ requirement met!</span>
                        `;
                    } else {
                        const remaining = MIN_ORDER_QTY - items;
                        floatingMoqWarningEl.innerHTML = `
                            <svg class="w-3.5 h-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-amber-600 font-bold">Need ${remaining} more item${remaining === 1 ? '' : 's'}</span>
                        `;
                    }
                }

                // Sync mobile checkout button state to real form submission state
                const floatingCheckoutBtn = document.getElementById('floating-checkout-btn');
                if (floatingCheckoutBtn) {
                    if (items >= MIN_ORDER_QTY) {
                        floatingCheckoutBtn.classList.remove('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        floatingCheckoutBtn.classList.add('bg-black', 'text-white', 'hover:bg-gray-800', 'active:scale-95');
                        floatingCheckoutBtn.disabled = false;
                        floatingCheckoutBtn.textContent = 'Proceed to Checkout';
                    } else {
                        const remaining = MIN_ORDER_QTY - items;
                        floatingCheckoutBtn.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        floatingCheckoutBtn.classList.remove('bg-black', 'text-white', 'hover:bg-gray-800', 'active:scale-95');
                        floatingCheckoutBtn.disabled = true;
                        floatingCheckoutBtn.textContent = `Need ${remaining} more`;
                    }
                }
            }

            // Initialization loop
            inputs.forEach(input => {
                const counter = input.getAttribute('data-counter');
                syncCardState(counter);
            });
            updateCart();

            // Programmatic click bridging for Proceed Payment from the mobile floating bar
            if (floatingCheckoutBtn) {
                floatingCheckoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!floatingCheckoutBtn.disabled) {
                        const realBtn = document.querySelector('.cart-checkout-btn:not([disabled])');
                        if (realBtn) {
                            realBtn.click();
                        }
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCartEngine);
        } else {
            initializeCartEngine();
        }
    </script>
</x-app-layout>
