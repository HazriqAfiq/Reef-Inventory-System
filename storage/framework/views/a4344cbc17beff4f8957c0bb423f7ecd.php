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
    <div class="h-screen flex overflow-hidden bg-white">
        <!-- Left Side: Form -->
        <div class="w-full lg:w-[45%] flex flex-col items-center justify-center p-8 sm:p-12 lg:p-20 relative bg-white">
            <!-- Back Link Removed -->

            <div class="w-full max-w-[460px] animate-fade-in-up">
                <!-- Branding -->
                <div class="mb-10 text-center lg:text-left">
                    <a href="/" class="inline-block group mb-8">
                        <h2 class="text-xl font-luxury font-black tracking-[0.3em] uppercase text-black">
                            <?php echo e(\App\Models\Setting::getValue('brand_name', 'Laman Store')); ?>

                        </h2>
                    </a>
                    
                    <div class="flex items-center justify-center lg:justify-start gap-4 mb-2">
                        <p class="w-6 h-[1px] bg-gray-100"></p>
                        <h1 class="text-gray-400 text-xl font-light uppercase tracking-[0.4em] leading-none whitespace-nowrap">
                            SIGN <span class="text-gray-800 font-medium">UP</span>
                        </h1>
                        <p class="w-6 h-[1px] bg-gray-100"></p>
                    </div>
                </div>

                <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-5">
                    <?php echo csrf_field(); ?>

                    <!-- Name -->
                    <div class="space-y-1">
                        <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Full Name</label>
                        <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus 
                               class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-3.5 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                               placeholder="John Doe">
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('name'),'class' => 'mt-1 text-[10px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name')),'class' => 'mt-1 text-[10px]']); ?>
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

                    <!-- Email Address -->
                    <div class="space-y-1">
                        <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Email Address</label>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required 
                               class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-3.5 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                               placeholder="your@email.com">
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-1 text-[10px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-1 text-[10px]']); ?>
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

                    <!-- Password Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Password</label>
                            <input id="password" type="password" name="password" required 
                                   class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-3.5 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                                   placeholder="••••••••">
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-1 text-[10px]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-1 text-[10px]']); ?>
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
                        <div class="space-y-1">
                            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Confirm</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required 
                                   class="w-full bg-[#FAFAFA] border-0 rounded-2xl py-3.5 px-6 text-sm focus:ring-1 focus:ring-black transition-all placeholder-gray-300 font-medium"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-5 bg-black text-white rounded-2xl text-[12px] font-black uppercase tracking-[0.4em] hover:bg-gray-900 transition-all active:scale-[0.98] shadow-2xl shadow-black/10">
                            Create Account
                        </button>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center lg:text-left pt-6 border-t border-gray-50">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3">Already a member?</p>
                    <a href="<?php echo e(route('login')); ?>" class="text-[11px] font-black uppercase tracking-[0.3em] text-black border-b-2 border-black pb-1 hover:opacity-50 transition-opacity inline-block">Sign In Instead</a>
                </div>
            </div>
        </div>

        <div class="hidden lg:block w-[55%] bg-black relative overflow-hidden">
            <?php $signUpImage = \App\Models\Setting::getValue('sign_up_image', 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1974&auto=format&fit=crop'); ?>
            <img src="<?php echo e(str_contains($signUpImage, 'http') ? $signUpImage : asset('storage/' . $signUpImage)); ?>" 
                 class="w-full h-full object-cover opacity-60 animate-zoom-slow" 
                 alt="Luxury Fragrance">
            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent z-10"></div>
            
            <div class="absolute inset-0 flex items-center justify-center z-20">
                <div class="text-center animate-fade-in-up delay-300">
                    <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.6em] mb-6">Laman Signature</p>
                    <h3 class="font-serif text-6xl text-white italic drop-shadow-2xl opacity-90">
                        Create
                    </h3>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/auth/register.blade.php ENDPATH**/ ?>