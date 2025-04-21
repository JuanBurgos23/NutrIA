<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EjercicioDia>
 */
class EjercicioDiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_ejercicio' => \App\Models\Ejercicio::factory(),
            'id_dia' => \App\Models\Dia::factory(),
        ];
    }
}
