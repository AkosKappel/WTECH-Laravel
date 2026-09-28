<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EnableFuzzySearch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // trigram similarity for typo-tolerant search, unaccent so "Slovencina" finds "Slovenčina"
        DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm');
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent');
        DB::statement('CREATE INDEX IF NOT EXISTS smartphones_name_trgm_index ON smartphones USING gin (lower(name) gin_trgm_ops)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX IF EXISTS smartphones_name_trgm_index');
    }
}
