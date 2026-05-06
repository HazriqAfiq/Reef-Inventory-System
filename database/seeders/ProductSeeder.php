<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            // === Reef Classic Collection (100ml) ===
            ['name' => 'Reef 1',        'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Citrus',                  'heart_note' => 'Lily of the Valley', 'base_note' => 'Amber'],
            ['name' => 'Reef 11',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Pink Pepper',             'heart_note' => 'Jasmine',            'base_note' => 'Sandalwood'],
            ['name' => 'Reef 15',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Bergamot',                'heart_note' => 'Floral Notes',       'base_note' => 'Oud'],
            ['name' => 'Reef 19',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Lily of the Valley',      'heart_note' => 'Jasmine',            'base_note' => 'White Musk'],
            ['name' => 'Reef 21',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Red Berries',             'heart_note' => 'Cedarwood',          'base_note' => 'Patchouli'],
            ['name' => 'Reef 27',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Lily of the Valley',      'heart_note' => 'Rose',               'base_note' => 'Musk'],
            ['name' => 'Reef 29',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Saffron',                 'heart_note' => 'Iris',               'base_note' => 'Leather'],
            ['name' => 'Reef 30',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Cardamom',                'heart_note' => 'Patchouli',          'base_note' => 'Leather'],
            ['name' => 'Reef 31',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Saffron',                 'heart_note' => 'Amber',              'base_note' => 'Vanilla'],
            ['name' => 'Reef 33',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Saffron',                 'heart_note' => 'Rosemary',           'base_note' => 'Oud'],
            ['name' => 'Reef 33 White', 'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Berries',                 'heart_note' => 'Saffron',            'base_note' => 'Oud'],
            ['name' => 'Reef 36',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Bergamot',                'heart_note' => 'Amber',              'base_note' => 'Musk'],
            ['name' => 'Reef 41',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Peony',                   'heart_note' => 'Vanilla',            'base_note' => 'Musk'],
            ['name' => 'Reef 42',       'volume_ml' => 100, 'type' => 'classic', 'top_note' => 'Rose',                    'heart_note' => 'Sandalwood',         'base_note' => 'Musk'],

            // === Summer Collection (100ml) ===
            ['name' => 'Summer Tiffany','volume_ml' => 100, 'type' => 'summer',  'top_note' => 'Mandarin',                'heart_note' => 'Peach',              'base_note' => 'Musk'],
            ['name' => 'Summer Pink',   'volume_ml' => 100, 'type' => 'summer',  'top_note' => 'Pear',                    'heart_note' => 'Amber',              'base_note' => 'Sandalwood'],
            ['name' => 'Summer Yellow', 'volume_ml' => 100, 'type' => 'summer',  'top_note' => 'Orange Blossom',          'heart_note' => 'Vanilla',            'base_note' => 'White Musk'],

            // === Large Collection (200ml) ===
            ['name' => 'Reef Pesca',    'volume_ml' => 200, 'type' => 'niche',   'top_note' => 'Peach',                   'heart_note' => 'Rose',               'base_note' => 'Musk'],
            ['name' => 'Reef Bluest',   'volume_ml' => 200, 'type' => 'niche',   'top_note' => 'Cardamom',                'heart_note' => 'Orris',              'base_note' => 'Golden Amber'],
            ['name' => 'Reef Titan',    'volume_ml' => 200, 'type' => 'niche',   'top_note' => 'Citrus / Grapefruit',     'heart_note' => 'Orris',              'base_note' => 'Vetiver'],
            ['name' => 'Reef Force',    'volume_ml' => 200, 'type' => 'niche',   'top_note' => 'Caramel',                 'heart_note' => 'Peony',              'base_note' => 'White Musk'],
            ['name' => 'Reef Volcano',  'volume_ml' => 200, 'type' => 'niche',   'top_note' => 'Spices',                  'heart_note' => 'Earthy Notes',       'base_note' => 'Wood'],

            // === Blanc Specialty (150ml) ===
            ['name' => 'Reef Blanc Ash',    'volume_ml' => 150, 'type' => 'blanc', 'top_note' => 'Black Pepper',        'heart_note' => 'Saffron',            'base_note' => 'Cedarwood'],
            ['name' => 'Reef Blanc Nomad',  'volume_ml' => 150, 'type' => 'blanc', 'top_note' => 'Saffron',             'heart_note' => 'Rose',               'base_note' => 'Vetiver'],
            ['name' => 'Reef Blanc Breath', 'volume_ml' => 150, 'type' => 'blanc', 'top_note' => 'Bergamot',            'heart_note' => 'Orange Blossom',     'base_note' => 'Amber'],
            ['name' => 'Lady Reef',         'volume_ml' => 150, 'type' => 'niche', 'top_note' => 'Blackcurrant',        'heart_note' => 'Jasmine',            'base_note' => 'Musk'],
            ['name' => 'Reef Veridian',     'volume_ml' => 150, 'type' => 'niche', 'top_note' => 'Almond',              'heart_note' => 'Jasmine',            'base_note' => 'Musk'],

            // === Specialty Collection (100ml) ===
            ['name' => 'Reef Obaiah',       'volume_ml' => 100, 'type' => 'niche', 'top_note' => 'Pineapple',           'heart_note' => 'Leather',            'base_note' => 'Oud Resin'],
            ['name' => 'Arabs of Al Ula',   'volume_ml' => 100, 'type' => 'niche', 'top_note' => 'Grapefruit',          'heart_note' => 'Patchouli',          'base_note' => 'Leather'],
            ['name' => 'Arabs of Diriyah',  'volume_ml' => 100, 'type' => 'niche', 'top_note' => 'Saffron',             'heart_note' => 'Rosewood',           'base_note' => 'Tonka'],
        ];

        foreach ($catalog as $item) {
            // Auto-generate SKU: e.g. "Reef 33 White" @ 100ml -> "REEF-33-WHITE-100"
            $skuBase = strtoupper(preg_replace('/[^a-zA-Z0-9]+/', '-', $item['name']));
            $sku = trim($skuBase, '-') . '-' . $item['volume_ml'];

            // Auto-detect fragrance family for seeding
            $scores = ['fresh' => 0, 'floral' => 0, 'woody' => 0, 'oriental' => 0, 'gourmand' => 0];
            $notesDict = [
                'citrus' => 'fresh', 'bergamot' => 'fresh', 'ocean' => 'fresh', 'mandarin' => 'fresh', 'pear' => 'fresh', 'peach' => 'fresh', 'orange blossom' => 'floral', 'berries' => 'fresh', 'pineapple' => 'fresh', 'blackcurrant' => 'fresh', 'grapefruit' => 'fresh',
                'rose' => 'floral', 'jasmine' => 'floral', 'lavender' => 'floral', 'peony' => 'floral', 'iris' => 'floral', 'lily of the valley' => 'floral', 'orris' => 'floral', 'floral notes' => 'floral', 'rosewood' => 'woody', 'violet' => 'floral',
                'sandalwood' => 'woody', 'cedarwood' => 'woody', 'cedar' => 'woody', 'oud' => 'woody', 'oud resin' => 'woody', 'patchouli' => 'woody', 'vetiver' => 'woody', 'wood' => 'woody', 'earthy notes' => 'woody',
                'amber' => 'oriental', 'golden amber' => 'oriental', 'musk' => 'oriental', 'white musk' => 'oriental', 'saffron' => 'oriental', 'leather' => 'oriental', 'cardamom' => 'oriental', 'spices' => 'oriental', 'black pepper' => 'oriental', 'pink pepper' => 'oriental', 'tonka' => 'oriental',
                'caramel' => 'gourmand', 'vanilla' => 'gourmand', 'almond' => 'gourmand'
            ];

            $text = strtolower(($item['top_note'] ?? '') . ' ' . ($item['heart_note'] ?? '') . ' ' . ($item['base_note'] ?? ''));
            foreach ($notesDict as $kw => $fam) {
                if (str_contains($text, $kw)) {
                    $scores[$fam]++;
                }
            }
            arsort($scores);
            $fragranceFamily = reset($scores) > 0 ? key($scores) : 'fresh';

            // Look up or create category
            $categoryName = ['men', 'woman', 'unisex'][array_rand(['men', 'woman', 'unisex'])];
            $categoryId = \Illuminate\Support\Facades\DB::table('categories')
                ->where('name', $categoryName)
                ->value('id') ?? \Illuminate\Support\Facades\DB::table('categories')->insertGetId([
                    'name' => $categoryName,
                    'slug' => \Illuminate\Support\Str::slug($categoryName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            // Look up or create product type
            $typeName = match($item['type']) {
                'classic', 'summer', 'niche' => 'Perfume sprays',
                'blanc' => 'Hair mists',
                default => 'Perfume sprays',
            };
            $productTypeId = \Illuminate\Support\Facades\DB::table('product_types')
                ->where('name', $typeName)
                ->value('id') ?? \Illuminate\Support\Facades\DB::table('product_types')->insertGetId([
                    'name' => $typeName,
                    'slug' => \Illuminate\Support\Str::slug($typeName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'name'         => $item['name'],
                    'slug'         => Str::slug($item['name'] . '-' . $item['volume_ml']),
                    'volume_ml'    => $item['volume_ml'],
                    'product_type_id' => $productTypeId,
                    'category_id'     => $categoryId,
                    'top_note'     => $item['top_note'],
                    'heart_note'   => $item['heart_note'],
                    'base_note'    => $item['base_note'],
                    'fragrance_family' => $fragranceFamily,
                    'description'  => $item['top_note'] . ' | ' . $item['heart_note'] . ' | ' . $item['base_note'],
                    'wholesale_price' => rand(180, 250),
                    'retail_price'    => rand(320, 399),
                    'stock'           => 50,
                    'is_active'    => true,
                    'release_date' => now()->subMonths(rand(0, 12)),
                ]
            );
        }
    }
}
