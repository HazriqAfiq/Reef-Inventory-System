<x-app-layout :title="$title ?? 'Storefront Settings'">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $title ?? 'Storefront Configuration' }}</h1>
            <p class="text-sm text-gray-500 mt-1">Manage global identifiers and public storefront presentation layers.</p>
        </div>
    </div>



    @php
        $updateRoute = isset($page) ? route('admin.settings.page.update', $page) : route('admin.settings.update');
    @endphp

    <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data" x-data="{ submitting: false }" @submit="submitting = true" class="space-y-12 pb-32">
        @csrf
        @if(isset($title))
            <input type="hidden" name="type" value="{{ strtolower($title) }}">
        @endif

        @if(isset($sections) && isset($settings))
            @foreach($sections as $groupKey => $groupTitle)
                @php $groupSettings = $settings->where('group', $groupKey); @endphp
                @if($groupSettings->count() > 0)
                    <div class="space-y-8">
                        <h2 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-2">{{ $groupTitle }}</h2>
                        
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-8 space-y-10">
                                @foreach($groupSettings as $setting)
                                    <div class="space-y-3">
                                        <label for="{{ $setting->key }}" class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">
                                            {{ str_replace(['_', $groupKey . ' '], [' ', ''], $setting->key) }}
                                        </label>
                                        
                                        @if($setting->type === 'image')
                                            @php
                                                $aspectRatio = 'aspect-video';
                                                if (str_contains($setting->key, 'hero_image')) {
                                                    $isBanner = str_contains($setting->key, 'results') || str_contains($setting->key, 'collection') || str_contains($setting->key, 'arrivals') || str_contains($setting->key, 'sellers');
                                                    $aspectRatio = $isBanner ? 'aspect-[21/9]' : 'aspect-[16/9]';
                                                }
                                            @endphp
                                            <x-drag-drop-image :name="$setting->key" :value="$setting->value" :aspectRatio="$aspectRatio" />
                                        @elseif($setting->type === 'textarea')
                                            <textarea name="{{ $setting->key }}" id="{{ $setting->key }}" rows="4"
                                                      class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all resize-none">{{ old($setting->key, $setting->value) }}</textarea>
                                        @elseif($setting->type === 'boolean')
                                            <div class="flex items-center gap-3">
                                                <x-toggle :name="$setting->key" :checked="$setting->value === '1' || $setting->value === 'true'" />
                                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Enabled</span>
                                            </div>
                                        @elseif($setting->type === 'color')
                                            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100 w-fit">
                                                <input type="color" name="{{ $setting->key }}" value="{{ $setting->value }}" class="h-10 w-16 rounded-lg border-gray-100 cursor-pointer">
                                                <input type="text" value="{{ $setting->value }}" readonly class="bg-transparent border-none text-[10px] font-bold text-gray-900 w-24 focus:ring-0 uppercase tracking-widest">
                                            </div>
                                        @elseif($setting->type === 'select')
                                            @if($setting->key === 'brand_logo_style')
                                                <select name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                        class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                                    <option value="both" {{ old($setting->key, $setting->value) === 'both' ? 'selected' : '' }}>Both (Logo & Text)</option>
                                                    <option value="logo" {{ old($setting->key, $setting->value) === 'logo' ? 'selected' : '' }}>Logo Only</option>
                                                    <option value="text" {{ old($setting->key, $setting->value) === 'text' ? 'selected' : '' }}>Text Only</option>
                                                </select>
                                            @elseif($setting->key === 'theme_typography_pairing')
                                                <select name="{{ $setting->key }}" id="{{ $setting->key }}"
                                                        class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                                    <option value="classic" {{ old($setting->key, $setting->value) === 'classic' ? 'selected' : '' }}>Classic Serif / Sans</option>
                                                    <option value="modern" {{ old($setting->key, $setting->value) === 'modern' ? 'selected' : '' }}>Modern Minimalist</option>
                                                    <option value="editorial" {{ old($setting->key, $setting->value) === 'editorial' ? 'selected' : '' }}>Editorial Luxury</option>
                                                </select>
                                            @else
                                                <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                                       class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                            @endif
                                        @else
                                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ old($setting->key, $setting->value) }}"
                                                   class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:ring-0 focus:border-black transition-all">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        <!-- Save Action Container -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 flex items-center justify-between">
            <div class="flex items-center gap-3 px-1">
                <div class="w-2 h-2 rounded-full bg-black animate-pulse"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Security: All modifications are audited</span>
            </div>
            
            <button type="submit" :disabled="submitting"
                    class="px-12 py-3.5 bg-black hover:bg-gray-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-black/10 transition-all disabled:opacity-20 flex items-center justify-center gap-3 active:scale-95">
                <template x-if="submitting">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </template>
                <template x-if="!submitting">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </template>
                <span x-show="!submitting">Save Configuration</span>
                <span x-show="submitting">Updating...</span>
            </button>
        </div>
    </form>
</x-app-layout>
