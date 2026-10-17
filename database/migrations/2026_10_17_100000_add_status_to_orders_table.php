<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// An order's progress, set by admins; replaces the never used "paid" flag.
class AddStatusToOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status', 20)->default('new')->after('total_price');
            $table->dropColumn('paid');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('paid')->default(false)->after('total_price');
            $table->dropColumn('status');
        });
    }
}
