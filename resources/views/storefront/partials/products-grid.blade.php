@if($products->isEmpty())
    <div class="py-40 text-center animate-fade-in">
        <h3 class="text-2xl font-serif mb-4 text-gray-400">No fragrances found</h3>
        <p class="text-[11px] text-gray-300 font-bold uppercase tracking-widest">Try adjusting your filters</p>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-16 animate-fade-in">
        @foreach($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>


@endif
