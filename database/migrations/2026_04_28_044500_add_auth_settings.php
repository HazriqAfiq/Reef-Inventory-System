<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('settings')->insert([
            [
                'key' => 'sign_in_image',
                'value' => 'hero/hero_cinematic.png', // Using existing fallback as initial value
                'type' => 'image',
                'group' => 'auth',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'sign_up_image',
                'value' => 'https://images.unsplash.com/photo-1594035910387-fea47794261f?q=80&w=1974&auto=format&fit=crop',
                'type' => 'image',
                'group' => 'auth',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['sign_in_image', 'sign_up_image'])->delete();
    }
};
