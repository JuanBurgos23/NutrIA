<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Paciente;
use Carbon\Carbon;

class PacienteTest extends TestCase
{
    /** @test */
    public function obtiene_el_nombre_completo_correctamente()
    {
        $paciente = new Paciente([
            'nombre' => 'Luis',
            'paterno' => 'Pérez',
            'materno' => 'Lopez'
        ]);

        $this->assertEquals('Luis Pérez Lopez', $paciente->nombre_completo);
    }

    /** @test */
    public function calcula_la_edad_correctamente()
    {
        $fechaNacimiento = Carbon::now()->subYears(25)->format('Y-m-d');

        $paciente = new Paciente([
            'fecha_nac' => $fechaNacimiento
        ]);

        $this->assertEquals(25, $paciente->edad);
    }
   
}
