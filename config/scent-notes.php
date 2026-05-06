<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fragrance Family Definitions
    |--------------------------------------------------------------------------
    |
    | Defines the primary fragrance families and how they map to the quiz vibe.
    |
    */
    'families' => [
        'fresh' => [
            'label' => 'Fresh & Aquatic',
            'vibe' => 'fresh',
            'description' => 'Bright, crisp, and clean notes like citrus, aquatic accords, and fresh herbs.',
        ],
        'floral' => [
            'label' => 'Floral & Powdery',
            'vibe' => 'floral',
            'description' => 'Elegant and romantic notes from delicate flowers, blossoms, and sweet petals.',
        ],
        'woody' => [
            'label' => 'Woody & Earthy',
            'vibe' => 'woody',
            'description' => 'Deep, grounding notes of noble woods, roots, and forest mosses.',
        ],
        'oriental' => [
            'label' => 'Oriental & Rich',
            'vibe' => 'woody', // Rich resins and spices map naturally to Woody
            'description' => 'Warm, exotic, and sensual notes of spices, resins, and amber.',
        ],
        'gourmand' => [
            'label' => 'Gourmand & Sweet',
            'vibe' => 'floral', // Sweet gourmand elements fit beautifully with Floral-leaning sweet hearts
            'description' => 'Delectable, edible-leaning notes of honey, vanilla, caramel, and chocolate.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Note Dictionary
    |--------------------------------------------------------------------------
    |
    | Maps lowercase scent keywords to their family, intensity, and time.
    | Matches are performed using substring searches (e.g. "sandalwood" matches "sandalwood wood").
    |
    */
    'notes' => [
        // --- CITRUS & FRESH (Family: Fresh, Intensity: Subtle, Time: Day) ---
        'citrus'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'bergamot'        => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'grapefruit'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'mandarin'        => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'lemon'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'lime'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'orange'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'neroli'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'verbena'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'yuzu'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'lemongrass'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'clementine'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'pomelo'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'tangerine'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'petitgrain'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'citron'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'blood orange'    => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'calabrian bergamot' => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],

        // --- MARINE, AQUATIC & GREEN (Family: Fresh, Intensity: Subtle, Time: Day) ---
        'ocean'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'sea'             => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'aquatic'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'marine'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'sea salt'        => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'seaweed'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'water'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'green'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'mint'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'peppermint'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'spearmint'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'eucalyptus'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'basil'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'rosemary'        => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'sage'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'thyme'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'bamboo'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'tea'             => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'green tea'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'black tea'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'white tea'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'grass'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'fern'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'ivy'             => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'galbanum'        => ['family' => 'fresh', 'intensity' => 'bold',   'time' => 'day'],
        'vetiver'         => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'day'], 

        // --- FRUITY (Family: Fresh, Intensity: Subtle, Time: Day) ---
        'peach'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'pear'            => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'apple'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'green apple'     => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'melon'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'watermelon'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'pineapple'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'blackcurrant'    => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'cassis'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'berries'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'red berries'     => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'strawberry'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'raspberry'       => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'blackberry'      => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'cherry'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'fig'             => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'pomegranate'     => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'coconut'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'litchi'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'lychee'          => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'mango'           => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'apricot'         => ['family' => 'fresh', 'intensity' => 'subtle', 'time' => 'day'],
        'plum'            => ['family' => 'fresh', 'intensity' => 'bold',   'time' => 'night'],

        // --- FLORAL (Family: Floral, Intensity: Subtle/Bold, Time: Day/Night) ---
        'rose'            => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'damask rose'     => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'bulgarian rose'  => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'jasmine'         => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'lavender'        => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'peony'           => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'lily'            => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'lily of the valley' => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'iris'            => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'orris'           => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'orange blossom'  => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'neroli'          => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'tuberose'        => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'violet'          => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'lilac'           => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'ylang'           => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'ylang-ylang'     => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'gardenia'        => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'magnolia'        => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'freesia'         => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'orchid'          => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'hibiscus'        => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'geranium'        => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'heliotrope'      => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'carnation'       => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'mimosa'          => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'frangipani'      => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],
        'floral notes'    => ['family' => 'floral', 'intensity' => 'subtle', 'time' => 'day'],
        'moonflower'      => ['family' => 'floral', 'intensity' => 'bold',   'time' => 'night'],

        // --- WOODY (Family: Woody, Intensity: Bold, Time: Night/Day) ---
        'sandalwood'      => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'cedar'           => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'day'],
        'cedarwood'       => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'day'],
        'oud'             => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'oud resin'       => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'patchouli'       => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'oakmoss'         => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'wood'            => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'woods'           => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'rosewood'        => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'guaiac'          => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'guaiac wood'     => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'cypress'         => ['family' => 'woody', 'intensity' => 'subtle', 'time' => 'day'],
        'pine'            => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'day'],
        'fir'             => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'day'],
        'birch'           => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'ebony'           => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'cashmere wood'   => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'sandal'          => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],
        'earthy notes'    => ['family' => 'woody', 'intensity' => 'bold',   'time' => 'night'],

        // --- AMBER, RESINS & ORIENTAL (Family: Oriental, Intensity: Bold, Time: Night) ---
        'amber'           => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'golden amber'    => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'musk'            => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'white musk'      => ['family' => 'oriental', 'intensity' => 'subtle', 'time' => 'day'], 
        'saffron'         => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'leather'         => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'myrrh'           => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'frankincense'    => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'incense'         => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'benzoin'         => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'labdanum'        => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'tobacco'         => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'civet'           => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'ambergris'       => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'opoponax'        => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],

        // --- SPICES (Family: Oriental, Intensity: Bold, Time: Night) ---
        'cardamom'        => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'pink pepper'     => ['family' => 'oriental', 'intensity' => 'subtle', 'time' => 'day'], 
        'black pepper'    => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'pepper'          => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'cinnamon'        => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'clove'           => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'ginger'          => ['family' => 'oriental', 'intensity' => 'subtle', 'time' => 'day'], 
        'nutmeg'          => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'spices'          => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'coriander'       => ['family' => 'oriental', 'intensity' => 'subtle', 'time' => 'day'],
        'anis'            => ['family' => 'oriental', 'intensity' => 'subtle', 'time' => 'day'],
        'star anise'      => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],
        'cumin'           => ['family' => 'oriental', 'intensity' => 'bold',   'time' => 'night'],

        // --- GOURMAND (Family: Gourmand, Intensity: Bold/Medium, Time: Night) ---
        'vanilla'         => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'tonka'           => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'tonka bean'      => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'caramel'         => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'honey'           => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'cacao'           => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'chocolate'       => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'coffee'          => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'praline'         => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'almond'          => ['family' => 'gourmand', 'intensity' => 'subtle', 'time' => 'day'], 
        'milk'            => ['family' => 'gourmand', 'intensity' => 'subtle', 'time' => 'day'],
        'cotton candy'    => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'sugar'           => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
        'marshmallow'     => ['family' => 'gourmand', 'intensity' => 'bold',   'time' => 'night'],
    ],
];
