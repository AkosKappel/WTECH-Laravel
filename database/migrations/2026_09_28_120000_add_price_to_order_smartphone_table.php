<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToOrderSmartphoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_smartphone', function (Blueprint $table) {
            // unit price at the time of the order, so later price changes don't alter past orders
            $table->float('price')->nullable()->after('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_smartphone', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
}
