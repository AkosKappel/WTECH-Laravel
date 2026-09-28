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

        $image = new Image([
            'name' => 'Samsung Galaxy S24 8GB/256GB (illustration)',
            'source' => '/images/products/samsung-galaxy-s24-8gb-256gb.svg',
            'smartphone_id' => 20,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung Galaxy A55 5G 8GB/128GB (illustration)',
            'source' => '/images/products/samsung-galaxy-a55-5g-8gb-128gb.svg',
            'smartphone_id' => 21,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Samsung Galaxy Z Flip6 12GB/256GB (illustration)',
            'source' => '/images/products/samsung-galaxy-z-flip6-12gb-256gb.svg',
            'smartphone_id' => 22,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple iPhone 15 128GB (illustration)',
            'source' => '/images/products/apple-iphone-15-128gb.svg',
            'smartphone_id' => 23,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple iPhone 15 Pro 256GB (illustration)',
            'source' => '/images/products/apple-iphone-15-pro-256gb.svg',
            'smartphone_id' => 24,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Apple iPhone SE 64GB (3rd generation) (illustration)',
            'source' => '/images/products/apple-iphone-se-64gb-3rd-generation.svg',
            'smartphone_id' => 25,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Google Pixel 8 8GB/128GB (illustration)',
            'source' => '/images/products/google-pixel-8-8gb-128gb.svg',
            'smartphone_id' => 26,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Google Pixel 8a 8GB/128GB (illustration)',
            'source' => '/images/products/google-pixel-8a-8gb-128gb.svg',
            'smartphone_id' => 27,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi 14 12GB/512GB (illustration)',
            'source' => '/images/products/xiaomi-14-12gb-512gb.svg',
            'smartphone_id' => 28,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Xiaomi Redmi Note 13 Pro 8GB/256GB (illustration)',
            'source' => '/images/products/xiaomi-redmi-note-13-pro-8gb-256gb.svg',
            'smartphone_id' => 29,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'OnePlus 12 12GB/256GB (illustration)',
            'source' => '/images/products/oneplus-12-12gb-256gb.svg',
            'smartphone_id' => 30,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'OnePlus Nord 4 12GB/256GB (illustration)',
            'source' => '/images/products/oneplus-nord-4-12gb-256gb.svg',
            'smartphone_id' => 31,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Motorola Edge 50 Pro 12GB/512GB (illustration)',
            'source' => '/images/products/motorola-edge-50-pro-12gb-512gb.svg',
            'smartphone_id' => 32,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Motorola Moto G54 5G 8GB/256GB (illustration)',
            'source' => '/images/products/motorola-moto-g54-5g-8gb-256gb.svg',
            'smartphone_id' => 33,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Honor Magic6 Pro 12GB/512GB (illustration)',
            'source' => '/images/products/honor-magic6-pro-12gb-512gb.svg',
            'smartphone_id' => 34,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Honor 200 12GB/512GB (illustration)',
            'source' => '/images/products/honor-200-12gb-512gb.svg',
            'smartphone_id' => 35,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Fairphone 5 8GB/256GB (illustration)',
            'source' => '/images/products/fairphone-5-8gb-256gb.svg',
            'smartphone_id' => 36,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Nothing Phone (2) 12GB/256GB (illustration)',
            'source' => '/images/products/nothing-phone-2-12gb-256gb.svg',
            'smartphone_id' => 37,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Sony Xperia 1 VI 12GB/256GB (illustration)',
            'source' => '/images/products/sony-xperia-1-vi-12gb-256gb.svg',
            'smartphone_id' => 38,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Nokia G42 5G 6GB/128GB (illustration)',
            'source' => '/images/products/nokia-g42-5g-6gb-128gb.svg',
            'smartphone_id' => 39,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Huawei nova 12 SE 8GB/256GB (illustration)',
            'source' => '/images/products/huawei-nova-12-se-8gb-256gb.svg',
            'smartphone_id' => 40,
        ]);
        $image->save();

        $image = new Image([
            'name' => 'Nokia 3210 4G (2024) (illustration)',
            'source' => '/images/products/nokia-3210-4g-2024.svg',
            'smartphone_id' => 41,
        ]);
        $image->save();
    }
}
