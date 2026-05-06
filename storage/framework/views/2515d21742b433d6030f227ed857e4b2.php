<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title ?? 'Storefront Settings')]); ?>

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?php echo e($title ?? 'Storefront Configuration'); ?></h1>
            <p class="text-sm text-gray-500 mt-1">Manage global identifiers and public storefront presentation layers.</p>
        </div>
    </div>



    <?php
        $updateRoute = isset($page) ? route('admin.settings.page.update', $page) : route('admin.settings.update');
    ?>

    <form action="<?php echo e($updateRoute); ?>" method="POST" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true" class="space-y-12 pb-32">
        <?php echo csrf_field(); ?>
        <?php if(isset($title)): ?>
            <input type="hidden" name="type" value="<?php echo e(strtolower($title)); ?>">
        <?php endif; ?>

        <?php if(isset($sections) && isset($settings)): ?>
            <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $groupTitle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $groupSettings = $settings->where('group', $groupKey); ?>
                <?php if($groupSettings->count() > 0): ?>
                    <div class="space-y-8">
                        <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2"><?php echo e($groupTitle); ?></h2>
                        
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-8 space-y-10">
                                <?php $__currentLoopData = $groupSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="space-y-3">
                                        <label for="<?php echo e($setting->key); ?>" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">
                                            <?php echo e(str_replace(['_', $groupKey . ' '], [' ', ''], $setting->key)); ?>

                                        </label>
                                        
                                        <?php if($setting->type === 'image'): ?>
                                            <?php
                                                $aspectRatio = 'aspect-video';
                                                if (str_contains($setting->key, 'hero_image')) {
                                                    $isBanner = str_contains($setting->key, 'results') || str_contains($setting->key, 'collection') || str_contains($setting->key, 'arrivals') || str_contains($setting->key, 'sellers');
                                                    $aspectRatio = $isBanner ? 'aspect-[21/9]' : 'aspect-[16/9]';
                                                }
                                            ?>
                                            <?php if (isset($component)) { $__componentOriginal53a745a7f512172524a0553450be2753 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53a745a7f512172524a0553450be2753 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.drag-drop-image','data' => ['name' => $setting->key,'value' => $setting->value,'aspectRatio' => $aspectRatio]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('drag-drop-image'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($setting->key),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($setting->value),'aspectRatio' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($aspectRatio)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53a745a7f512172524a0553450be2753)): ?>
<?php $attributes = $__attributesOriginal53a745a7f512172524a0553450be2753; ?>
<?php unset($__attributesOriginal53a745a7f512172524a0553450be2753); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53a745a7f512172524a0553450be2753)): ?>
<?php $component = $__componentOriginal53a745a7f512172524a0553450be2753; ?>
<?php unset($__componentOriginal53a745a7f512172524a0553450be2753); ?>
<?php endif; ?>
                                        <?php elseif($setting->type === 'textarea'): ?>
                                            <textarea name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>" rows="4"
                                                      class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all resize-none"><?php echo e(old($setting->key, $setting->value)); ?></textarea>
                                        <?php elseif($setting->type === 'boolean'): ?>
                                            <div class="flex items-center gap-3">
                                                <?php if (isset($component)) { $__componentOriginal592735d30e1926fbb04ff9e089d1fccf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal592735d30e1926fbb04ff9e089d1fccf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toggle','data' => ['name' => $setting->key,'checked' => $setting->value === '1' || $setting->value === 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($setting->key),'checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($setting->value === '1' || $setting->value === 'true')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal592735d30e1926fbb04ff9e089d1fccf)): ?>
<?php $attributes = $__attributesOriginal592735d30e1926fbb04ff9e089d1fccf; ?>
<?php unset($__attributesOriginal592735d30e1926fbb04ff9e089d1fccf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal592735d30e1926fbb04ff9e089d1fccf)): ?>
<?php $component = $__componentOriginal592735d30e1926fbb04ff9e089d1fccf; ?>
<?php unset($__componentOriginal592735d30e1926fbb04ff9e089d1fccf); ?>
<?php endif; ?>
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Enabled</span>
                                            </div>
                                        <?php elseif($setting->type === 'color'): ?>
                                            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 w-fit">
                                                <input type="color" name="<?php echo e($setting->key); ?>" value="<?php echo e($setting->value); ?>" class="h-10 w-16 rounded-lg border-gray-100 cursor-pointer">
                                                <input type="text" value="<?php echo e($setting->value); ?>" readonly class="bg-transparent border-none text-[10px] font-bold text-gray-900 w-24 focus:ring-0 uppercase tracking-widest">
                                            </div>
                                        <?php elseif($setting->type === 'select'): ?>
                                            <?php if($setting->key === 'brand_logo_style'): ?>
                                                <select name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>"
                                                        class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                                    <option value="both" <?php echo e(old($setting->key, $setting->value) === 'both' ? 'selected' : ''); ?>>Both (Logo & Text)</option>
                                                    <option value="logo" <?php echo e(old($setting->key, $setting->value) === 'logo' ? 'selected' : ''); ?>>Logo Only</option>
                                                    <option value="text" <?php echo e(old($setting->key, $setting->value) === 'text' ? 'selected' : ''); ?>>Text Only</option>
                                                </select>
                                            <?php elseif($setting->key === 'theme_typography_pairing'): ?>
                                                <select name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>"
                                                        class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                                    <option value="classic" <?php echo e(old($setting->key, $setting->value) === 'classic' ? 'selected' : ''); ?>>Classic Serif / Sans</option>
                                                    <option value="modern" <?php echo e(old($setting->key, $setting->value) === 'modern' ? 'selected' : ''); ?>>Modern Minimalist</option>
                                                    <option value="editorial" <?php echo e(old($setting->key, $setting->value) === 'editorial' ? 'selected' : ''); ?>>Editorial Luxury</option>
                                                </select>
                                            <?php else: ?>
                                                <input type="text" name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>" value="<?php echo e(old($setting->key, $setting->value)); ?>"
                                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <input type="text" name="<?php echo e($setting->key); ?>" id="<?php echo e($setting->key); ?>" value="<?php echo e(old($setting->key, $setting->value)); ?>"
                                                   class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <!-- Save Action Container -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 flex items-center justify-between">
            <div class="flex items-center gap-3 px-1">
                <div class="w-2 h-2 rounded-full bg-black animate-pulse"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Security: All modifications are audited</span>
            </div>
            
            <button type="submit" :disabled="submitting"
                    class="px-12 py-3.5 bg-black hover:bg-gray-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-black/10 transition-all disabled:opacity-20 flex items-center justify-center gap-3 active:scale-95">
                <template x-if="submitting">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </template>
                <template x-if="!submitting">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </template>
                <span x-show="!submitting">Save Configuration</span>
                <span x-show="submitting">Updating...</span>
            </button>
        </div>
    </form>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\perfume_store\resources\views/admin/settings/page.blade.php ENDPATH**/ ?>