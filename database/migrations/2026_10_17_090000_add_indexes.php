<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Postgres doesn't index foreign-key columns on its own. With 41 phones every query is a
// fast sequential scan anyway; these keep the joins and filters cheap as the catalog grows.
class AddIndexes extends Migration
{
    public function up(): void
    {
        Schema::table('smartphones', function (Blueprint $table) {
            $table->index('brand_id');
            $table->index('color_id');
            $table->index('price');
        });

        Schema::table('images', function (Blueprint $table) {
            $table->index('smartphone_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
        });

        Schema::table('order_smartphone', function (Blueprint $table) {
            // one row per phone in an order; also serves lookups by order_id
            $table->unique(['order_id', 'smartphone_id']);
            $table->index('smartphone_id');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->unique('name');
        });

        Schema::table('colors', function (Blueprint $table) {
            $table->unique('name_en');
        });
    }

    public function down(): void
    {
        Schema::table('smartphones', function (Blueprint $table) {
            $table->dropIndex(['brand_id']);
            $table->dropIndex(['color_id']);
            $table->dropIndex(['price']);
        });

        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex(['smartphone_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('order_smartphone', function (Blueprint $table) {
            $table->dropUnique(['order_id', 'smartphone_id']);
            $table->dropIndex(['smartphone_id']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });

        Schema::table('colors', function (Blueprint $table) {
            $table->dropUnique(['name_en']);
        });
    }
}
