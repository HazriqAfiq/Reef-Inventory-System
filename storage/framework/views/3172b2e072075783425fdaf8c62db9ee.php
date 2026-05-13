<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($product->name).' - Wholesale Profile']); ?>
    <!-- Premium Minimalist Scrollbar Styles -->
    <style>
        .cart-items-list::-webkit-scrollbar {
            width: 4px;
        }
        .cart-items-list::-webkit-scrollbar-track {
            background: transparent;
        }
        .cart-items-list::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 9999px;
        }
        .cart-items-list::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>

    <!-- Wrapper with local cartOpen state for Responsive Drawer -->
    <div x-data="{ cartOpen: false }" @open-cart.window="cartOpen = true" class="relative">
        
        <!-- Main Form wrapper submitting to checkout -->
        <form action="<?php echo e(route('reseller.orders.store')); ?>" method="POST" id="restock-form" class="relative">
            <?php echo csrf_field(); ?>

            <!-- Hidden inputs for ALL products to preserve the full cart state in form submission -->
            <?php $__currentLoopData = $allProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $pEffectiveMoq = $p->stock < $productMoq ? $p->stock : $productMoq;
                    $pIsLowStock = $p->stock < $productMoq;
                    $pCounter = $loop->index;
                ?>
                <div class="product-metadata-node hidden">
                    <input type="hidden" class="product-id" value="<?php echo e($p->id); ?>">
                    <input type="hidden" class="product-price" value="<?php echo e($p->wholesale_price); ?>">
                    <input type="hidden" class="product-name" value="<?php echo e($p->name); ?>">
                    <input type="hidden" class="product-sku" value="<?php echo e($p->sku); ?>">
                    <input type="hidden" class="product-image" value="<?php echo e($p->primaryImage ? asset('storage/' . $p->primaryImage->image_path) : ''); ?>">
                    <input type="hidden" class="product-max" value="<?php echo e($p->stock); ?>">
                    <input type="hidden" class="product-effective-moq" value="<?php echo e($pEffectiveMoq); ?>">
                    <input type="hidden" class="product-buy-all" value="<?php echo e($pIsLowStock ? 'true' : 'false'); ?>">
                    
                    <input type="number" 
                           name="quantity[<?php echo e($pCounter); ?>]" 
                           class="qty-input" 
                           data-counter="<?php echo e($pCounter); ?>"
                           value="<?php echo e($cartItems[$p->id] ?? 0); ?>" 
                           min="0" 
                           max="<?php echo e($p->stock); ?>"
                           onchange="validateInput(<?php echo e($pCounter); ?>)"
                           <?php echo e($p->stock === 0 ? 'disabled' : ''); ?>

                           <?php echo e($pIsLowStock ? 'readonly' : ''); ?>>
                            
                    <input type="hidden" name="product_id[<?php echo e($pCounter); ?>]" value="<?php echo e($p->id); ?>">
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Back Navigation -->
            <div class="mb-6">
                <a href="<?php echo e(route('reseller.orders.create')); ?>"
                   class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black transition-colors uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Restock HQ
                </a>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-6 p-5 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-4 animate-fade-in-up">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-rose-600 shadow-sm border border-rose-100 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-rose-900 uppercase tracking-widest text-[10px]">Restocking errors detected</h3>
                        <ul class="mt-1 text-xs text-rose-600 font-medium space-y-1 pl-4 list-disc">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="uppercase tracking-wider text-[9px] font-bold"><?php echo e($err); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Workspace Layout (Desktop: Side-by-side spec-sheet and static cart, Mobile: stacked) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Breadcrumbs and Product Details -->
                <div class="lg:col-span-8 xl:col-span-9 space-y-6">
                    
                    <!-- Page Breadcrumbs -->
                    <nav class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">
                        <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-black transition-colors">Dashboard</a>
                        <span>/</span>
                        <a href="<?php echo e(route('reseller.orders.create')); ?>" class="hover:text-black transition-colors">Restock HQ</a>
                        <span>/</span>
                        <span class="text-gray-900"><?php echo e($product->name); ?></span>
                    </nav>

                    <!-- Large specs spec-sheet panel -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-8 lg:p-12">
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                            
                            <!-- Gallery Column (md:col-span-5) -->
                            <div class="md:col-span-5 flex flex-col gap-6"
                                 x-data="{ activeImage: '<?php echo e($product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1974&auto=format&fit=crop'); ?>' }">
                                
                                <div class="aspect-[4/5] bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden relative group shadow-sm">
                                    <img :src="activeImage" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                         alt="<?php echo e($product->name); ?>">
                                    
                                    <!-- Warehouse Stock Pill -->
                                    <div class="absolute top-4 left-4 z-10">
                                        <?php if($product->stock === 0): ?>
                                            <span class="px-3 py-1.5 bg-rose-500/90 backdrop-blur-md border border-rose-400 text-[9px] font-black uppercase tracking-widest text-white rounded-lg shadow-sm">
                                                Sold Out
                                            </span>
                                        <?php elseif($product->stock < $productMoq): ?>
                                            <span class="px-3 py-1.5 bg-amber-500/90 backdrop-blur-md border border-amber-400 text-[9px] font-black uppercase tracking-widest text-white rounded-lg shadow-sm">
                                                Clear Stock (<?php echo e($product->stock); ?> Left)
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1.5 bg-emerald-500/90 backdrop-blur-md border border-emerald-400 text-[9px] font-black uppercase tracking-widest text-white rounded-lg shadow-sm">
                                                In Stock (<?php echo e($product->stock); ?>)
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Gallery mini-thumbnails -->
                                <?php if($product->images->count() > 1): ?>
                                    <div class="grid grid-cols-4 gap-3">
                                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $imgPath = asset('storage/' . $img->image_path); ?>
                                            <button type="button" 
                                                    @click="activeImage = '<?php echo e($imgPath); ?>'"
                                                    class="aspect-square bg-gray-50 border rounded-xl overflow-hidden transition-all duration-300 relative group"
                                                    :class="activeImage === '<?php echo e($imgPath); ?>' ? 'border-black ring-2 ring-black/10' : 'border-gray-100 hover:border-gray-400'">
                                                <img src="<?php echo e($imgPath); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            </button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Details Column (md:col-span-7) -->
                            <div class="md:col-span-7 flex flex-col justify-between">
                                <div class="space-y-8">
                                    
                                    <!-- Title Row -->
                                    <div class="space-y-4">
                                        <!-- Category / Type Tags -->
                                        <div class="flex flex-wrap items-center gap-2">
                                            <?php if($product->volume_ml): ?>
                                                <span class="px-3 py-1 bg-black text-white text-[9px] font-black uppercase tracking-widest rounded-md">
                                                    <?php echo e($product->volume_ml); ?>ML
                                                </span>
                                            <?php endif; ?>
                                            <?php if($product->category): ?>
                                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-gray-200">
                                                    <?php echo e($product->category->name); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if($product->productType): ?>
                                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-indigo-100">
                                                    <?php echo e($product->productType->name); ?>

                                                </span>
                                            <?php endif; ?>
                                            <?php if(!$product->is_active): ?>
                                                <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black uppercase tracking-widest rounded-md border border-rose-100">
                                                    Unlisted
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div>
                                            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 tracking-tight leading-tight"><?php echo e($product->name); ?></h1>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-2">Product Code: <span class="text-gray-900 font-black font-mono"><?php echo e($product->sku); ?></span></p>
                                        </div>
                                    </div>

                                    <!-- Price Spec Table -->
                                    <div class="bg-gradient-to-br from-gray-50 to-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                                        <div class="grid grid-cols-3 divide-x divide-gray-100">
                                            
                                            <!-- Wholesale Price -->
                                            <div class="p-5 space-y-1">
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Wholesale</p>
                                                <p class="text-xl font-black text-gray-900 tracking-tight tabular-nums">RM<?php echo e(number_format($product->wholesale_price, 2)); ?></p>
                                                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wider">Your Cost / Unit</p>
                                            </div>

                                            <!-- Retail Price -->
                                            <div class="p-5 space-y-1">
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Retail (RSP)</p>
                                                <p class="text-xl font-black text-gray-900 tracking-tight tabular-nums">RM<?php echo e(number_format($product->retail_price, 2)); ?></p>
                                                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-wider">Suggested Sell Price</p>
                                            </div>

                                            <!-- Profit Margin -->
                                            <div class="p-5 space-y-1 bg-emerald-50/60">
                                                <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest leading-none">Profit / Unit</p>
                                                <p class="text-xl font-black text-emerald-700 tracking-tight tabular-nums">+RM<?php echo e(number_format($profit, 2)); ?></p>
                                                <p class="text-[8px] font-black text-emerald-600 uppercase tracking-wider"><?php echo e($margin); ?>% ROI Margin</p>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Olfactory Pyramid Notes -->
                                    <div class="space-y-3">
                                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                            <span class="flex-1 h-px bg-gray-100"></span>
                                            Olfactory Profile
                                            <span class="flex-1 h-px bg-gray-100"></span>
                                        </h3>
                                        
                                        <div class="grid grid-cols-3 gap-3">
                                            <!-- Top Note -->
                                            <div class="p-4 bg-white border border-gray-100 rounded-xl space-y-2 shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-sky-400 shrink-0"></span>
                                                    <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Top Note</span>
                                                </div>
                                                <p class="text-xs font-bold text-gray-900 leading-snug"><?php echo e($product->top_note ?: '—'); ?></p>
                                                <p class="text-[8px] text-gray-400">Opens first · 15–30 min</p>
                                            </div>
                                            
                                            <!-- Heart Note -->
                                            <div class="p-4 bg-white border border-gray-100 rounded-xl space-y-2 shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-rose-400 shrink-0"></span>
                                                    <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Heart Note</span>
                                                </div>
                                                <p class="text-xs font-bold text-gray-900 leading-snug"><?php echo e($product->heart_note ?: '—'); ?></p>
                                                <p class="text-[8px] text-gray-400">Character · 2–4 hrs</p>
                                            </div>

                                            <!-- Base Note -->
                                            <div class="p-4 bg-white border border-gray-100 rounded-xl space-y-2 shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex items-center gap-1.5">
                                                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                                    <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Base Note</span>
                                                </div>
                                                <p class="text-xs font-bold text-gray-900 leading-snug"><?php echo e($product->base_note ?: '—'); ?></p>
                                                <p class="text-[8px] text-gray-400">Foundation · 6+ hrs</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stock Availability Strip -->
                                    <div class="flex items-center gap-4 px-5 py-3.5 bg-gray-50 border border-gray-100 rounded-xl">
                                        <div class="flex items-center gap-2 flex-1">
                                            <div class="w-2 h-2 rounded-full <?php echo e($product->stock === 0 ? 'bg-rose-500' : ($product->stock < $productMoq ? 'bg-amber-500' : 'bg-emerald-500')); ?>"></div>
                                            <span class="text-[10px] font-black text-gray-900 uppercase tracking-wider">
                                                <?php if($product->stock === 0): ?> Out of Stock
                                                <?php elseif($product->stock < $productMoq): ?> Limited — <?php echo e($product->stock); ?> units remaining
                                                <?php else: ?> Available — <?php echo e($product->stock); ?> units in warehouse
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-wider shrink-0">Min. Order: <?php echo e($productMoq); ?> units</span>
                                    </div>

                                </div>

                                <!-- Dynamic cart operations matching inputs node indexes -->
                                <?php
                                    $effectiveMoq = $product->stock < $productMoq ? $product->stock : $productMoq;
                                    $isLowStock = $product->stock < $productMoq;
                                    $loopIndex = $allProducts->search(fn($p) => $p->id === $product->id);
                                ?>

                                <div class="pt-10 mt-10 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-end gap-6">

                                    <div class="flex items-center gap-4">
                                        <?php if($product->stock === 0): ?>
                                            <button type="button" disabled class="px-8 py-3.5 bg-gray-100 text-gray-400 text-[10px] font-bold uppercase tracking-widest rounded-xl cursor-not-allowed">
                                                Out of Stock
                                            </button>
                                        <?php else: ?>
                                            <div class="relative flex items-center justify-end product-metadata-node">
                                                <!-- Same metadata fields so that adjustQty target references map correctly -->
                                                <input type="hidden" class="product-id" value="<?php echo e($product->id); ?>">
                                                <input type="hidden" class="product-price" value="<?php echo e($product->wholesale_price); ?>">
                                                <input type="hidden" class="product-name" value="<?php echo e($product->name); ?>">
                                                <input type="hidden" class="product-sku" value="<?php echo e($product->sku); ?>">
                                                <input type="hidden" class="product-image" value="<?php echo e($product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : ''); ?>">
                                                <input type="hidden" class="product-max" value="<?php echo e($product->stock); ?>">
                                                <input type="hidden" class="product-effective-moq" value="<?php echo e($effectiveMoq); ?>">
                                                <input type="hidden" class="product-buy-all" value="<?php echo e($isLowStock ? 'true' : 'false'); ?>">

                                                <!-- State 1: Sleek "Add to Cart" Button -->
                                                <button type="button" 
                                                        class="add-to-cart-btn px-8 py-3.5 bg-black hover:bg-gray-800 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all shadow-md active:scale-95 flex items-center gap-2"
                                                        data-counter="<?php echo e($loopIndex); ?>"
                                                        onclick="addToCartAction(<?php echo e($loopIndex); ?>)">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                    <span>Add To Cart</span>
                                                </button>

                                                <!-- State 2: Active Quantity Selector widget -->
                                                <div class="qty-counter-widget hidden items-center gap-1.5 bg-gray-50 border border-gray-100 p-1.5 rounded-xl">
                                                    <!-- Decrement / Trash Selector -->
                                                    <button type="button" 
                                                            class="qty-btn minus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-100 text-gray-400 hover:text-black hover:border-black transition-all shadow-sm"
                                                            onclick="adjustQty(<?php echo e($loopIndex); ?>, false)">
                                                        <?php if($isLowStock): ?>
                                                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        <?php else: ?>
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/>
                                                            </svg>
                                                        <?php endif; ?>
                                                    </button>
                                                    
                                                    <!-- Active widget counter display -->
                                                    <span class="qty-display-detail w-8 text-center text-xs font-black text-gray-900 tabular-nums <?php echo e($isLowStock ? 'text-rose-600 bg-rose-50/50 rounded py-1 px-1.5' : ''); ?>">
                                                        0
                                                    </span>

                                                    <!-- Increment Button -->
                                                    <button type="button" 
                                                            class="qty-btn plus w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-100 text-gray-400 hover:text-black hover:border-black transition-all shadow-sm <?php echo e($isLowStock ? 'hidden' : ''); ?>"
                                                            onclick="adjustQty(<?php echo e($loopIndex); ?>, true)">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Product Heritage / Description -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-4 border-b border-gray-50 bg-gray-50/20">
                            <h2 class="text-[10px] font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-gray-900"></span>
                                Product Heritage
                            </h2>
                            <p class="text-[9px] text-gray-400 uppercase tracking-wider mt-0.5">Formulation narrative and olfactory character</p>
                        </div>
                        <div class="p-8">
                            <p class="text-sm font-medium text-gray-500 leading-relaxed max-w-3xl">
                                <?php echo e($product->description ?: 'An exquisite formulation handcrafted to represent luxury. Handcrafted with organic base elements that diffuse beautifully across the skin, leaving a persistent trail of elegance.'); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Static Wholesale Cart Sidebar (Desktop only) -->
                <div class="hidden lg:flex lg:fixed bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex-col gap-4 h-[calc(100vh-10rem)] w-[260px] xl:w-[320px] lg:right-8 xl:right-12 lg:top-28 overflow-hidden z-20">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 shrink-0">
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
                    <div class="cart-items-list space-y-2 max-h-[calc(100vh-25rem)] overflow-y-auto pr-3 py-2 divide-y divide-gray-100 shrink">
                        <!-- Populated in real-time via JS -->
                    </div>

                    <!-- Progress and MOQ Tracker Indicator -->
                    <div class="border-t border-gray-100 pt-3 space-y-3 shrink-0 mt-auto">
                        <div class="flex justify-between items-baseline">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">MOQ Progress (<?php echo e($totalMoq); ?> Min)</p>
                            <p class="text-xs font-black text-gray-900 tabular-nums"><span class="cart-total-items text-sm font-black">0</span> / <?php echo e($totalMoq); ?></p>
                        </div>
                        <!-- Progress Line Bar -->
                        <div class="w-full bg-gray-50 h-2 rounded-full overflow-hidden shadow-inner relative">
                            <div class="cart-moq-progress h-full bg-gradient-to-r from-amber-400 to-indigo-500 rounded-full transition-all duration-500 w-0"></div>
                        </div>
                        <div class="cart-moq-warning text-[9px] font-bold text-rose-500 uppercase tracking-wider flex items-center gap-1.5 leading-tight">
                            <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>Wholesale orders require a minimum of <?php echo e($totalMoq); ?> items.</span>
                        </div>
                    </div>

                    <!-- Subtotal and Submit -->
                    <div class="border-t border-gray-100 pt-3 space-y-4 shrink-0">
                        <div class="flex items-center justify-between">
                            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Total Price</span>
                            <span class="cart-total-price text-xl font-black text-gray-900 tabular-nums">RM0.00</span>
                        </div>
                        <button type="submit" 
                                class="cart-checkout-btn w-full py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center"
                                disabled>
                            Need <?php echo e($totalMoq); ?> Items
                        </button>
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
                                <button type="button" x-on:click="cartOpen = false" class="text-gray-400 hover:text-black">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Scrollable Selected Items List -->
                        <div id="cart-items-list" class="cart-items-list space-y-4 max-h-[380px] overflow-y-auto pr-3 py-2 divide-y divide-gray-50">
                            <!-- Populated in real-time via JS -->
                        </div>

                        <!-- Progress and MOQ Tracker Indicator -->
                        <div class="border-t border-gray-100 pt-5 space-y-3">
                            <div class="flex justify-between items-baseline">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">MOQ Progress (<?php echo e($totalMoq); ?> Min)</p>
                                <p class="text-xs font-black text-gray-900 tabular-nums"><span id="total-items" class="cart-total-items text-sm font-black">0</span> / <?php echo e($totalMoq); ?></p>
                            </div>
                            <div class="w-full h-2 bg-gray-50 rounded-full overflow-hidden shadow-inner relative">
                                <div id="moq-progress" class="cart-moq-progress h-full bg-gradient-to-r from-amber-400 to-indigo-500 rounded-full transition-all duration-500 w-0"></div>
                            </div>
                            <p id="moq-warning" class="cart-moq-warning text-[9px] font-bold text-amber-500 uppercase tracking-wider flex items-center gap-1.5 leading-tight">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <span>Wholesale orders require a minimum of <?php echo e($totalMoq); ?> items.</span>
                            </p>
                        </div>

                        <!-- Checkout Summary -->
                        <div class="border-t border-gray-100 pt-5 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Wholesale Subtotal</span>
                                <span id="total-price" class="cart-total-price text-xl font-black text-gray-900 tracking-tight tabular-nums">RM0.00</span>
                            </div>
                            
                            <button type="submit" 
                                    id="checkout-btn" 
                                    disabled 
                                    class="cart-checkout-btn w-full py-4 bg-gray-100 text-gray-400 font-bold text-xs uppercase tracking-widest rounded-xl transition-all duration-300 cursor-not-allowed text-center">
                                Need <?php echo e($totalMoq); ?> Items
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>

        <!-- Premium Floating Cart Bag Button (Mobile Only) -->
        <div class="fixed bottom-6 right-6 z-30 lg:hidden">
            <button type="button" 
                    onclick="window.dispatchEvent(new CustomEvent('open-cart'))"
                    class="relative flex items-center justify-center w-14 h-14 bg-black text-white hover:bg-gray-900 rounded-full active:scale-95 transition-all shadow-2xl focus:outline-none"
                    title="View Cart">
                <svg class="w-6 h-6 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span id="floating-cart-badge" class="hidden absolute -top-1 -right-1 bg-rose-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-md pointer-events-none">0</span>
            </button>
        </div>

    </div>

    <!-- E-Commerce Bidirectional Real-Time Cart Syncer Script -->
    <script>
        function initializeProductDetailCartEngine() {
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

            const MIN_ORDER_QTY = <?php echo e($totalMoq); ?>;
            const MIN_PRODUCT_QTY = <?php echo e($productMoq); ?>;

            // Bidirectional State Synchronizer
            window.syncCardState = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const val = parseInt(input.value) || 0;
                // Query container
                const parentContainers = document.querySelectorAll('.product-metadata-node');
                
                // Track matching nodes across both hidden lists and visible specs panel
                let currentProductId = '';
                parentContainers.forEach(container => {
                    const inputNode = container.querySelector(`.qty-input[data-counter="${counter}"]`);
                    if (inputNode) {
                        const pidNode = container.querySelector('.product-id');
                        if (pidNode) currentProductId = pidNode.value;
                    }
                });

                // Update widgets anywhere on the page matching this product ID
                const activeCardContainers = document.querySelectorAll(`.product-metadata-node`);
                activeCardContainers.forEach(container => {
                    const pidEl = container.querySelector('.product-id');
                    if (pidEl && pidEl.value === currentProductId) {
                        const inputNode = container.querySelector(`.qty-input`);
                        if (inputNode) {
                            inputNode.value = val; // keep inputs in lockstep
                        }

                        const addToCartBtn = container.querySelector('.add-to-cart-btn');
                        const qtyWidget = container.querySelector('.qty-counter-widget');
                        const qtyDisplay = container.querySelector('.qty-display-detail');

                        if (qtyDisplay) {
                            qtyDisplay.textContent = val;
                        }

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
                    }
                });
            };

            // Sync quantity selection to database via AJAX
            function syncCartToDatabase(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const parentContainers = document.querySelectorAll('.product-metadata-node');
                let productId = '';
                parentContainers.forEach(container => {
                    const inputNode = container.querySelector(`.qty-input[data-counter="${counter}"]`);
                    if (inputNode) {
                        const pidNode = container.querySelector('.product-id');
                        if (pidNode) productId = pidNode.value;
                    }
                });

                if (!productId) return;
                const quantity = parseInt(input.value) || 0;

                fetch("<?php echo e(route('reseller.cart.update')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
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

            // Add To Cart Click trigger
            window.addToCartAction = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const parentContainers = document.querySelectorAll('.product-metadata-node');
                let max = 0;
                let effectiveMoq = MIN_PRODUCT_QTY;

                parentContainers.forEach(container => {
                    const inputNode = container.querySelector(`.qty-input[data-counter="${counter}"]`);
                    if (inputNode) {
                        const maxEl = container.querySelector('.product-max');
                        const moqEl = container.querySelector('.product-effective-moq');
                        const maxVal = maxEl ? (parseInt(maxEl.value) || 0) : 0;
                        const moqVal = moqEl ? (parseInt(moqEl.value) || MIN_PRODUCT_QTY) : MIN_PRODUCT_QTY;
                        max = maxVal;
                        effectiveMoq = moqVal;
                    }
                });

                if (max <= 0) return;

                input.value = Math.min(max, effectiveMoq);
                
                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

            // Plus/Minus adjusters
            window.adjustQty = function(counter, isPlus) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const parentContainers = document.querySelectorAll('.product-metadata-node');
                let max = 0;
                let effectiveMoq = MIN_PRODUCT_QTY;
                let buyAll = false;

                parentContainers.forEach(container => {
                    const inputNode = container.querySelector(`.qty-input[data-counter="${counter}"]`);
                    if (inputNode) {
                        const maxEl = container.querySelector('.product-max');
                        const moqEl = container.querySelector('.product-effective-moq');
                        const buyAllEl = container.querySelector('.product-buy-all');
                        max = maxEl ? (parseInt(maxEl.value) || 0) : 0;
                        effectiveMoq = moqEl ? (parseInt(moqEl.value) || MIN_PRODUCT_QTY) : MIN_PRODUCT_QTY;
                        buyAll = buyAllEl ? (buyAllEl.value === 'true') : false;
                    }
                });

                let val = parseInt(input.value) || 0;

                if (buyAll) {
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

            // Direct keyboards validation
            window.validateInput = function(counter) {
                const input = document.querySelector(`.qty-input[data-counter="${counter}"]`);
                if (!input) return;

                const parentContainers = document.querySelectorAll('.product-metadata-node');
                let max = 0;
                let effectiveMoq = MIN_PRODUCT_QTY;
                let buyAll = false;

                parentContainers.forEach(container => {
                    const inputNode = container.querySelector(`.qty-input[data-counter="${counter}"]`);
                    if (inputNode) {
                        const maxEl = container.querySelector('.product-max');
                        const moqEl = container.querySelector('.product-effective-moq');
                        const buyAllEl = container.querySelector('.product-buy-all');
                        max = maxEl ? (parseInt(maxEl.value) || 0) : 0;
                        effectiveMoq = moqEl ? (parseInt(moqEl.value) || MIN_PRODUCT_QTY) : MIN_PRODUCT_QTY;
                        buyAll = buyAllEl ? (buyAllEl.value === 'true') : false;
                    }
                });

                let val = parseInt(input.value) || 0;

                if (buyAll) {
                    if (val > 0) {
                        input.value = effectiveMoq;
                    } else {
                        input.value = 0;
                    }
                } else {
                    if (val < 0) {
                        input.value = 0;
                    } else if (val > max) {
                        input.value = max;
                    } else if (val > 0 && val < effectiveMoq) {
                        input.value = Math.min(max, effectiveMoq);
                    }
                }

                syncCardState(counter);
                updateCart();
                syncCartToDatabase(counter);
            };

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

                // Capture mapping values (unique per product ID)
                const processedProductIds = new Set();

                inputs.forEach(input => {
                    const qty = parseInt(input.value) || 0;
                    const counterIndex = input.getAttribute('data-counter');
                    
                    // Locate specs
                    const parentContainers = document.querySelectorAll('.product-metadata-node');
                    let pId = '', unitPrice = 0, pName = '', pVolume = '', pSku = '', pImg = '', buyAll = false;

                    parentContainers.forEach(container => {
                        const inputNode = container.querySelector(`.qty-input[data-counter="${counterIndex}"]`);
                        if (inputNode) {
                            const idNode = container.querySelector('.product-id');
                            const priceNode = container.querySelector('.product-price');
                            const nameNode = container.querySelector('.product-name');
                            const volumeNode = container.querySelector('.product-volume');
                            const skuNode = container.querySelector('.product-sku');
                            const imgNode = container.querySelector('.product-image');
                            const buyAllNode = container.querySelector('.product-buy-all');

                            pId = idNode ? idNode.value : '';
                            unitPrice = priceNode ? (parseFloat(priceNode.value) || 0) : 0;
                            pName = nameNode ? nameNode.value : 'Fragrance';
                            pVolume = volumeNode ? volumeNode.value : '';
                            pSku = skuNode ? skuNode.value : '';
                            pImg = imgNode ? imgNode.value : '';
                            buyAll = buyAllNode ? (buyAllNode.value === 'true') : false;
                        }
                    });

                    if (qty > 0 && pId && !processedProductIds.has(pId)) {
                        processedProductIds.add(pId);
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
                            <div class="py-2 flex flex-col gap-2 group">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                            ${pImg ? `<img src="${pImg}" class="w-full h-full object-cover">` : `
                                                <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                                </svg>
                                            `}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900 line-clamp-1 leading-snug">${pName}${pVolume ? ` (${pVolume}ML)` : ''}</p>
                                            <p class="text-[10px] font-black text-gray-900 mt-1">RM${unitPrice.toFixed(2)}/unit</p>
                                        </div>
                                    </div>
                                    
                                    <button type="button" onclick="removeFromCart(${counterIndex})" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 transition-all" title="Remove Item">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142M5 7h14l1 12H4L5 9z"/>
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
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <p class="text-[11px] font-bold text-gray-400">Your shopping cart is currently empty.</p>
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
                            <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
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
                            <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span class="text-amber-600 font-bold">Add ${remaining} more items to satisfy wholesale MOQ.</span>
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
                if (floatingCartBadgeEl) {
                    floatingCartBadgeEl.textContent = items;
                    if (items > 0) {
                        floatingCartBadgeEl.classList.remove('hidden');
                    } else {
                        floatingCartBadgeEl.classList.add('hidden');
                    }
                }

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

            // Page Boot Initialization
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
            document.addEventListener('DOMContentLoaded', initializeProductDetailCartEngine);
        } else {
            initializeProductDetailCartEngine();
        }
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/products/show.blade.php ENDPATH**/ ?>