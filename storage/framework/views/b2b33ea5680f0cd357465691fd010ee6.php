<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['target' => null, 'click' => null]));

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

foreach (array_filter((['target' => null, 'click' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $clickHandler = $click ?? ($target ? "document.getElementById('$target').scrollIntoView({ behavior: 'smooth' })" : "window.scrollTo({ top: window.innerHeight, behavior: 'smooth' })");
?>

<div <?php echo e($attributes->merge(['class' => 'absolute bottom-12 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-4 text-white/30 cursor-pointer'])); ?> 
     @click="<?php echo $clickHandler; ?>">
    <div class="w-px h-16 bg-white/20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1/2 bg-white animate-[scroll-down_2s_infinite]"></div>
    </div>
</div>
<?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/components/scroll-indicator.blade.php ENDPATH**/ ?>