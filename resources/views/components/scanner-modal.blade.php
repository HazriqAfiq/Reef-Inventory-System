@props(['targetEvent' => 'barcode-scanned'])

<div x-data="scannerComponent('{{ $targetEvent }}')"
     x-on:open-scanner.window="openScanner()"
     x-on:keydown.window="handleGlobalKeydown($event)">

    {{-- Scanner Modal --}}
    <div x-show="isOpen" 
         style="display: none;"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/80 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden relative" @click.away="closeScanner()">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-[15px] font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    Scan Barcode / QR
                </h3>
                <button @click="closeScanner()" class="text-gray-400 hover:text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 rounded-full p-1.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="p-6">
                <div id="reader" class="w-full min-h-[300px] bg-black rounded-xl overflow-hidden shadow-inner border border-gray-200"></div>
                <p class="text-[12px] text-gray-500 font-medium text-center mt-4 mb-2">Align the code within the frame.</p>
                <div class="flex justify-center">
                    <button @click="toggleFlashlight()" x-show="hasFlashlight" class="text-[11px] font-bold px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Toggle Flashlight
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

