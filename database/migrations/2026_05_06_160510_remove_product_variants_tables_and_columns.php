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
        Schema::disableForeignKeyConstraints();

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropIndex('order_items_order_variant_idx');
            $table->dropColumn('product_variant_id');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropIndex('sales_product_variant_created_idx');
            $table->dropColumn('product_variant_id');
        });

        Schema::table('reseller_stocks', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
        });

        Schema::dropIfExists('product_variants');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // One-way migration.
    }
};
