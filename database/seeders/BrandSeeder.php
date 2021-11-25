<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = new Brand(['name' => 'Samsung']);
        $brand->save();

        $brand = new Brand(['name' => 'Huawei']);
        $brand->save();

        $brand = new Brand(['name' => 'Xiaomi']);
        $brand->save();

        $brand = new Brand(['name' => 'Lenovo']);
        $brand->save();

        $brand = new Brand(['name' => 'Nokia']);
        $brand->save();

        $brand = new Brand(['name' => 'Sony']);
        $brand->save();

        $brand = new Brand(['name' => 'Apple']);
        $brand->save();

        $brand = new Brand(['name' => 'Google']);
        $brand->save();
    }
}
