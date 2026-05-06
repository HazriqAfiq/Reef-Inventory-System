<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $isNew = $product->release_date && $product->release_date >= now()->subMonths(2);
    $isHot = $product->sales_sum_quantity && $product->sales_sum_quantity > 5;
    
    $lowStockThreshold = 15;

    
    $totalStock = $product->variants->sum('stock');
    $isLowStock = $totalStock > 0 && $totalStock <= $lowStockThreshold;
    $isOutOfStock = $totalStock <= 0;
?>

<a href="<?php echo e(route('storefront.show', $product->slug)); ?>" 
   x-data="{ 
        adding: false, 
        added: false,
        async quickAdd(id) {
            if (this.adding || this.added) return;
            this.adding = true;
            try {
                const response = await fetch('<?php echo e(route('cart.add')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: id, quantity: 1 })
                });
                const data = await response.json();
                if (data.success) {
                    this.added = true;
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
                    setTimeout(() => this.added = false, 2000);
                }
            } finally { this.adding = false; }
        }
   }"
   class="group block transition-transform duration-700 hover:-translate-y-2 <?php echo e($isOutOfStock ? 'opacity-50 grayscale' : ''); ?>">

    <!-- IMAGE -->
    <div class="relative bg-gray-50 mb-3 overflow-hidden rounded-[2rem] border border-transparent group-hover:border-gray-100 shadow-[0_15px_40px_rgba(0,0,0,0.02)] group-hover:shadow-[0_30px_60px_rgba(0,0,0,0.06)] transition-all duration-700" style="aspect-ratio: 1/1;">
        
        <?php if($isOutOfStock): ?>
            <div class="absolute inset-0 bg-black/40 z-[15] pointer-events-none"></div>
        <?php endif; ?>

        <!-- BADGES -->
        <div class="absolute top-5 left-5 z-10 flex flex-col gap-2 text-left">
            <?php if($isNew): ?>
                <span class="bg-black text-white text-[9px] font-black uppercase tracking-[0.3em] px-3 py-1 rounded-full shadow-xl shadow-black/20 border border-white/10">New</span>
            <?php endif; ?>
            <?php if($isHot): ?>
                <span class="bg-white text-black text-[9px] font-black uppercase tracking-[0.3em] px-3 py-1 rounded-full shadow-md border border-black/5">Hot</span>
            <?php endif; ?>
        </div>

        <?php
            $currentUser = auth()->user();
            $effectiveBadge = $product->isPromotionActive(null, $currentUser) ? $product->effective_promotion_badge : null;
        ?>

        <?php if($effectiveBadge): ?>
            <div class="absolute top-5 right-5 z-10">
                <span class="<?php echo e($product->promotion_badge_color ?? 'bg-yellow-500'); ?> <?php echo e(str_contains($product->promotion_badge_color ?? 'yellow', 'yellow') ? 'text-black' : 'text-white'); ?> text-[9px] font-black uppercase tracking-[0.3em] px-4 py-1.5 rounded-full shadow-xl border border-black/5">
                    <?php echo e($effectiveBadge); ?>

                </span>
            </div>
        <?php endif; ?>

        <!-- WISHLIST -->
        <div class="absolute z-10" 
             :class="<?php echo e($product->promotion_badge ? 'true' : 'false'); ?> ? 'top-16 right-5' : 'top-5 right-5'"
             x-data="{ 
                wishlisted: <?php echo e(Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists() ? 'true' : 'false'); ?>,
                async toggleWishlist(id) {
                    <?php if(auth()->guard()->guest()): ?>
                        window.location.href = '<?php echo e(route('login')); ?>';
                        return;
                    <?php endif; ?>
                    const response = await fetch(`/account/wishlist/toggle/${id}`, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' }
                    });
                    const data = await response.json();
                    if (data.success) {
                        this.wishlisted = (data.status === 'added');
                    }
                }
             }">
            <button @click.prevent.stop="toggleWishlist(<?php echo e($product->id); ?>)" 
                    class="w-10 h-10 bg-white/80 backdrop-blur-md rounded-full shadow-sm flex items-center justify-center hover:bg-white hover:scale-110 transition-all duration-300">
                <svg class="w-4 h-4 transition-colors"
                     :class="wishlisted ? 'text-red-500 fill-current' : 'text-gray-400'"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </button>
        </div>

        <!-- IMAGE -->
        <div class="w-full h-full p-0">
            <img src="<?php echo e($product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://placehold.co/600x600?text=' . urlencode($product->name)); ?>" 
                 class="w-full h-full object-cover transition-transform duration-1000"
                 alt="<?php echo e($product->name); ?>">
        </div>

        <!-- QUICK ADD -->
        <div class="absolute inset-x-0 bottom-0 p-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 z-20 hidden lg:block">
            <?php
                $totalStock = $product->variants->sum('stock');
            ?>
            <button @click.prevent.stop="quickAdd(<?php echo e($product->id); ?>)" 
                    :disabled="adding || added || <?php echo e($totalStock <= 0 ? 'true' : 'false'); ?>"
                    class="w-full bg-black/90 backdrop-blur-md text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] 
                           flex items-center justify-center gap-3 hover:bg-black transition-colors disabled:bg-gray-400/80">

                <template x-if="adding">
                    <svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle><path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                </template>

                <span x-text="added ? 'ADDED ✓' : (adding ? 'ADDING...' : (<?php echo e($totalStock > 0 ? 'true' : 'false'); ?> ? 'ADD TO CART' : 'OUT OF STOCK'))"></span>
            </button>
        </div>
    </div>

    <!-- INFO -->
    <div class="px-1 text-center flex flex-col items-center">

        <!-- TITLE -->
        <h4 class="text-[13px] font-medium text-gray-900 mb-2 uppercase tracking-[0.2em] leading-tight group-hover:text-gray-500 transition">
            <?php echo e($product->name); ?>

        </h4>

        <!-- CATEGORY -->
        <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-2">
            <?php echo e($product->category?->name ?? ''); ?>

        </p>

        <!-- NOTES -->
        <p class="text-[9px] font-medium text-gray-400 uppercase tracking-[0.2em] mb-3 line-clamp-1">
            <?php echo e(collect([$product->top_note, $product->heart_note, $product->base_note])->filter()->join(' · ') ?: ($product->volume_ml ? $product->volume_ml . 'ml' : 'Signature Scent')); ?>

        </p>

        <!-- RATING -->
        <?php if($product->average_rating > 0): ?>
            <div class="flex items-center gap-1 mb-4">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <svg class="w-3 h-3 <?php echo e($i <= round($product->average_rating) ? 'text-black' : 'text-gray-100'); ?>" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c..."/>
                    </svg>
                <?php endfor; ?>
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">
                    (<?php echo e($product->review_count); ?>)
                </span>
            </div>
        <?php endif; ?>

        <!-- PRICE -->
        <div class="flex flex-col items-center gap-1">

            <?php if($product->isPromotionActive() && $product->promotion_type === 'discount_percent'): ?>
                <div class="flex items-center gap-2">
                    <p class="text-[11px] font-medium text-gray-400 line-through">
                        RM <?php echo e(number_format($product->retail_price, 2)); ?>

                    </p>
                    <p class="text-[12px] font-bold text-black">
                        RM <?php echo e(number_format($product->discounted_price, 2)); ?>

                    </p>
                </div>
            <?php else: ?>
                <p class="text-[12px] font-medium text-black">
                    RM <?php echo e(number_format($product->retail_price, 2)); ?>

                </p>
            <?php endif; ?>



        </div>

    </div>

</a><?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/components/product-card.blade.php ENDPATH**/ ?>