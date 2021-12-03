<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(BrandSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(SmartphoneSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(UserSeeder::class);
    }
}
