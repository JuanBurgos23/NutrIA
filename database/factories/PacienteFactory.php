<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_user' => \App\Models\User::factory(),
            'nombre' => $this->faker->firstName,
            'paterno' => $this->faker->lastName,
            'materno' => $this->faker->lastName,
            'genero' => $this->faker->randomElement(['M', 'F']),
            'edad' => $this->faker->numberBetween(1, 100),
            'fecha_nac' => $this->faker->date(),
            'celular' => $this->faker->phoneNumber,
            'direccion' => $this->faker->address,
        ];
    }
}
