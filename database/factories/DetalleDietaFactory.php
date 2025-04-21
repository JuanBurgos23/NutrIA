<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalleDieta>
 */
class DetalleDietaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word(),
            'cantidad' => $this->faker->numberBetween(1, 100),
            'id_dieta' => \App\Models\Dieta::factory(),
            'id_alimento' => \App\Models\Alimento::factory(),
            'id_periodo' => \App\Models\Periodo::factory(),
            'id_dia' => \App\Models\Dia::factory(),
            'id_horario' => \App\Models\Horario::factory(),
        ];
    }
}
