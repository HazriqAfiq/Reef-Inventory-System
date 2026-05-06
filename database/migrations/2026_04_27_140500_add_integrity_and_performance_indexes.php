<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure one review per user-product pair before adding unique index.
        $duplicates = DB::table('product_reviews')
            ->select('user_id', 'product_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('user_id', 'product_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('product_reviews')
                ->where('user_id', $duplicate->user_id)
                ->where('product_id', $duplicate->product_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id'], 'product_reviews_user_product_unique');
            $table->index(['product_id', 'created_at'], 'product_reviews_product_created_idx');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->index(['order_id', 'product_variant_id'], 'order_items_order_variant_idx');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->index(['product_id', 'product_variant_id', 'created_at'], 'sales_product_variant_created_idx');
            $table->index(['user_id', 'created_at'], 'sales_user_created_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex('sales_product_variant_created_idx');
            $table->dropIndex('sales_user_created_idx');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex('order_items_order_variant_idx');
        });

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropUnique('product_reviews_user_product_unique');
            $table->dropIndex('product_reviews_product_created_idx');
        });
    }
};
