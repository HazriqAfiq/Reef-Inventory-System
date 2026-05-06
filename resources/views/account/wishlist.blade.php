<x-account-layout>

    {{-- ── PAGE TITLE ────────────────────────────────────────────────────── --}}
    <div class="mb-14 pb-10 border-b border-gray-100 flex justify-between items-end">
        <div>
            <div class="inline-flex items-center gap-6">
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
                <h2 class="text-3xl md:text-4xl font-light tracking-[0.2em] text-gray-900 leading-none uppercase">Wishlist</h2>
                <p class="w-8 md:w-12 h-[1px] bg-black opacity-10"></p>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em] mb-1">
            {{ $wishlistItems->count() }} {{ Str::plural('Item', $wishlistItems->count()) }}
        </p>
    </div>

    @if($wishlistItems->isEmpty())
        {{-- ── EMPTY STATE ──────────────────────────────────────────────────── --}}
        <div class="py-24 text-center border border-dashed border-gray-200 bg-gray-50/30">
            <div class="w-16 h-16 rounded-full bg-white border border-gray-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-6 h-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </div>
            <h3 class="text-xl font-light text-gray-900 mb-2 uppercase tracking-[0.1em]">Your wishlist is empty</h3>
            <p class="text-[13px] text-gray-400 font-medium mb-8 max-w-xs mx-auto leading-relaxed">Save your favorite fragrances to keep track of them and receive stock updates.</p>
            <a href="{{ route('storefront.collection') }}" 
               class="inline-flex items-center px-10 py-4 bg-black text-white text-[10px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 transition-colors">
                Explore Collection
            </a>
        </div>
    @else
        {{-- ── WISHLIST GRID ────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
            @foreach($wishlistItems as $item)
                <div class="relative group">
                    {{-- Remove Button (Overlay) --}}
                    <form action="{{ route('wishlist.toggle', $item->product) }}" method="POST" class="absolute top-4 right-4 z-20">
                        @csrf
                        <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full shadow-sm flex items-center justify-center text-gray-400 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                    
                    <x-product-card :product="$item->product" />
                </div>
            @endforeach
        </div>

        @if($wishlistItems->hasPages())
            <div class="mt-12">
                {{ $wishlistItems->links() }}
            </div>
        @endif
    @endif

</x-account-layout>
