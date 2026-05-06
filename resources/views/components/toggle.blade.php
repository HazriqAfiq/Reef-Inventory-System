@props(['name', 'checked' => false, 'label' => null, 'description' => null])

<div class="flex items-center justify-between" x-data="{ checked: {{ $checked ? 'true' : 'false' }} }">
    @if($label || $description)
        <div>
            @if($label)
                <label class="block text-sm font-black text-gray-800 capitalize">{{ $label }}</label>
            @endif
            @if($description)
                <p class="text-[11px] text-gray-500 mt-0.5">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="flex items-center">
        <!-- Horizontal Switch -->
        <button type="button" 
                @click="checked = !checked"
                :class="checked ? 'bg-black' : 'bg-gray-200'"
                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
            <span class="sr-only">Toggle {{ $label ?? $name }}</span>
            <span :class="checked ? 'translate-x-5' : 'translate-x-0'"
                  class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
        </button>
        <!-- Hidden actual input for form submission -->
        <input type="hidden" name="{{ $name }}" :value="checked ? '1' : '0'">
    </div>
</div>
