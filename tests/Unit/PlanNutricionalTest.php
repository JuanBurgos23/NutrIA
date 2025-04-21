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

    /** @test */
    public function plan_nutricional_pertenece_a_un_periodo()
    {
        $periodo = Periodo::factory()->create();
        $plan = PlanNutricional::factory()->create(['id_periodo' => $periodo->id]);

        $this->assertInstanceOf(Periodo::class, $plan->periodo);
        $this->assertEquals($periodo->id, $plan->periodo->id);
    }

    /** @test */
    public function plan_nutricional_pertenece_a_una_dieta()
    {
        $dieta = Dieta::factory()->create();
        $plan = PlanNutricional::factory()->create(['id_dieta' => $dieta->id]);

        $this->assertInstanceOf(Dieta::class, $plan->dieta);
        $this->assertEquals($dieta->id, $plan->dieta->id);
    }

    /** @test */
    public function plan_nutricional_pertenece_a_un_diagnostico()
    {
        $diagnostico = Diagnostico::factory()->create();
        $plan = PlanNutricional::factory()->create(['id_diagnostico' => $diagnostico->id]);

        $this->assertInstanceOf(Diagnostico::class, $plan->diagnostico);
        $this->assertEquals($diagnostico->id, $plan->diagnostico->id);
    }

    /** @test */
    public function plan_nutricional_tiene_muchos_ejercicios()
    {
        $plan = PlanNutricional::factory()->create();
        $ejercicio = Ejercicio::factory()->create();

        $plan->ejercicios()->attach($ejercicio->id);

        $this->assertTrue($plan->ejercicios->contains($ejercicio));
    }
}
