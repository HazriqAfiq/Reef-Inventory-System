<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 border-b border-gray-100">
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Timestamp</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Actor</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Action</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">Description</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">IP Address</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-xs font-medium text-gray-700">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm font-bold text-gray-900 leading-none">{{ $log->created_at->format('d M Y') }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $log->created_at->format('h:i A') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-[10px] shrink-0">
                                {{ strtoupper(substr($log->user->name ?? 'SYS', 0, 2)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900 leading-none">{{ $log->user->name ?? 'System' }}</p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1">{{ ucfirst($log->user->role ?? 'System') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex px-2 py-0.5 rounded bg-gray-50 border border-gray-100 text-[9px] font-black text-gray-600 uppercase tracking-widest leading-none">
                            {{ str_replace('_', ' ', $log->action) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-xs font-bold text-gray-700 max-w-md leading-relaxed">{{ $log->description }}</p>
                        @if($log->properties)
                            <div x-data="{ open: false }" class="mt-2">
                                <button @click="open = !open" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-colors">
                                    <span x-show="!open">View Payload [+]</span>
                                    <span x-show="open">Hide Payload [-]</span>
                                </button>
                                <pre x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-[-10px]"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="mt-2 p-3 bg-gray-900 text-gray-300 rounded-lg overflow-x-auto text-[9px] leading-relaxed shadow-lg">@json($log->properties, JSON_PRETTY_PRINT)</pre>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-[10px] text-gray-400">{{ $log->ip_address }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="max-w-xs mx-auto">
                            <div class="w-12 h-12 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">No Activity Logged</p>
                            <p class="text-xs text-gray-400 mt-1">Actions performed by ecosystem users will be recorded here in real-time.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($logs->hasPages())
    <div class="px-6 py-5 border-t border-gray-50">
        {{ $logs->links() }}
    </div>
@endif
