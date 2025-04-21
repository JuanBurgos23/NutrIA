<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Condicion>
 */
class CondicionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'operaciones' => $this->faker->randomElement(['Cardiovascular', 'Cadera', 'Brazo', 'Pierna']),
            'alergia' => $this->faker->randomElement(['Ninguna', 'Polen', 'Alimentos', 'Medicamentos']),
            'discapacidad' => $this->faker->randomElement(['Ninguna', 'Auditiva', 'Visual', 'Motora']),
        ];
    }
}
