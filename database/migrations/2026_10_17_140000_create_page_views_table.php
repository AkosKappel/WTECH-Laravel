<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// One row per page view, for the admin statistics. No IP address and no cookie: visitors are
// told apart by a hash of IP and browser that is salted per day, so a visitor can't be
// followed from one day to the next. Kept for 90 days.
class CreatePageViewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255);
            $table->unsignedBigInteger('smartphone_id')->nullable()->index();
            $table->string('referrer_host', 255)->nullable();
            $table->string('device', 10);
            $table->string('browser', 20);
            $table->char('visitor', 16);
            $table->timestamp('created_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
}
