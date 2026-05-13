<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Partner Profile</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Orders</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Wholesale Spend</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest hidden sm:table-cell text-right">Joined</th>
                <th class="px-6 py-4"></th>
            </tr>
        </thead>
        <tbody id="admin-resellers-tbody" class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                <?php echo e(strtoupper(substr($reseller->name, 0, 2))); ?>

                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-none"><?php echo e($reseller->name); ?></p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1 truncate max-w-[150px]"><?php echo e($reseller->email); ?></p>
                            </div>
                        </div>
                    </td>

                    
                    <td class="px-6 py-4 text-center font-bold text-gray-900 tabular-nums">
                        <?php echo e(number_format($reseller->orders_count)); ?>

                    </td>

                    
                    <td class="px-6 py-4 text-right whitespace-nowrap font-black text-gray-900 tabular-nums">
                        RM<?php echo e(number_format($reseller->orders_sum_total_price ?? 0, 2)); ?>

                    </td>

                    
                    <td class="px-6 py-4 hidden sm:table-cell text-right whitespace-nowrap">
                        <p class="text-xs font-bold text-gray-900 leading-none"><?php echo e($reseller->created_at->format('d M Y')); ?></p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1"><?php echo e($reseller->created_at->diffForHumans()); ?></p>
                    </td>

                    
                    <td class="px-6 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2.5">
                            <a href="<?php echo e(route('admin.resellers.edit', $reseller)); ?>" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-black hover:text-white hover:border-black transition-all hover:scale-105 active:scale-95" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="confirmDelete('<?php echo e(route('admin.resellers.destroy', $reseller)); ?>', '<?php echo e(addslashes($reseller->name)); ?>')" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 transition-all hover:scale-105 active:scale-95" title="Remove Partner">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No Partners Found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your keyword searches or add a new partner reseller profile.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($resellers->nextPageUrl()): ?>
    <div id="admin-resellers-load-more-wrapper" class="px-6 py-5 border-t border-gray-50 flex justify-center">
        <button id="btn-admin-resellers-load-more" 
                data-next-url="<?php echo e($resellers->nextPageUrl()); ?>" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-xs font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
            <span>Show More</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/>
            </svg>
        </button>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/admin/resellers/partials/table.blade.php ENDPATH**/ ?>