<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a specific settings page.
     */
    public function showPage($page = 'brand')
    {
        $pageGroups = [
            'brand' => [
                'global' => 'Store Identity', 
                'contact' => 'Contact Information',
                'branding' => 'Branding'
            ],
            'system' => [
                'auth' => 'Authentication'
            ]
        ];
        
        if (!array_key_exists($page, $pageGroups)) {
            return redirect()->route('admin.settings.page', 'brand');
        }

        $sections = $pageGroups[$page];
        $settings = Setting::whereIn('group', array_keys($sections))->get();

        $viewPath = 'admin.settings.page';

        $title = ucfirst($page) . ' Settings';

        return view($viewPath, compact('title', 'settings', 'page', 'sections'));
    }

    /**
     * Update storefront settings for a specific page.
     */
    public function updatePage(Request $request, $page)
    {
        $data = $request->except('_token');

        $pageGroups = [
            'brand' => ['global', 'branding', 'contact'],
            'system' => ['auth']
        ];
        
        if (!array_key_exists($page, $pageGroups)) {
            return redirect()->back()->with('error', 'Invalid settings group.');
        }

        $groups = $pageGroups[$page];

        // Note: Checkbox boolean fields don't send anything if unchecked. 
        // Iterate through all boolean settings in this group to address unchecked ones.
        $groupSettings = Setting::whereIn('group', $groups)->get();

        foreach ($groupSettings as $setting) {
            if ($setting->type === 'boolean') {
                $setting->update(['value' => $request->has($setting->key) ? '1' : '0']);
            }
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting || $setting->type === 'boolean') continue; // Booleans handled above

            // Handle Image Upload
            if ($setting->type === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Determine folder based on key
                $folder = 'hero';
                if (str_contains($key, 'logo')) $folder = 'branding';
                if (str_contains($key, 'sign_in') || str_contains($key, 'sign_up')) $folder = 'auth';
                
                $path = $file->storeAs($folder, $filename, 'public');
                $dbPath = $folder . '/' . $filename;
                
                // Delete old image if it exists and is not the original protected default
                $protectedDefaults = ['hero/hero_cinematic.png', 'branding/logo.png'];
                if ($setting->value && !in_array($setting->value, $protectedDefaults)) {
                    if (Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }
                }

                $setting->update(['value' => $dbPath]);
                continue;
            }

            // Handle Text/TextArea
            if (!is_null($value)) {
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', ucfirst(str_replace('_', ' ', $page)) . ' settings updated successfully.');
    }


}
