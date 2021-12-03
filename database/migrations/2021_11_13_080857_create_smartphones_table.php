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
            $table->float('quantity')->nullable(false);
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('color_id')->nullable()->constrained('colors');
            $table->longText('description')->nullable();
            $table->integer('ram')->nullable();
            $table->string('operating_system')->nullable();
            $table->integer('os_version')->nullable();
            $table->float('display_size')->nullable();
            $table->string('resolution')->nullable();
            $table->float('height')->nullable();
            $table->float('width')->nullable();
            $table->float('thickness')->nullable();
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
