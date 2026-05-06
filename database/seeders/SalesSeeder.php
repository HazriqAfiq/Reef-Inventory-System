<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SalesSeeder extends Seeder
{
    /**
     * Generate realistic dummy sales data for Reef Product RPIMS.
     *
     * Simulates:
     *  - 5 authorised resellers with distinct sales personalities
     *  - Sales spread over the last 6 months (Oct 2025 – Mar 2026)
     *  - Peak days: weekends, month-ends, festive periods
     *  - High-selling hero products vs. slow-moving niche items
     *  - Varied quantities (1–10 units) and realistic prices
     */
    public function run(): void
    {
        // ── 1. Create resellers ──────────────────────────────────────────────
        $resellers = $this->createResellers();

        // ── 2. Fetch all products (seeded by ProductSeeder) ─────────────
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Run ProductSeeder first.');
            return;
        }

        // ── 3. Define product popularity weights ────────────────────────────
        // Higher weight = more transactions. Mirrors real fragrance bestseller patterns.
        $popularityWeights = $this->buildPopularityWeights($products);

        // ── 4. Generate transactions ─────────────────────────────────────────
        Sale::query()->delete(); // Clear existing sales for a clean seed

        $this->command->info('Generating sales transactions…');
        $bar = $this->command->getOutput()->createProgressBar(count($resellers));
        $bar->start();

        $start = Carbon::now()->subMonths(6)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        foreach ($resellers as $reseller) {
            $this->generateSalesForReseller($reseller, $products, $popularityWeights, $start, $end);
            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('Sales data seeded successfully. Total records: ' . Sale::count());
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Create 5 realistic reseller accounts.
     */
    private function createResellers(): array
    {
        $resellerData = [
            ['name' => 'Siti Aisyah',    'email' => 'siti@reefreseller.com'],
            ['name' => 'Ahmad Zulkifli', 'email' => 'ahmad@reefreseller.com'],
            ['name' => 'Nurul Hidayah',  'email' => 'nurul@reefreseller.com'],
            ['name' => 'Hafiz Rahman',   'email' => 'hafiz@reefreseller.com'],
            ['name' => 'Farah Nadia',    'email' => 'farah@reefreseller.com'],
        ];

        return collect($resellerData)->map(function ($data) {
            return User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role'     => 'reseller',
                ]
            );
        })->all();
    }

    /**
     * Build a weighted array of product IDs.
     * Products with higher weight appear more in random picks.
     */
    private function buildPopularityWeights($products): array
    {
        // Hero products (bestsellers) — high traffic, repeat buyers
        $heroes = ['Reef 1', 'Reef 15', 'Reef 33', 'Reef 33 White', 'Reef 36', 'Reef 42'];
        // Mid-tier — steady movers
        $midTier = ['Reef 11', 'Reef 19', 'Reef 21', 'Reef 27', 'Reef 31',
                    'Summer Tiffany', 'Summer Pink', 'Reef Blanc Breath', 'Lady Reef'];
        // Niche / slow-movers
        // (everything else)

        $weighted = [];

        foreach ($products as $product) {
            if (in_array($product->name, $heroes)) {
                $weight = 12; // High frequency
            } elseif (in_array($product->name, $midTier)) {
                $weight = 5;  // Medium frequency
            } else {
                $weight = 1;  // Low frequency (niche)
            }

            for ($i = 0; $i < $weight; $i++) {
                $weighted[] = $product;
            }
        }

        return $weighted;
    }

    /**
     * Generate all sales records for a single reseller over the date range.
     */
    private function generateSalesForReseller(
        User   $reseller,
               $products,
        array  $weights,
        Carbon $start,
        Carbon $end
    ): void {
        // Each reseller gets a different volume profile
        $profiles = [
            ['min' => 2, 'max' => 4],   // Consistent medium seller
            ['min' => 4, 'max' => 8],   // Top performer
            ['min' => 1, 'max' => 2],   // Low-volume boutique
            ['min' => 3, 'max' => 6],   // Growing reseller
            ['min' => 1, 'max' => 3],   // Occasional seller
        ];

        static $profileIndex = 0;
        $profile = $profiles[$profileIndex % count($profiles)];
        $profileIndex++;

        // Walk day by day
        $current = $start->copy();

        while ($current->lte($end)) {
            $multiplier = $this->getDayMultiplier($current);

            // Probabilistically decide if this reseller sells today
            $chance = $multiplier * 0.4; // Base 40% chance on normal days
            if (mt_rand(1, 100) > ($chance * 100)) {
                $current->addDay();
                continue;
            }

            // Number of transactions this day (scaled by multiplier)
            $dailyTransactions = (int) round(
                mt_rand($profile['min'], $profile['max']) * $multiplier
            );
            $dailyTransactions = max(1, min($dailyTransactions, 10));

            for ($t = 0; $t < $dailyTransactions; $t++) {
                $product  = $weights[array_rand($weights)];
                $quantity = $this->realisticQuantity($multiplier);
                $price    = round($product->price * $quantity, 2);

                // Spread sales throughout the day (business hours 9am–9pm)
                $saleTime = $current->copy()->setTime(
                    mt_rand(9, 20),
                    mt_rand(0, 59),
                    mt_rand(0, 59)
                );

                DB::table('sales')->insert([
                    'user_id'     => $reseller->id,
                    'product_id'  => $product->id,
                    'quantity'    => $quantity,
                    'total_price' => $price,
                    'created_at'  => $saleTime,
                    'updated_at'  => $saleTime,
                ]);
            }

            $current->addDay();
        }
    }

    /**
     * Return a multiplier based on the day of week and special periods.
     * 1.0 = normal, >1.0 = busier, <1.0 = quieter.
     */
    private function getDayMultiplier(Carbon $date): float
    {
        // Weekends are busier
        $isWeekend = $date->isWeekend();

        // Month-end / pay-day surge (last 3 days of month)
        $isPayDay = $date->day >= ($date->daysInMonth - 2);

        // Festive periods: Eid (Apr 2025 estimation), CNY (Jan-Feb), Christmas (Dec)
        $isFestive = $this->isFestivePeriod($date);

        $multiplier = 1.0;

        if ($isWeekend)  $multiplier += 0.6;
        if ($isPayDay)   $multiplier += 0.5;
        if ($isFestive)  $multiplier += 1.0;

        // Add slight random noise ±15%
        $noise = mt_rand(85, 115) / 100;

        return round($multiplier * $noise, 2);
    }

    /**
     * Detect festive shopping periods.
     */
    private function isFestivePeriod(Carbon $date): bool
    {
        $month = $date->month;
        $day   = $date->day;

        // CNY (Jan 29 – Feb 15 2025, Jan 17 – Feb 5 2026)
        if (($month === 1 && $day >= 17) || ($month === 2 && $day <= 15)) {
            return true;
        }

        // Eid al-Fitr (March 30 – April 5 2025, approximate)
        if ($month === 3 && $day >= 25) return true;
        if ($month === 4 && $day <= 10) return true;

        // Christmas / New Year gifting season
        if ($month === 12 && $day >= 18) return true;
        if ($month === 1  && $day <= 5)  return true;

        return false;
    }

    /**
     * Return a realistic quantity (1–10), weighted toward smaller purchases.
     */
    private function realisticQuantity(float $multiplier): int
    {
        // Weighted distribution: most sales are 1-3 units, peaks allow more
        $weights = [1, 1, 1, 1, 2, 2, 2, 3, 3, 5]; // index+1 = qty, repeated = weight

        $qty = $weights[array_rand($weights)];

        // On peak days, occasionally bulk purchases
        if ($multiplier >= 1.8 && mt_rand(1, 10) === 1) {
            $qty = mt_rand(6, 10);
        }

        return $qty;
    }
}
