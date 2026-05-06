<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'checked' => false, 'label' => null, 'description' => null]));

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

foreach (array_filter((['name', 'checked' => false, 'label' => null, 'description' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex items-center justify-between" x-data="{ checked: <?php echo e($checked ? 'true' : 'false'); ?> }">
    <?php if($label || $description): ?>
        <div>
            <?php if($label): ?>
                <label class="block text-sm font-black text-gray-800 capitalize"><?php echo e($label); ?></label>
            <?php endif; ?>
            <?php if($description): ?>
                <p class="text-[11px] text-gray-500 mt-0.5"><?php echo e($description); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="flex items-center">
        <!-- Horizontal Switch -->
        <button type="button" 
                @click="checked = !checked"
                :class="checked ? 'bg-black' : 'bg-gray-200'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
            <span class="sr-only">Toggle <?php echo e($label ?? $name); ?></span>
            <span :class="checked ? 'translate-x-5' : 'translate-x-0'"
                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
        </button>
        <!-- Hidden actual input for form submission -->
        <input type="hidden" name="<?php echo e($name); ?>" :value="checked ? '1' : '0'">
    </div>
</div>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/components/toggle.blade.php ENDPATH**/ ?>