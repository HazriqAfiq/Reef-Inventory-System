<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Product</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Volume</th>
                <th class="text-right px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pricing</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Inventory Breakdown</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sales</th>
                <th class="px-8 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50/50 transition-colors">
                    
                    <td class="px-8 py-5">
                        <p class="text-sm font-bold text-gray-900"><?php echo e($product->name); ?></p>
                        <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-wider">
                            <?php echo e($product->sku); ?> <?php if($product->category): ?> · <?php echo e($product->category->name); ?> <?php endif; ?>
                        </p>
                    </td>

                    
                    <td class="px-8 py-5 text-center">
                        <span class="inline-block text-[10px] font-bold text-gray-500 bg-gray-50 border border-gray-100 px-2 py-0.5 rounded-md uppercase">
                            <?php echo e($product->volume_ml); ?>ml
                        </span>
                    </td>

                    
                    <td class="px-8 py-5 text-right whitespace-nowrap">
                        <p class="text-sm font-bold text-gray-900">RM<?php echo e(number_format($product->retail_price, 2)); ?></p>
                        <p class="text-[10px] font-bold text-gray-400 mt-0.5 uppercase tracking-tighter">WS: RM<?php echo e(number_format($product->wholesale_price, 2)); ?></p>
                    </td>

                    
                    <td class="px-8 py-5">
                        <?php
                            $adminStockTotal = $product->variants->sum('stock');
                            $combinedStock = $adminStockTotal + ($product->reseller_stocks_sum_quantity ?? 0);
                            $percent = min(max(($combinedStock / 150) * 100, 2), 100); 
                            if($combinedStock == 0) $percent = 0;
                            $barColor = $combinedStock === 0 ? 'bg-gray-200' : ($combinedStock < 50 ? 'bg-amber-500' : 'bg-black');
                        ?>
                        <div class="mb-2 flex items-end justify-between">
                            <span class="text-sm font-bold text-gray-900"><?php echo e(number_format($combinedStock)); ?> <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Total</span></span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">
                                <?php echo e($adminStockTotal); ?> ADM · <?php echo e($product->reseller_stocks_sum_quantity ?? 0); ?> RES
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1 overflow-hidden">
                            <div class="h-1 rounded-full <?php echo e($barColor); ?> transition-all duration-700" style="width: <?php echo e($percent); ?>%"></div>
                        </div>
                    </td>

                    
                    <td class="px-8 py-5 text-center">
                        <span class="text-xs font-bold text-gray-900"><?php echo e(number_format($product->sales_sum_quantity ?? 0)); ?></span>
                    </td>

                    
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="text-gray-400 hover:text-black transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="confirmDelete('<?php echo e(route('admin.products.destroy', $product)); ?>', '<?php echo e(addslashes($product->name)); ?>')" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="py-20 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Inventory Catalog Empty</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if(method_exists($products, 'hasPages') && $products->hasPages()): ?>
    <div class="px-8 py-5 border-t border-gray-50">
        <?php echo e($products->links()); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\Users\USER\Documents\Project Code\rpims\resources\views/admin/products/partials/table.blade.php ENDPATH**/ ?>