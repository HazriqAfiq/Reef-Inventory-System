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
            $table->integer('promotion_min_qty')->default(1)->nullable()->after('promotion_ends_at');
            $table->decimal('promotion_min_amount', 10, 2)->default(0)->nullable()->after('promotion_min_qty');
            $table->enum('promotion_target', ['all', 'direct', 'reseller'])->default('all')->nullable()->after('promotion_min_amount');
            $table->string('promotion_badge_color')->default('bg-red-600')->nullable()->after('promotion_badge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
