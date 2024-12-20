<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->city();
        return [
            'external_id' => fake()->uuid(),
            'name' => $name,
            'name_ascii' => $name,
            'population' => fake()->numberBetween(500, 1000000),
            'capital' => '',
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude()
        ];
    }
}
