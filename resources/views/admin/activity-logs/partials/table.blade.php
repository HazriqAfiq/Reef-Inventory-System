<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50/80 border-b border-gray-100/80">
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Timestamp</th>
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Actor</th>
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Action</th>
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Description</th>
                <th class="text-left px-7 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">IP Address</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50/80">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50/60 transition-colors duration-100">
                    <td class="px-7 py-4.5 whitespace-nowrap">
                        <p class="text-[13px] font-bold text-gray-900">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="text-[11px] font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $log->created_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-7 py-4.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-[11px] shrink-0 border border-blue-200/50">
                                {{ strtoupper(substr($log->user->name ?? 'SYS', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-[13px] font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</p>
                                <p class="text-[11px] text-gray-400">{{ ucfirst($log->user->role ?? 'N/A') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-7 py-4.5">
                        <span class="inline-flex px-2 py-0.5 rounded bg-gray-100 border border-gray-200 text-[10px] font-black text-gray-600 uppercase tracking-widest">
                            {{ str_replace('_', ' ', $log->action) }}
                        </span>
                    </td>
                    <td class="px-7 py-4.5">
                        <p class="text-[13px] font-medium text-gray-700 max-w-md">{{ $log->description }}</p>
                        @if($log->properties)
                            <div x-data="{ open: false }" class="mt-2">
                                <button @click="open = !open" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-colors">
                                    <span x-show="!open">View Payload [+]</span>
                                    <span x-show="open">Hide Payload [-]</span>
                                </button>
                                <pre x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-[-10px]"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="mt-2 p-3 bg-gray-900 text-gray-300 rounded-lg overflow-x-auto text-[10px] leading-relaxed shadow-lg">@json($log->properties, JSON_PRETTY_PRINT)</pre>
                            </div>
                        @endif
                    </td>
                    <td class="px-7 py-4.5">
                        <span class="font-mono text-[11px] text-gray-400">{{ $log->ip_address }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-7 py-16 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100 shadow-sm">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <p class="text-[15px] font-bold text-gray-900 mb-1">No activity logged yet.</p>
                        <p class="text-[12px] text-gray-500">Events will appear here as admins interact with the system.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($logs->hasPages())
    <div class="px-7 py-5 border-t border-gray-50/80">
        {{ $logs->links() }}
    </div>
@endif
