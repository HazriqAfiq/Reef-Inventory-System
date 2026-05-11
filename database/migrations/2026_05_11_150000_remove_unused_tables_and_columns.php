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
        // Drop wishlists table if it exists
        Schema::dropIfExists('wishlists');

        // Drop loyalty_points column from users
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'loyalty_points')) {
                $table->dropColumn('loyalty_points');
            }
        });

        // Drop points and discount columns from orders
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['points_earned', 'points_redeemed', 'discount_amount'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('loyalty_points')->default(0)->after('email');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('points_earned')->default(0)->after('total_price');
            $table->integer('points_redeemed')->default(0)->after('points_earned');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('points_redeemed');
        });
    }
};
