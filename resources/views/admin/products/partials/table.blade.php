<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Product</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Volume</th>
                <th class="text-right px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pricing</th>
                <th class="text-left px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Inventory Breakdown</th>
                <th class="text-center px-8 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Wholesale Sold</th>
                <th class="px-8 py-4"></th>
            </tr>
        </thead>
        <tbody id="admin-products-tbody" class="divide-y divide-gray-50">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 transition-all duration-200">
                    {{-- Product --}}
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-4">
                            <!-- Product Image / Placeholder -->
                            <div class="w-12 h-12 bg-gray-50 border border-gray-100 rounded-xl flex items-center justify-center overflow-hidden shrink-0 shadow-sm">
                                @if($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <!-- Product Details -->
                            <div>
                                <p class="text-sm font-bold text-gray-900 leading-snug">{{ $product->name }}</p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="font-mono text-[9px] font-bold text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100 leading-none uppercase tracking-wider">{{ $product->sku }}</span>
                                    @if($product->category)
                                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-0.5 rounded leading-none border border-indigo-100/50">{{ $product->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Volume --}}
                    <td class="px-8 py-4 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-gray-500 bg-gray-50 border border-gray-100 px-2.5 py-1 rounded-lg uppercase tracking-wider leading-none">
                            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            {{ $product->volume_ml }} ml
                        </span>
                    </td>

                    {{-- Prices --}}
                    <td class="px-8 py-4 text-right whitespace-nowrap">
                        <div class="inline-flex flex-col items-end">
                            <p class="text-sm font-black text-gray-900 leading-none">RM{{ number_format($product->retail_price, 2) }}</p>
                            <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded mt-1.5 leading-none border border-emerald-100 uppercase tracking-widest">WS: RM{{ number_format($product->wholesale_price, 2) }}</span>
                        </div>
                    </td>

                    {{-- Stock --}}
                    <td class="px-8 py-4 min-w-[200px]">
                        @php
                            $adminStockTotal = $product->stock;
                            $combinedStock = $adminStockTotal + ($product->reseller_stocks_sum_quantity ?? 0);
                            $percent = min(max(($combinedStock / 150) * 100, 2), 100); 
                            if($combinedStock == 0) $percent = 0;
                            
                            if ($combinedStock === 0) {
                                $barColor = 'bg-rose-500';
                            } elseif ($combinedStock < 50) {
                                $barColor = 'bg-amber-500';
                            } else {
                                $barColor = 'bg-emerald-500';
                            }
                        @endphp
                        <div class="mb-2 flex items-center justify-between gap-4">
                            <span class="text-sm font-black text-gray-900 tabular-nums">
                                {{ number_format($combinedStock) }} 
                                <span class="text-[8px] text-gray-400 font-black uppercase tracking-wider ml-0.5">Total</span>
                            </span>
                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                <span class="text-gray-900 font-black">{{ $adminStockTotal }}</span> ADM &middot; <span class="text-gray-950 font-black">{{ $product->reseller_stocks_sum_quantity ?? 0 }}</span> RES
                            </span>
                        </div>
                        <div class="w-full bg-gray-50 h-1.5 rounded-full overflow-hidden shadow-inner relative border border-gray-100">
                            <div class="h-full rounded-full {{ $barColor }} transition-all duration-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </td>

                    {{-- Sales --}}
                    <td class="px-8 py-4 text-center whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 bg-gray-50 border border-gray-100 rounded-lg text-xs font-black text-gray-900 tabular-nums">
                            {{ number_format($product->sales_sum_quantity ?? 0) }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td class="px-8 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-black hover:text-white hover:border-black transition-all hover:scale-105 active:scale-95" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button type="button" onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}', '{{ addslashes($product->name) }}')" class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 border border-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all hover:scale-105 active:scale-95" title="Delete">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-24 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No Products Found</p>
                            <p class="text-xs text-gray-400 mt-1">Try adjusting your filters or add a new fragrance profile to the catalog.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(method_exists($products, 'nextPageUrl') && $products->nextPageUrl())
    <div id="admin-products-load-more-wrapper" class="px-6 py-5 border-t border-gray-50 flex justify-center">
        <button id="btn-admin-products-load-more" 
                data-next-url="{{ $products->nextPageUrl() }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-50 hover:bg-black hover:text-white border border-gray-100 hover:border-black text-gray-700 text-xs font-black uppercase tracking-widest rounded-xl transition-all hover:scale-105 active:scale-95 shadow-sm">
            <span>Show More</span>
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"/>
            </svg>
        </button>
    </div>
@endif

