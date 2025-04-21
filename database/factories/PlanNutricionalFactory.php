<?php

namespace Database\Factories;

use App\Models\PlanNutricional;
use App\Models\Periodo;
use App\Models\Dieta;
use App\Models\Diagnostico;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanNutricionalFactory extends Factory
{
    protected $model = PlanNutricional::class;

    public function definition()
    {
        return [
            'descripcion' => $this->faker->sentence,
            'estado' => 'activo',
            'id_periodo' => Periodo::factory(),
            'id_dieta' => Dieta::factory(),
            'id_diagnostico' => Diagnostico::factory(),
        ];
    }
}
