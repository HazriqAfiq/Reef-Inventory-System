<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'value' => null, 'label' => null, 'aspectRatio' => 'aspect-video', 'placeholder' => 'Drag & Drop Image']));

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

foreach (array_filter((['name', 'value' => null, 'label' => null, 'aspectRatio' => 'aspect-video', 'placeholder' => 'Drag & Drop Image']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="space-y-2">
    <?php if($label): ?>
        <label class="block text-sm font-black text-gray-800 mb-2 capitalize"><?php echo e($label); ?></label>
    <?php endif; ?>

    <div x-data="{ 
            preview: '<?php echo e($value ? (str_contains($value, 'http') ? $value : asset('storage/' . $value)) : ''); ?>',
            isDropping: false
        }" class="space-y-4">
        
        <div @dragover.prevent="isDropping = true" 
             @dragleave.prevent="isDropping = false" 
             @drop.prevent="isDropping = false; if($event.dataTransfer.files[0]) { preview = URL.createObjectURL($event.dataTransfer.files[0]); $refs.fileInput.files = $event.dataTransfer.files; }"
             :class="{'border-black bg-gray-50': isDropping, 'border-gray-200 bg-gray-50/50': !isDropping}"
             class="relative w-full max-w-2xl rounded-2xl border-2 border-dashed flex flex-col items-center justify-center transition-all duration-300 overflow-hidden group <?php echo e($aspectRatio); ?>">
            
            <!-- Background Preview -->
            <div x-show="preview" class="absolute inset-0 z-0">
                <img :src="preview" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <span class="text-white font-bold tracking-widest uppercase text-xs">Change Image</span>
                </div>
            </div>

            <!-- Empty State -->
            <div x-show="!preview" class="z-10 flex flex-col items-center justify-center text-gray-400 pointer-events-none">
                <svg class="w-10 h-10 mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-xs font-black uppercase tracking-widest text-gray-500"><?php echo e($placeholder); ?></span>
                <span class="text-[10px] text-gray-400 mt-1">or click to browse</span>
            </div>

            <!-- Hidden File Input -->
            <input type="file" x-ref="fileInput" name="<?php echo e($name); ?>" accept="image/*" 
                   @change="if($event.target.files[0]) preview = URL.createObjectURL($event.target.files[0])"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
        </div>
    </div>
</div>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/components/drag-drop-image.blade.php ENDPATH**/ ?>