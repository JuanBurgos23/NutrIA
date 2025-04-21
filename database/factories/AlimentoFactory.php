<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alimento>
 */
class AlimentoFactory extends Factory
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
            'caloria' => $this->faker->numberBetween(0, 100),
            'carbohidrato' => $this->faker->numberBetween(0, 100),
            'proteina' => $this->faker->numberBetween(0, 100),
            'grasa' => $this->faker->numberBetween(0, 100),
            'fibra' => $this->faker->numberBetween(0, 100),
            'vitamina' => $this->faker->word(),
            'potacio' => $this->faker->numberBetween(0, 100),
            'id_tipoAlimento' => \App\Models\TipoAlimento::factory(),
        ];
    }
}
