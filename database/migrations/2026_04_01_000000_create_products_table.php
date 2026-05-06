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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50)->unique();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('type', 50)->nullable(); // perfume, spray, etc.
            $table->string('category', 50)->nullable(); // Men, Women, Unisex, etc.
            $table->integer('volume_ml')->nullable();
            $table->text('description')->nullable();
            $table->text('top_note')->nullable();
            $table->text('heart_note')->nullable();
            $table->text('base_note')->nullable();
            $table->decimal('wholesale_price', 10, 2);
            $table->decimal('retail_price', 10, 2);
            $table->integer('stock')->default(0);
            $table->date('release_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
