<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Order Details']); ?>

    
    <a href="<?php echo e(route('admin.orders.index')); ?>"
       class="inline-flex items-center gap-1.5 text-[13px] font-bold text-gray-400 hover:text-gray-700 mb-6 transition-all duration-200 hover:-translate-x-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Orders
    </a>

    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h1 class="text-xl font-black text-gray-900 tracking-tight uppercase">Order #<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?></h1>
                <?php if($order->status === 'paid'): ?>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-600 border border-emerald-200/50 uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.5)]"></span>
                        Paid
                    </span>
                <?php else: ?>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-600 border border-amber-200/50 uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_6px_rgba(245,158,11,0.5)] animate-pulse"></span>
                        Pending
                    </span>
                <?php endif; ?>
            </div>
            <p class="text-[12px] font-medium text-gray-500 mt-1 uppercase tracking-widest">Placed on <?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden">
                <div class="px-7 py-5 border-b border-gray-50/80 bg-gray-50/30">
                    <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="border-b border-gray-100/80">
                            <tr>
                                <th class="px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Product</th>
                                <th class="px-7 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Qty</th>
                                <th class="px-7 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Unit Price</th>
                                <th class="px-7 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50/80">
                            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                                    <td class="px-7 py-4.5">
                                        <p class="text-[14px] font-black text-gray-900"><?php echo e($item->product->name); ?></p>
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                                            <?php echo e($item->product->sku); ?> &middot; <?php echo e($item->variant?->name ?? $item->product->volume_ml . 'ml'); ?>

                                        </p>
                                    </td>
                                    <td class="px-7 py-4.5 text-center">
                                        <span class="inline-flex items-center justify-center min-w-[2rem] px-1.5 h-6 rounded-lg bg-gray-100 border border-gray-200 text-gray-800 text-[12px] font-black shadow-sm">
                                            <?php echo e($item->quantity); ?>

                                        </span>
                                    </td>
                                    <td class="px-7 py-4.5 text-right">
                                        <span class="text-[13px] font-bold text-gray-600">RM<?php echo e(number_format($item->price, 2)); ?></span>
                                    </td>
                                    <td class="px-7 py-4.5 text-right">
                                        <span class="text-[14px] font-black text-gray-900">RM<?php echo e(number_format($item->price * $item->quantity, 2)); ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="border-t border-gray-100 bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="px-7 py-5 text-right text-[11px] font-black text-gray-500 uppercase tracking-widest">
                                    Total Amount
                                </td>
                                <td class="px-7 py-5 text-right text-xl font-black text-gray-900 tracking-tight">
                                    RM<?php echo e(number_format($order->total_price, 2)); ?>

                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50/80 bg-gray-50/30">
                    <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Customer Details</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-black text-[15px] border border-blue-100/50 shadow-sm shrink-0">
                            <?php echo e(strtoupper(substr($order->user->name, 0, 2))); ?>

                        </div>
                        <div>
                            <p class="text-[15px] font-black text-gray-900"><?php echo e($order->user->name); ?></p>
                            <p class="text-[13px] font-medium text-gray-500 mt-0.5"><?php echo e($order->user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl border border-gray-100 shadow-md shadow-gray-200/40 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50/80 bg-gray-50/30">
                    <h2 class="text-[15px] font-bold text-gray-900 tracking-tight">Payment Reference</h2>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Gateway Ref ID</p>
                        <p class="font-mono text-[13px] text-gray-900 font-bold bg-gray-50 px-3 py-2 rounded-xl border border-gray-200 inline-block shadow-inner">
                            <?php echo e($order->billplz_id ?? 'N/A'); ?>

                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Payment Status</p>
                        <?php if($order->status === 'paid'): ?>
                            <p class="text-[15px] font-black text-emerald-600">Paid & Verified</p>
                        <?php else: ?>
                            <p class="text-[15px] font-black text-amber-600 animate-pulse">Pending Verification</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>