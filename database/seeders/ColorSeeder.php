<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = new Color(['name_en' => 'red', 'name_sk' => 'červená']);
        $color->save();

        $color = new Color(['name_en' => 'green', 'name_sk' => 'zelená']);
        $color->save();

        $color = new Color(['name_en' => 'blue', 'name_sk' => 'modrá']);
        $color->save();

        $color = new Color(['name_en' => 'yellow', 'name_sk' => 'žltá']);
        $color->save();

        $color = new Color(['name_en' => 'purple', 'name_sk' => 'fialová']);
        $color->save();

        $color = new Color(['name_en' => 'pink', 'name_sk' => 'ružová']);
        $color->save();

        $color = new Color(['name_en' => 'white', 'name_sk' => 'biela']);
        $color->save();

        $color = new Color(['name_en' => 'gray', 'name_sk' => 'sivá']);
        $color->save();

        $color = new Color(['name_en' => 'black', 'name_sk' => 'čierna']);
        $color->save();
    }
}
