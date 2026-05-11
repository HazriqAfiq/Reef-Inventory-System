<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── 1. Admin account ────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // ── 2. Reseller account ─────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'reseller@reseller.com'],
            [
                'name'            => 'Reseller Partner',
                'password'        => Hash::make('password'),
                'role'            => 'reseller',
                'commission_rate' => 15.00,
                'monthly_goal'    => 5000.00,
            ]
        );

        // ── 3. Product catalog ──────────────────────────────────────────────
        $this->call(ProductSeeder::class);



        // ── 5. Storefront Settings ─────────────────────────────────────────
        $this->call(StorefrontSettingsSeeder::class);
    }
}
