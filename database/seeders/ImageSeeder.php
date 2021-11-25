<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = new Image([
            'name' => 'Xiaomi smartphone',
            'source' => '/images/smartphone-1.jpg',
            'smartphone_id' => 2,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung smartphone',
            'source' => '/images/smartphone-2.jpg',
            'smartphone_id' => 1,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple smartphone',
            'source' => '/images/smartphone-3.jpg',
            'smartphone_id' => 3,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi smartphone',
            'source' => '/images/smartphone-4.jpg',
            'smartphone_id' => 8,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Huawei smartphone',
            'source' => '/images/smartphone-5.jpg',
            'smartphone_id' => 10,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung smartphone',
            'source' => '/images/smartphone-6.jpg',
            'smartphone_id' => 2,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple smartphone',
            'source' => '/images/smartphone-7.jpg',
            'smartphone_id' => 3,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple smartphone',
            'source' => '/images/smartphone-8.jpg',
            'smartphone_id' => 4,
        ]);
        $image->save();
        $image = new Image([
            'name' => 'Apple smartphone',
            'source' => '/images/smartphone-9.jpg',
            'smartphone_id' => 4,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Sony smartphone',
            'source' => '/images/smartphone-10.jpg',
            'smartphone_id' => 17,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Nokia smartphone',
            'source' => '/images/smartphone-11.jpg',
            'smartphone_id' => 14,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Lenovo smartphone',
            'source' => '/images/smartphone-12.jpg',
            'smartphone_id' => 13,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung smartphone',
            'source' => '/images/smartphone-13.jpg',
            'smartphone_id' => 7,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung smartphone',
            'source' => '/images/smartphone-14.jpg',
            'smartphone_id' => 6,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung smartphone',
            'source' => '/images/smartphone-15.jpg',
            'smartphone_id' => 5,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi smartphone',
            'source' => '/images/smartphone-16.jpg',
            'smartphone_id' => 9,
        ]);
        $image->save();
        $image = new Image([
            'name' => 'Sony smartphone',
            'source' => '/images/smartphone-17.jpg',
            'smartphone_id' => 18,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Sony smartphone',
            'source' => '/images/smartphone-18.jpg',
            'smartphone_id' => 16,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Nokia smartphone',
            'source' => '/images/smartphone-19.jpg',
            'smartphone_id' => 15,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Huawei smartphone',
            'source' => '/images/smartphone-20.jpg',
            'smartphone_id' => 12,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Huawei smartphone',
            'source' => '/images/smartphone-21.jpg',
            'smartphone_id' => 11,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi smartphone',
            'source' => '/images/smartphone-22.jpg',
            'smartphone_id' => 9,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi smartphone',
            'source' => '/images/smartphone-23.jpg',
            'smartphone_id' => 9,
        ]);
        $image->save();
    }
}
