<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consulta>
 */
class ConsultaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'motivo' => $this->faker->sentence,
            'objetivo' => $this->faker->sentence,
            'fecha_consulta' => $this->faker->dateTime,
            'id_imc' => \App\Models\Imc::factory(),
            'id_condicion' => \App\Models\Condicion::factory(),
            'id_examen' => \App\Models\Examen::factory(),
            'id_paciente' => \App\Models\Paciente::factory(),
        ];
    }
}
