<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartphonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartphones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->float('price')->nullable(false);
            $table->foreignId('brand_id')->constrained('brands');
            $table->longText('description');
            $table->integer('ram');
            $table->string('operating_system');
            $table->integer('os_version');
            $table->float('display_size');
            $table->string('resolution');
            $table->float('height');
            $table->float('width');
            $table->float('thickness');
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
        Schema::dropIfExists('smartphones');
    }
}
