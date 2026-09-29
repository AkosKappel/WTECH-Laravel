<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Smartphone;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Test image',
            'source' => 'images/no_img_available.jpg',
            'smartphone_id' => Smartphone::factory(),
        ];
    }
}
