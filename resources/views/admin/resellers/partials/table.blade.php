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
            @forelse($resellers as $reseller)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    {{-- Identity --}}
                    <td class="px-8 py-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-lg bg-gray-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                {{ strtoupper(substr($reseller->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $reseller->name }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $reseller->email }}</p>
                            </div>
                        </div>
                    </td>

                    {{-- Transactions --}}
                    <td class="px-8 py-5 text-center">
                        <span class="text-xs font-bold text-gray-900">{{ number_format($reseller->sales_count) }}</span>
                    </td>

                    {{-- Revenue --}}
                    <td class="px-8 py-5 text-right whitespace-nowrap">
                        <span class="text-sm font-bold text-gray-900">RM{{ number_format($reseller->sales_sum_total_price ?? 0, 2) }}</span>
                    </td>

                    {{-- Joined --}}
                    <td class="px-8 py-5 hidden sm:table-cell text-right whitespace-nowrap">
                        <p class="text-xs font-bold text-gray-900">{{ $reseller->created_at->format('d M Y') }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">{{ $reseller->created_at->diffForHumans() }}</p>
                    </td>

                    {{-- Actions --}}
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.resellers.edit', $reseller) }}"
                               class="text-[10px] font-bold text-gray-400 hover:text-black uppercase tracking-widest transition-colors">
                                Edit
                            </a>
                            <button type="button"
                                    onclick="confirmDelete('{{ route('admin.resellers.destroy', $reseller) }}', '{{ addslashes($reseller->name) }}')"
                                    class="text-[10px] font-bold text-gray-300 hover:text-red-500 uppercase tracking-widest transition-colors">
                                Remove
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-20 text-center">
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">No Partners Found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($resellers->hasPages())
    <div class="px-8 py-5 border-t border-gray-50">
        {{ $resellers->links() }}
    </div>
@endif
