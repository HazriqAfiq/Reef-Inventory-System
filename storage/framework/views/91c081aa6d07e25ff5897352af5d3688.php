<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Side: Form -->
        <div class="w-full md:w-[45%] bg-white flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative overflow-y-auto">
            <!-- Back Button Removed -->

            <div class="max-w-[420px] w-full animate-fade-in-up">
                <!-- Branding -->
                <div class="mb-16 text-center md:text-left">
                    <a href="/" class="inline-block group">
                        <h2 class="text-2xl font-luxury font-black tracking-[0.3em] uppercase text-black group-hover:opacity-60 transition-opacity">
                            <?php echo e(\App\Models\Setting::getValue('brand_name', 'Laman Store')); ?>

                        </h2>
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-12">
                    <h1 class="font-serif text-[42px] leading-tight text-gray-900 mb-4 italic">Reset Access</h1>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.4em] leading-relaxed">
                        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                    </p>
                </div>

                <!-- Session Status -->
                <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-6','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-6','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

                <form method="POST" action="<?php echo e(route('password.email')); ?>" class="space-y-8">
                    <?php echo csrf_field(); ?>

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Email Address</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus 
                               class="w-full bg-white border-0 border-b border-gray-100 py-4 text-sm focus:ring-0 focus:border-black transition-colors placeholder-gray-300 px-0 font-medium"
                               placeholder="your@email.com">
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-6 bg-black text-white text-[11px] font-black uppercase tracking-[0.4em] hover:bg-gray-900 transition-all active:scale-[0.98] shadow-2xl shadow-black/10">
                            Email Password Reset Link
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <a href="<?php echo e(route('login')); ?>" class="text-[10px] font-black uppercase tracking-[0.3em] text-gray-300 hover:text-black transition-colors">
                        Back to Sign In
                    </a>
                </div>
            </div>

            <!-- Absolute Copy -->
            <div class="absolute bottom-8 left-12 hidden lg:block">
                <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.2em]">&copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Models\Setting::getValue('brand_name', 'Laman Store')); ?>. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side: Imagery -->
        <div class="hidden md:block w-full md:w-[55%] bg-black relative overflow-hidden">
            <!-- Cinematic Background -->
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=1000&auto=format&fit=crop" 
                     class="w-full h-full object-cover opacity-60 animate-zoom-slow" 
                     alt="Luxury Fragrance">
            </div>
            
            <div class="absolute inset-0 bg-gradient-to-r from-white via-transparent to-transparent z-10 w-32"></div>
            <div class="absolute inset-0 bg-black/10 z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center animate-fade-in-up delay-300">
                    <p class="text-white text-[11px] font-bold uppercase tracking-[0.6em] mb-6 opacity-60">SECURITY & PRIVACY</p>
                    <h3 class="font-serif text-7xl text-white italic drop-shadow-2xl opacity-90">Restore</h3>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>