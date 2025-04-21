<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ejercicio>
 */
class EjercicioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'repeticiones' => $this->faker->numberBetween(5, 20),
            'series' => $this->faker->numberBetween(1, 5),
            'descanso' => $this->faker->numberBetween(10, 60), // Duración en minutos
            'id_tipoEjercicio' => \App\Models\Ejercicio::factory(),
        ];
    }
}
