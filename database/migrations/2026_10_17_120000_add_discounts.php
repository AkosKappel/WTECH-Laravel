<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sale prices per product (optionally time-limited), discount codes, and the discount on each order.
class AddDiscounts extends Migration
{
    public function up(): void
    {
        Schema::table('smartphones', function (Blueprint $table) {
            $table->float('sale_price')->nullable()->after('price');
            $table->timestamp('sale_starts_at')->nullable()->after('sale_price');
            $table->timestamp('sale_ends_at')->nullable()->after('sale_starts_at');
        });

        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 40)->unique();
            $table->string('type', 10); // percent or fixed
            $table->float('value');
            $table->float('min_order')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('per_customer_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->float('subtotal')->nullable()->after('total_price');
            $table->float('discount')->default(0)->after('subtotal');
            $table->string('discount_code', 40)->nullable()->after('discount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'discount', 'discount_code']);
        });
        Schema::dropIfExists('discount_codes');
        Schema::table('smartphones', function (Blueprint $table) {
            $table->dropColumn(['sale_price', 'sale_starts_at', 'sale_ends_at']);
        });
    }
}
