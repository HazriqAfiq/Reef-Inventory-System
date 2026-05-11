<x-app-layout title="System Settings">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Configuration Console Active</span>
            </div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">System Settings</h1>
            <p class="text-xs text-gray-400 mt-1">Configure global branding assets, operational parameters, and promotion page metadata.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf

        @foreach($settings as $group => $items)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-8 py-5 bg-gray-50/20 border-b border-gray-50 flex items-center justify-between">
                    <h2 class="text-[10px] font-bold uppercase tracking-widest text-gray-900">{{ ucfirst($group) }} Parameters</h2>
                </div>
                
                <div class="p-8 space-y-6">
                    @foreach($items as $setting)
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                            <div class="lg:col-span-1">
                                <label class="text-[10px] font-bold text-gray-900 uppercase tracking-widest block mb-1">
                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                </label>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest text-[9px] mt-1.5">Manage global {{ str_replace('_', ' ', $setting->key) }} parameter.</p>
                            </div>
                            
                            <div class="lg:col-span-2">
                                @if($setting->type === 'image')
                                    <div class="flex items-center gap-6">
                                        @if($setting->value)
                                            <div class="w-24 h-24 rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50 shrink-0">
                                                <img src="{{ asset('storage/' . $setting->value) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" name="{{ $setting->key }}" class="block w-full text-xs text-gray-400
                                                file:mr-4 file:py-2.5 file:px-5
                                                file:rounded-xl file:border-0
                                                file:text-[10px] file:font-black file:uppercase file:tracking-wider
                                                file:bg-gray-100 file:text-black
                                                hover:file:bg-black hover:file:text-white transition-all duration-300">
                                            <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended: High resolution JPG or WEBP</p>
                                        </div>
                                    </div>
                                @elseif(in_array($setting->key, ['philosophy_quote', 'promo_page_description']))
                                    <textarea name="{{ $setting->key }}" rows="3" 
                                              class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all resize-none">{{ $setting->value }}</textarea>
                                @else
                                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}"
                                           class="w-full px-4 py-3 text-sm font-bold text-gray-900 bg-gray-50 border border-gray-100 rounded-xl focus:border-black focus:ring-0 transition-all">
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last) <hr class="border-gray-50"> @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-4 pt-4">
            <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 hover:-translate-y-0.5 transition-all shadow-sm hover:shadow-md duration-300">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Save Configuration
            </button>
        </div>
    </form>
</x-app-layout>
