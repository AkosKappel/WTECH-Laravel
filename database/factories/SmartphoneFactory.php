<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\Color;

class SmartphoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Testphone ' . $this->faker->unique()->numerify('####'),
            'price' => $this->faker->randomFloat(2, 100, 1500),
            'quantity' => 10,
            'brand_id' => Brand::factory(),
            'color_id' => Color::factory(),
            'description' => $this->faker->sentence(12),
            'ram' => 8,
            'operating_system' => 'Android',
            'os_version' => 14,
            'display_size' => 6.1,
            'resolution' => '2400x1080',
            'height' => 150.0,
            'width' => 71.5,
            'thickness' => 8.2,
        ];
    }
}
