<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Imc>
 */
class ImcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'peso' => $this->faker->randomFloat(2, 40, 150),
            'altura' => $this->faker->randomFloat(2, 1.5, 2.5),
        ];
    }
}
