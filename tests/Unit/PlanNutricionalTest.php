<?php

namespace Tests\Unit;

use App\Models\PlanNutricional;
use App\Models\Periodo;
use App\Models\Dieta;
use App\Models\Diagnostico;
use App\Models\Ejercicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanNutricionalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function el_modelo_usa_la_tabla_correcta()
    {
        $this->assertEquals('plan_nutricional', (new PlanNutricional)->getTable());
    }

    /** @test */
    public function los_fillable_estan_definidos_correctamente()
    {
        $this->assertEquals([
            'id',
            'descripcion',
            'estado',
            'id_periodo',
            'id_dieta',
            'id_diagnostico',
        ], (new PlanNutricional)->getFillable());
    }
}
