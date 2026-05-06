<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Add Product']); ?>

    <!-- Back Navigation -->
    <a href="<?php echo e(route('admin.products.index')); ?>"
       class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black mb-8 transition-colors uppercase tracking-widest">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Inventory
    </a>

    <!-- Page Content Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/20">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Product</h1>
            <p class="text-sm text-gray-500 mt-1">Configure the identity and specifications for the new catalog item.</p>
        </div>

        <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data" class="p-8 space-y-12">
            <?php echo csrf_field(); ?>

            <!-- Identity Section -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Product Identity</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="space-y-2">
                        <label for="sku" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">SKU Reference</label>
                        <input id="sku" name="sku" type="text" value="<?php echo e(old('sku')); ?>" placeholder="e.g. REEF-1-100"
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                        <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="space-y-2 lg:col-span-1">
                        <label for="name" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Display Name</label>
                        <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" autofocus placeholder="Noble Scent..."
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="space-y-2">
                        <label for="type" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Product Type</label>
                        <select id="type" name="product_type_id"
                                class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all cursor-pointer">
                            <option value="">Select Type...</option>
                            <?php $__currentLoopData = $productTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pt->id); ?>" <?php echo e(old('product_type_id') == $pt->id ? 'selected' : ''); ?>><?php echo e($pt->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label for="category" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Category</label>
                        <select id="category" name="category_id"
                                class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all cursor-pointer">
                            <option value="">Select Category...</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e(ucfirst($cat->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div x-data="{ 
                previews: [], 
                primaryIndex: 0,
                dataTransfer: new DataTransfer(),
                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    files.forEach((file) => {
                        this.dataTransfer.items.add(file);
                        const reader = new FileReader();
                        const previewIndex = this.previews.length;
                        this.previews.push({ url: '', name: file.name });
                        reader.onload = (e) => { this.previews[previewIndex].url = e.target.result; };
                        reader.readAsDataURL(file);
                    });
                    this.$refs.fileInput.files = this.dataTransfer.files;
                }
            }" class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Visual Gallery</h2>
                
                <div x-show="previews.length > 0" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 mb-8">
                    <template x-for="(preview, index) in previews" :key="index">
                        <div class="relative group aspect-square rounded-2xl overflow-hidden border border-gray-100 transition-all cursor-pointer"
                             :class="primaryIndex == index ? 'ring-2 ring-black border-transparent' : 'hover:border-gray-300'"
                             @click="primaryIndex = index">
                            <img :src="preview.url" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-[9px] font-bold text-white uppercase tracking-widest">Set Primary</span>
                            </div>
                            <div x-show="primaryIndex == index" class="absolute top-2 left-2 bg-black text-white text-[8px] font-bold uppercase tracking-widest px-2 py-1 rounded-lg">Primary</div>
                        </div>
                    </template>
                </div>

                <div class="bg-gray-50 border-2 border-dashed border-gray-100 rounded-2xl p-12 flex flex-col items-center justify-center text-center group hover:bg-white hover:border-black/10 transition-all">
                    <div class="w-12 h-12 bg-white rounded-xl border border-gray-100 flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-gray-300 group-hover:text-black transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-900 mb-1">Upload Product Photos</p>
                    <p class="text-[10px] text-gray-400 mb-6 uppercase tracking-widest">High resolution JPG or WEBP preferred</p>
                    <input type="file" name="images[]" multiple accept="image/*" @change="handleFiles" x-ref="fileInput" class="hidden">
                    <button type="button" @click="$refs.fileInput.click()" class="bg-black text-white text-[10px] font-bold uppercase tracking-widest px-10 py-3 rounded-xl hover:bg-gray-800 transition-all">Browse Media</button>
                    <input type="hidden" name="primary_index" :value="primaryIndex">
                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-4 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Variants Section -->
            <div x-data="{ 
                variants: [{ name: 'Default', retail_price: '', wholesale_price: '', stock: 0, sku: '' }],
                addVariant() { this.variants.push({ name: '', retail_price: '', wholesale_price: '', stock: 0, sku: '' }); },
                removeVariant(index) { this.variants.splice(index, 1); }
            }" class="space-y-8">
                <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sizing & Commercials</h2>
                    <button type="button" @click="addVariant()" class="text-[9px] font-bold uppercase tracking-widest text-black hover:opacity-60 flex items-center gap-1.5 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add Variant
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="bg-gray-50/50 border border-gray-50 rounded-2xl p-6 relative group">
                            <button type="button" @click="removeVariant(index)" x-show="variants.length > 1" class="absolute -top-2 -right-2 w-6 h-6 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6"/></svg></button>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                                <div>
                                    <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Variant Name</label>
                                    <input type="text" :name="'variants['+index+'][name]'" x-model="variant.name" required class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">SKU Suffix</label>
                                    <input type="text" :name="'variants['+index+'][sku]'" x-model="variant.sku" placeholder="-XL..." class="w-full px-4 py-3 text-sm font-mono font-bold text-gray-900 bg-white border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Retail (RM)</label>
                                    <input type="number" step="0.01" :name="'variants['+index+'][retail_price]'" x-model="variant.retail_price" required class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Wholesale (RM)</label>
                                    <input type="number" step="0.01" :name="'variants['+index+'][wholesale_price]'" x-model="variant.wholesale_price" required class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Initial Stock</label>
                                    <input type="number" :name="'variants['+index+'][stock]'" x-model="variant.stock" required class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-white border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="release_date" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Release Date</label>
                        <input id="release_date" name="release_date" type="date" value="<?php echo e(old('release_date', date('Y-m-d'))); ?>"
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="volume_ml" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Base Volume (ml)</label>
                        <input id="volume_ml" name="volume_ml" type="number" value="<?php echo e(old('volume_ml', 100)); ?>" min="1"
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                </div>
            </div>

            <!-- Fragrance Profile Section -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Olfactory Profile</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="space-y-2">
                        <label for="top_note" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Top Note</label>
                        <input id="top_note" name="top_note" type="text" value="<?php echo e(old('top_note')); ?>" placeholder="Citrus, Bergamot..." class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="heart_note" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Heart Note</label>
                        <input id="heart_note" name="heart_note" type="text" value="<?php echo e(old('heart_note')); ?>" placeholder="Damask Rose, Jasmine..." class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="base_note" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Base Note</label>
                        <input id="base_note" name="base_note" type="text" value="<?php echo e(old('base_note')); ?>" placeholder="Sandalwood, Musk..." class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label for="fragrance_family" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>Fragrance Family</label>
                        <select id="fragrance_family" name="fragrance_family" class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all cursor-pointer">
                            <option value="">Auto-detect from notes</option>
                            <option value="fresh" <?php echo e(old('fragrance_family') == 'fresh' ? 'selected' : ''); ?>>Fresh & Aquatic</option>
                            <option value="woody" <?php echo e(old('fragrance_family') == 'woody' ? 'selected' : ''); ?>>Woody & Earthy</option>
                            <option value="floral" <?php echo e(old('fragrance_family') == 'floral' ? 'selected' : ''); ?>>Floral & Powdery</option>
                            <option value="oriental" <?php echo e(old('fragrance_family') == 'oriental' ? 'selected' : ''); ?>>Oriental & Rich</option>
                            <option value="gourmand" <?php echo e(old('fragrance_family') == 'gourmand' ? 'selected' : ''); ?>>Gourmand & Sweet</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status & Notes -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Operational Context</h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-6">
                        <?php if (isset($component)) { $__componentOriginal592735d30e1926fbb04ff9e089d1fccf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal592735d30e1926fbb04ff9e089d1fccf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.toggle','data' => ['name' => 'is_active','checked' => old('is_active', true),'label' => 'Active Availability','description' => 'Controls product visibility across storefront and reseller dashboards.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'is_active','checked' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('is_active', true)),'label' => 'Active Availability','description' => 'Controls product visibility across storefront and reseller dashboards.']); ?>
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
                    </div>
                    <div class="space-y-2">
                        <label for="description" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Internal Narrative</label>
                        <textarea id="description" name="description" rows="5" class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all resize-none"><?php echo e(old('description')); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-6 pt-12 border-t border-gray-50">
                <a href="<?php echo e(route('admin.products.index')); ?>"
                   class="text-xs font-bold text-gray-400 hover:text-black uppercase tracking-widest transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-3 px-12 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Save Product
                </button>
            </div>
        </form>
    </div>

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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/products/create.blade.php ENDPATH**/ ?>