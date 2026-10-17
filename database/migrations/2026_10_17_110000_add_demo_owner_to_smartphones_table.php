<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Products created by visitors with a demo admin account. They are hidden from the shop and
// only demo admins (and the real admin) see them; the nightly reset removes them.
class AddDemoOwnerToSmartphonesTable extends Migration
{
    public function up(): void
    {
        Schema::table('smartphones', function (Blueprint $table) {
            $table->foreignId('demo_owner_id')->nullable()->after('color_id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('smartphones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('demo_owner_id');
        });
    }
}
