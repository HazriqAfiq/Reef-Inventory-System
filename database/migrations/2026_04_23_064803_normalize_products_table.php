<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration:
     * 1. Migrates existing 'category' and 'type' string data to the new lookup tables
     * 2. Adds foreign key columns to products
     * 3. Assigns the new IDs
     * 4. Drops the old string columns
     */
    public function up(): void
    {
        // ── Step 1: Migrate existing product strings to lookup tables ──────────

        // Get all distinct, non-null categories from products
        $categories = DB::table('products')
            ->select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        foreach ($categories as $cat) {
            DB::table('categories')->insertOrIgnore([
                'name'       => $cat,
                'slug'       => Str::slug($cat),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get all distinct, non-null types from products
        $types = DB::table('products')
            ->select('type')
            ->whereNotNull('type')
            ->where('type', '!=', '')
            ->distinct()
            ->pluck('type');

        foreach ($types as $type) {
            DB::table('product_types')->insertOrIgnore([
                'name'       => $type,
                'slug'       => Str::slug($type),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── Step 2: Add new FK columns to products (nullable for migration) ────
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('category')->constrained('categories')->nullOnDelete();
            $table->foreignId('product_type_id')->nullable()->after('type')->constrained('product_types')->nullOnDelete();
        });

        // ── Step 3: Populate the new FK columns ───────────────────────────────
        $products = DB::table('products')->get(['id', 'category', 'type']);

        foreach ($products as $product) {
            $categoryId = null;
            if (!empty($product->category)) {
                $categoryId = DB::table('categories')
                    ->where('name', $product->category)
                    ->value('id');
            }

            $productTypeId = null;
            if (!empty($product->type)) {
                $productTypeId = DB::table('product_types')
                    ->where('name', $product->type)
                    ->value('id');
            }

            DB::table('products')->where('id', $product->id)->update([
                'category_id'     => $categoryId,
                'product_type_id' => $productTypeId,
            ]);
        }

        // ── Step 4: Drop old string columns ───────────────────────────────────
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add old string columns
        Schema::table('products', function (Blueprint $table) {
            $table->string('type', 50)->nullable()->after('slug');
            $table->string('category', 50)->nullable()->after('type');
        });

        // Repopulate strings from lookup tables (best-effort)
        $products = DB::table('products')->get(['id', 'category_id', 'product_type_id']);
        foreach ($products as $product) {
            $category = DB::table('categories')->where('id', $product->category_id)->value('name');
            $type     = DB::table('product_types')->where('id', $product->product_type_id)->value('name');
            DB::table('products')->where('id', $product->id)->update([
                'category' => $category,
                'type'     => $type,
            ]);
        }

        // Drop the FK columns
        Schema::table('products', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropConstrainedForeignId('product_type_id');
        });
    }
};
