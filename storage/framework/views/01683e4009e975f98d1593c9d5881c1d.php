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
    <!-- Back Navigation -->
    <div class="mb-6">
        <a href="<?php echo e(route('reseller.orders.index')); ?>"
           class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-black transition-colors uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Orders
        </a>
    </div>

    <!-- Shipment Status Tracker Timeline (Full Width at the Top) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Shipment Status Tracker</h2>
            <?php if($order->tracking_number): ?>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-indigo-600 bg-indigo-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-indigo-100/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                        Tracked Shipment
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-6 md:p-8">
            
            <div class="relative">
                
                <div class="hidden sm:block absolute top-[18px] left-[10%] right-[10%] h-1 bg-gray-100 -z-10 rounded-full"></div>
                
                
                <?php
                    $progressPercentages = [
                        'pending'    => 0,
                        'paid'       => 25,
                        'processing' => 50,
                        'shipped'    => 75,
                        'delivered'  => 100,
                        'cancelled'  => 0,
                    ];
                    $pPercent = $progressPercentages[$order->status] ?? 0;
                ?>
                <?php if($order->status !== 'cancelled'): ?>
                    <div class="hidden sm:block absolute top-[18px] left-[10%] h-1 bg-black -z-10 rounded-full transition-all duration-500 ease-out" style="width: calc(<?php echo e($pPercent); ?>% * 0.8)"></div>
                <?php endif; ?>

                
                <div class="sm:hidden absolute top-4 bottom-4 left-[18px] w-1 bg-gray-100 -z-10 rounded-full"></div>

                
                <?php if($order->status !== 'cancelled'): ?>
                    <div class="sm:hidden absolute top-4 left-[18px] w-1 bg-black -z-10 rounded-full transition-all duration-500 ease-out" style="height: <?php echo e($pPercent); ?>%"></div>
                <?php endif; ?>

                <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 sm:gap-0 relative z-10">
                    
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 <?php echo e($order->status !== 'cancelled' ? 'bg-black border-black text-white' : 'bg-gray-100 border-gray-200 text-gray-400'); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black text-gray-900 uppercase tracking-widest leading-none sm:mt-1">Placed</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1"><?php echo e($order->created_at->format('d M \a\t h:i A')); ?></p>
                        </div>
                    </div>

                    
                    <?php
                        $isPaid = in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']);
                        $step2Bg = $isPaid ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-400';
                    ?>
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 <?php echo e($step2Bg); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.5-1.5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black <?php echo e($isPaid ? 'text-gray-900' : 'text-gray-400'); ?> uppercase tracking-widest leading-none sm:mt-1">Paid</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                <?php if($isPaid): ?>
                                    Verified
                                <?php else: ?>
                                    Awaiting Payment
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    
                    <?php
                        $isProcessing = in_array($order->status, ['processing', 'shipped', 'delivered']);
                        $step3Bg = $isProcessing ? 'bg-black border-black text-white' : 'bg-white border-gray-200 text-gray-400';
                    ?>
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 <?php echo e($step3Bg); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black <?php echo e($isProcessing ? 'text-gray-900' : 'text-gray-400'); ?> uppercase tracking-widest leading-none sm:mt-1">Processing</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                <?php if($isProcessing): ?>
                                    In Progress
                                <?php else: ?>
                                    Pending Prep
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    
                    <?php
                        $isShipped = in_array($order->status, ['shipped', 'delivered']);
                        $step4Bg = $isShipped ? 'bg-black border-black text-white animate-pulse' : 'bg-white border-gray-200 text-gray-400';
                    ?>
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 <?php echo e($step4Bg); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black <?php echo e($isShipped ? 'text-gray-900' : 'text-gray-400'); ?> uppercase tracking-widest leading-none sm:mt-1">Shipped</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                <?php if($order->shipped_at): ?>
                                    <?php echo e($order->shipped_at->format('d M \a\t h:i A')); ?>

                                <?php else: ?>
                                    Pending Dispatch
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>

                    
                    <?php
                        $isDelivered = $order->status === 'delivered';
                        $step5Bg = $isDelivered ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'bg-white border-gray-200 text-gray-400';
                    ?>
                    <div class="flex sm:flex-col items-center sm:text-center gap-4 sm:gap-3">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 transition-all duration-300 shrink-0 <?php echo e($step5Bg); ?>">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black <?php echo e($isDelivered ? 'text-emerald-600' : 'text-gray-400'); ?> uppercase tracking-widest leading-none sm:mt-1">Delivered</h4>
                            <p class="text-[9px] text-gray-400 font-medium mt-1">
                                <?php if($order->delivered_at): ?>
                                    <?php echo e($order->delivered_at->format('d M \a\t h:i A')); ?>

                                <?php else: ?>
                                    Final Destination
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Split Grid (Order Items Left, Logistics Sidebar Right) -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- LEFT COLUMN: Order Contents Table (2/3 Width) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Order Breakdown Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <!-- Header Section -->
                    <div class="px-6 py-8 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <?php if($order->status === 'paid'): ?>
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-emerald-600 bg-emerald-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-emerald-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Paid Status
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black text-amber-600 bg-amber-50/50 px-2.5 py-1 rounded-xl uppercase tracking-widest border border-amber-100/40">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Pending Status
                                    </span>
                                <?php endif; ?>
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest"><?php echo e($order->created_at->format('d M Y \a\t h:i A')); ?></span>
                            </div>
                            <h2 class="text-2xl font-black text-gray-900 tracking-tight">
                                Order Contents <span class="text-gray-300 font-medium">#</span><?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?>

                            </h2>
                        </div>
                        
                        <div class="shrink-0">
                            <?php if($order->status === 'paid'): ?>
                                <a href="<?php echo e(route('reseller.orders.invoice', $order)); ?>" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 bg-white border border-gray-100 text-gray-900 text-xs font-black uppercase tracking-widest rounded-xl hover:border-gray-200 transition-all shadow-sm w-full sm:w-auto justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Download Invoice
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('reseller.orders.payment', $order)); ?>" class="inline-flex items-center gap-2 px-8 py-3.5 bg-black text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all shadow-sm w-full sm:w-auto justify-center">
                                    Complete Payment
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Summary Metrics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 bg-gray-50/20 border-b border-gray-100">
                        <div class="px-6 py-5 text-center md:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Gateway Reference</p>
                            <p class="font-mono text-[10px] font-black text-gray-500 bg-gray-100/50 px-2.5 py-1 rounded-lg inline-block"><?php echo e($order->billplz_id ?? 'Not Available'); ?></p>
                        </div>
                        <div class="px-6 py-5 text-center md:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Total Quantity</p>
                            <p class="text-xl font-black text-gray-900 tabular-nums"><?php echo e(number_format($order->items->sum('quantity'))); ?> <span class="text-[9px] text-gray-400 uppercase ml-1">units</span></p>
                        </div>
                        <div class="px-6 py-5 text-center md:text-left">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Grand Total</p>
                            <p class="text-xl font-black text-gray-900 tabular-nums">RM<?php echo e(number_format($order->total_price, 2)); ?></p>
                        </div>
                    </div>

                    <!-- Order Items Breakdown -->
                    <div class="p-6">
                        <div class="bg-gray-50/20 rounded-2xl border border-gray-100 overflow-hidden">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50/50 border-b border-gray-100">
                                        <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest text-left">Product</th>
                                        <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest text-center">Qty</th>
                                        <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Unit Price</th>
                                        <th class="px-6 py-4 text-[9px] font-black text-gray-400 uppercase tracking-widest text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-gray-900 leading-none"><?php echo e($item->product->name); ?></p>
                                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1"><?php echo e($item->product->sku); ?> &bull; <?php echo e($item->product->volume_ml); ?>ml</p>
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums">
                                                <?php echo e($item->quantity); ?>

                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-400 tabular-nums">
                                                RM<?php echo e(number_format($item->price, 2)); ?>

                                            </td>
                                            <td class="px-6 py-4 text-right font-black text-gray-900 tabular-nums">
                                                RM<?php echo e(number_format($item->price * $item->quantity, 2)); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot class="bg-gray-50/50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-5 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Payable</td>
                                        <td class="px-6 py-5 text-right text-lg font-black text-gray-900 tabular-nums">
                                            RM<?php echo e(number_format($order->total_price, 2)); ?>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Logistics Sidebars & Physical Addresses (1/3 Width) -->
            <div class="space-y-8">
                
                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Delivery Tracking</h2>
                    </div>
                    <div class="p-6">
                        <?php if($order->tracking_number): ?>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-black text-white flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Courier Partner</p>
                                        <h4 class="text-sm font-black text-gray-900 flex flex-wrap items-center gap-2 mt-0.5">
                                            <?php echo e($order->courier_name ?? 'Logistics Partner'); ?>

                                            <?php if(str_starts_with(strtolower($order->tracking_number ?? ''), 'ep-') || strtolower($order->courier_name ?? '') === 'easyparcel'): ?>
                                                <span class="inline-flex text-[8px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100 uppercase tracking-widest shrink-0">Auto</span>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-3 border border-gray-100 flex items-center justify-between gap-2">
                                    <div>
                                        <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest">Tracking Code</p>
                                        <p class="text-xs font-mono font-bold text-gray-800 mt-0.5 truncate max-w-[150px]"><?php echo e($order->tracking_number); ?></p>
                                    </div>
                                    <button onclick="copyToClipboard('<?php echo e($order->tracking_number); ?>')" class="w-8 h-8 rounded-lg flex items-center justify-center bg-white border border-gray-200 hover:border-gray-300 hover:text-black text-gray-400 transition-all active:scale-90" title="Copy tracking number">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                    </button>
                                </div>

                                <?php if($order->tracking_url): ?>
                                    <a href="<?php echo e($order->tracking_url); ?>" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-black hover:bg-gray-800 text-white text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-sm">
                                        Track Shipment
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php elseif($order->status === 'cancelled'): ?>
                            <div class="text-center py-4">
                                <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                </div>
                                <h4 class="text-xs font-black text-rose-900 uppercase tracking-wider">Cancelled</h4>
                                <p class="text-[10px] text-rose-500/80 mt-1 leading-relaxed">This transaction has been cancelled. Reach out to support if you need further help.</p>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <div class="w-12 h-12 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-wider font-extrabold">Fulfillment Prep</h4>
                                <p class="text-[10px] text-gray-400 mt-1 leading-relaxed">Awaiting dispatch coordination. Courier tracking details will list here once dispatched.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php
                    $address = $order->shippingAddress;
                ?>
                <?php if($address): ?>
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                            <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Shipping Destination</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Recipient Contact</p>
                                <h4 class="text-sm font-black text-gray-900 mt-0.5"><?php echo e($address->first_name); ?> <?php echo e($address->last_name); ?></h4>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Phone Number</p>
                                    <p class="text-xs font-bold text-gray-700 mt-0.5"><?php echo e($address->phone); ?></p>
                                </div>
                                <?php if($address->email): ?>
                                    <div>
                                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Email Address</p>
                                        <p class="text-xs font-bold text-gray-700 mt-0.5 truncate" title="<?php echo e($address->email); ?>"><?php echo e($address->email); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Delivery Address</p>
                                <p class="text-xs font-bold text-gray-800 leading-relaxed bg-gray-50 p-3.5 rounded-xl border border-gray-100/50">
                                    <?php echo e($address->address); ?><br>
                                    <?php echo e($address->postcode); ?> <?php echo e($address->city); ?><br>
                                    <?php echo e($address->state); ?>, Malaysia
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/20">
                        <h2 class="text-xs font-black text-gray-900 uppercase tracking-widest">Activity Log</h2>
                    </div>
                    <div class="p-6 space-y-3.5 text-xs font-medium text-gray-500">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Created On</span>
                            <span class="text-gray-900 font-extrabold"><?php echo e($order->created_at->format('d M Y, h:i A')); ?></span>
                        </div>
                        <?php if($order->shipped_at): ?>
                            <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Dispatched On</span>
                                <span class="text-gray-900 font-extrabold"><?php echo e($order->shipped_at->format('d M Y, h:i A')); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($order->delivered_at): ?>
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Delivered On</span>
                                <span class="text-emerald-600 font-black"><?php echo e($order->delivered_at->format('d M Y, h:i A')); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
            
        </div>



    <!-- Script to handle dynamic actions -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Tracking number copied to clipboard!');
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
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
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/reseller/orders/show.blade.php ENDPATH**/ ?>