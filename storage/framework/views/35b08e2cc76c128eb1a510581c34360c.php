<div class="overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Partner Profile</th>
                <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center">Sales</th>
                <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest text-right">Revenue</th>
                <th class="px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden sm:table-cell text-right">Joined</th>
                <th class="px-8 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                <?php echo e(strtoupper(substr($reseller->name, 0, 2))); ?>

                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900"><?php echo e($reseller->name); ?></p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($reseller->email); ?></p>
                            </div>
                        </div>
                    </td>

                    
                    <td class="px-8 py-5 text-center">
                        <span class="text-xs font-bold text-gray-900"><?php echo e(number_format($reseller->sales_count)); ?></span>
                    </td>

                    
                    <td class="px-8 py-5 text-right whitespace-nowrap">
                        <span class="text-sm font-bold text-gray-900">RM<?php echo e(number_format($reseller->sales_sum_total_price ?? 0, 2)); ?></span>
                    </td>

                    
                    <td class="px-8 py-5 hidden sm:table-cell text-right whitespace-nowrap">
                        <p class="text-xs font-bold text-gray-900"><?php echo e($reseller->created_at->format('d M Y')); ?></p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5"><?php echo e($reseller->created_at->diffForHumans()); ?></p>
                    </td>

                    
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-2.5">
                            <a href="<?php echo e(route('admin.resellers.edit', $reseller)); ?>" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-black hover:text-white hover:border-black transition-all" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="confirmDelete('<?php echo e(route('admin.resellers.destroy', $reseller)); ?>', '<?php echo e(addslashes($reseller->name)); ?>')" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-100 transition-all" title="Remove Partner">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">No Partners Found</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($resellers->hasPages()): ?>
    <div class="px-8 py-5 border-t border-gray-50">
        <?php echo e($resellers->links()); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\reef_inventory\resources\views/admin/resellers/partials/table.blade.php ENDPATH**/ ?>