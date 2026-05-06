<x-app-layout title="Storefront Settings">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-xl font-bold text-gray-900 tracking-tight">Storefront Settings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage branding, hero sections, and public content.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-20">
        @csrf

        @foreach($settings as $group => $items)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-7 py-5 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-[13px] font-black uppercase tracking-widest text-gray-800">{{ ucfirst($group) }} Section</h2>
                </div>
                
                <div class="p-7 space-y-6">
                    @foreach($items as $setting)
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                            <div class="lg:col-span-1">
                                <label class="text-sm font-bold text-gray-700 block mb-1">
                                    {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                </label>
                                <p class="text-xs text-gray-400 font-medium">Manage the {{ str_replace('_', ' ', $setting->key) }} displayed on the storefront.</p>
                            </div>
                            
                            <div class="lg:col-span-2">
                                @if($setting->type === 'image')
                                    <div class="flex items-center gap-6">
                                        @if($setting->value)
                                            <div class="w-32 h-32 rounded-2xl overflow-hidden border border-gray-200 shadow-inner bg-gray-50 shrink-0">
                                                <img src="{{ asset('storage/' . $setting->value) }}" class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <input type="file" name="{{ $setting->key }}" class="block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-xl file:border-0
                                                file:text-xs file:font-semibold
                                                file:bg-blue-50 file:text-blue-700
                                                hover:file:bg-blue-100 transition-all">
                                            <p class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-wider">Recommended: High resolution 2:3 or 16:9 ratio</p>
                                        </div>
                                    </div>
                                @elseif(in_array($setting->key, ['philosophy_quote', 'promo_page_description']))
                                    <textarea name="{{ $setting->key }}" rows="3" 
                                              class="w-full rounded-2xl border-gray-200 focus:border-blue-500 focus:ring-blue-500/20 text-sm font-medium transition-all">{{ $setting->value }}</textarea>
                                @else
                                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}"
                                           class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring-blue-500/20 text-sm font-medium transition-all">
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last) <hr class="border-gray-50"> @endif
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-4">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95">
                Save Changes
            </button>
        </div>
    </form>
</x-app-layout>
