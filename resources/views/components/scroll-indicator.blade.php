@props(['target' => null, 'click' => null])

@php
    $clickHandler = $click ?? ($target ? "document.getElementById('$target').scrollIntoView({ behavior: 'smooth' })" : "window.scrollTo({ top: window.innerHeight, behavior: 'smooth' })");
@endphp

<div {{ $attributes->merge(['class' => 'absolute bottom-12 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-4 text-white/30 cursor-pointer']) }} 
     @click="{!! $clickHandler !!}">
    <div class="w-px h-16 bg-white/20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1/2 bg-white animate-[scroll-down_2s_infinite]"></div>
    </div>
</div>
