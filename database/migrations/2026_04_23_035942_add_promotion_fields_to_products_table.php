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
            $table->string('promotion_type')->nullable()->comment('discount_percent, buy_one_get_one');
            $table->integer('promotion_value')->nullable()->comment('e.g. 20 for 20% off');
            $table->string('promotion_badge')->nullable()->comment('Custom text like SALE or 1+1 FREE');
            $table->dateTime('promotion_starts_at')->nullable();
            $table->dateTime('promotion_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'promotion_type',
                'promotion_value',
                'promotion_badge',
                'promotion_starts_at',
                'promotion_ends_at',
            ]);
        });
    }
};
