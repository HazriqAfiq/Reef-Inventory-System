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

        // ── 2. Buyer account ────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name'     => 'John Buyer',
                'password' => Hash::make('password'),
                'role'     => 'buyer',
            ]
        );

        // ── 3. Product catalog ──────────────────────────────────────────────
        $this->call(ProductSeeder::class);

        // ── 4. Resellers + realistic 6-month sales history ──────────────────
        $this->call(SalesSeeder::class);
    }
}
