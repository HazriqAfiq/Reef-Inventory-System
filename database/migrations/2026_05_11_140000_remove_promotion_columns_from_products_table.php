<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'promotion_type',
                'promotion_value',
                'promotion_badge',
                'promotion_badge_color',
                'promotion_starts_at',
                'promotion_ends_at',
                'promotion_min_qty',
                'promotion_min_amount',
                'promotion_target',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('promotion_type')->nullable();
            $table->integer('promotion_value')->nullable();
            $table->string('promotion_badge')->nullable();
            $table->string('promotion_badge_color')->default('bg-red-600')->nullable();
            $table->dateTime('promotion_starts_at')->nullable();
            $table->dateTime('promotion_ends_at')->nullable();
            $table->integer('promotion_min_qty')->default(1)->nullable();
            $table->decimal('promotion_min_amount', 10, 2)->default(0)->nullable();
            $table->enum('promotion_target', ['all', 'direct', 'reseller'])->default('all')->nullable();
        });
    }
};
