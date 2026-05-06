<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class StorefrontSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Global Settings
            ['key' => 'brand_name', 'value' => 'Laman Store', 'type' => 'text', 'group' => 'global'],
            ['key' => 'announcement_bar_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'announcement'],
            ['key' => 'announcement_bar_text', 'value' => 'Complimentary Shipping on all orders over RM150', 'type' => 'text', 'group' => 'announcement'],
            ['key' => 'footer_instagram', 'value' => 'https://instagram.com', 'type' => 'text', 'group' => 'social'],
            ['key' => 'footer_facebook', 'value' => 'https://facebook.com', 'type' => 'text', 'group' => 'social'],
            ['key' => 'contact_whatsapp', 'value' => '+60123456789', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'concierge@lamanstore.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'copyright_text', 'value' => '© 2026 Laman Store Malaysia. All rights reserved.', 'type' => 'text', 'group' => 'global'],

            // Homepage Settings
            ['key' => 'homepage_title', 'value' => 'The Art of Pure Essence', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'homepage_subtitle', 'value' => 'The Laman Signature', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'homepage_hero_image', 'value' => 'hero/hero_cinematic.png', 'type' => 'image', 'group' => 'homepage'],
            ['key' => 'new_arrivals_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'new_arrivals'],
            ['key' => 'best_sellers_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'best_sellers'],
            ['key' => 'promotions_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'promotion_layout'],

            // Collection Settings
            ['key' => 'collection_hero_image', 'value' => 'hero/shop_banner_cinematic.png', 'type' => 'image', 'group' => 'collection'],

            // New Arrivals Settings
            // Moved hero image to homepage group

            // Best Sellers Settings
            // Moved hero image to homepage group

            // Promotions Settings
            // Moved hero image to homepage group

            // Scent Finder Settings
            ['key' => 'scent_finder_hero_image', 'value' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&q=80&w=2000', 'type' => 'image', 'group' => 'scent_finder'],
            ['key' => 'scent_finder_results_hero_image', 'value' => 'https://images.unsplash.com/photo-1557170334-a9632e77c6e4?auto=format&fit=crop&q=80&w=2000', 'type' => 'image', 'group' => 'scent_finder'],

            // Auth Settings
            ['key' => 'sign_in_image', 'value' => 'hero/hero_cinematic.png', 'type' => 'image', 'group' => 'auth'],
            ['key' => 'sign_up_image', 'value' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1974&auto=format&fit=crop', 'type' => 'image', 'group' => 'auth'],

            // Branding & Appearance Settings
            ['key' => 'philosophy_title', 'value' => 'Our Philosophy', 'type' => 'text', 'group' => 'philosophy'],
            ['key' => 'philosophy_quote', 'value' => 'Fragrances are not just scents, they are stories bottled in glass, waiting to be told across your skin.', 'type' => 'textarea', 'group' => 'philosophy'],
            ['key' => 'philosophy_link_text', 'value' => 'Our Heritage', 'type' => 'text', 'group' => 'philosophy'],
            ['key' => 'brand_logo', 'value' => 'branding/logo.png', 'type' => 'image', 'group' => 'branding'],
            ['key' => 'brand_logo_style', 'value' => 'both', 'type' => 'select', 'group' => 'branding'],
            ['key' => 'footer_story', 'value' => 'Join our community for early access to exclusive promotions, seasonal sales, and the art of fine fragrance.', 'type' => 'textarea', 'group' => 'branding'],
            ['key' => 'theme_typography_pairing', 'value' => 'classic', 'type' => 'select', 'group' => 'appearance'],
            ['key' => 'homepage_hero_scrim', 'value' => '0.3', 'type' => 'text', 'group' => 'appearance'],

            // Customer Engagement Settings
            ['key' => 'scent_finder_cta_text', 'value' => 'Secure Your Signature', 'type' => 'text', 'group' => 'engagement'],
            ['key' => 'announcement_bar_sticky', 'value' => '0', 'type' => 'boolean', 'group' => 'engagement'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
