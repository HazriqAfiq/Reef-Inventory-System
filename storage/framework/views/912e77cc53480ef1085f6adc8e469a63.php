<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Reseller']); ?>

    <!-- Back Navigation -->
    <a href="<?php echo e(route('admin.resellers.index')); ?>"
       class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black mb-8 transition-colors uppercase tracking-widest">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Resellers
    </a>

    <!-- Page Content Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-12">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center gap-5 bg-gray-50/20">
            <div class="w-14 h-14 rounded-xl bg-black flex items-center justify-center text-white font-bold text-lg shrink-0">
                <?php echo e(strtoupper(substr($reseller->name, 0, 2))); ?>

            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight"><?php echo e($reseller->name); ?></h1>
                <p class="text-sm text-gray-500 mt-1">Configure profile details and security credentials for this partner account.</p>
            </div>
        </div>

        <form action="<?php echo e(route('admin.resellers.update', $reseller)); ?>" method="POST" class="p-8 space-y-12">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Identity Section -->
            <div class="space-y-8">
                <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">Reseller Identity</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="space-y-2">
                        <label for="name" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Full Name <span class="text-red-500">*</span></label>
                        <input id="name" name="name" type="text" value="<?php echo e(old('name', $reseller->name)); ?>" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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
                        <label for="email" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Email Address <span class="text-red-500">*</span></label>
                        <input id="email" name="email" type="email" value="<?php echo e(old('email', $reseller->email)); ?>" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label for="commission_rate" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Commission Rate (%) <span class="text-red-500">*</span></label>
                        <input id="commission_rate" name="commission_rate" type="number" step="0.01" value="<?php echo e(old('commission_rate', $reseller->commission_rate)); ?>" required
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all <?php $__errorArgs = ['commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Credentials Section -->
            <div class="space-y-8">
                <div class="border-b border-gray-50 pb-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Security Credentials</h2>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Leave blank to keep current password unchanged</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-2">
                        <label for="password" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">New Password</label>
                        <input id="password" name="password" type="password" placeholder="Min. 8 characters"
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1.5 text-[10px] font-bold text-red-500 uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">Confirm New Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Re-type password"
                               class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-50 mt-12">
                <a href="<?php echo e(route('admin.resellers.index')); ?>"
                   class="px-8 py-3 bg-white border border-gray-100 hover:bg-gray-50 text-gray-400 hover:text-black rounded-xl text-xs font-bold uppercase tracking-widest transition-all duration-300">
                    Cancel
                </a>
                <button type="submit"
                        class="px-10 py-3 bg-black hover:bg-gray-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                    Update Partner
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/resellers/edit.blade.php ENDPATH**/ ?>