<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ColorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $colors = ['red' => 'červená', 'green' => 'zelená', 'blue' => 'modrá', 'yellow' => 'žltá',
            'purple' => 'fialová', 'pink' => 'ružová', 'white' => 'biela', 'gray' => 'sivá', 'black' => 'čierna'];
        $name = $this->faker->unique()->randomElement(array_keys($colors));

        return [
            'name_en' => $name,
            'name_sk' => $colors[$name],
        ];
    }
}
