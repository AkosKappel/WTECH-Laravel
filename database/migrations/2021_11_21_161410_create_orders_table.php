<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('total_price')->unsigned();
            $table->boolean('paid')->default(false);
            $table->foreignId('user_id')->constrained('users');
            $table->string('delivery_method');
            $table->string('payment_method');
            $table->timestamps();
        });

        Schema::create('order_smartphone', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->foreignId('smartphone_id')->constrained('smartphones');
            $table->foreignId('order_id')->constrained('orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_smartphone');
        Schema::dropIfExists('orders');
    }
}
