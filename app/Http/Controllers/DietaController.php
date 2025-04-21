<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Models\DetalleDieta;
use App\Models\Dieta;
use App\Models\TipoAlimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DietaController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::with('tipoAlimento')->get(); // Cargar relación
        $tiposDeAlimentos = TipoAlimento::all();
        $dietas = Dieta::with(['detalleDietas2.alimento', 'detalleDietas2.horario', 'detalleDietas2.periodo', 'detalleDietas2.dia'])
            ->get();
        return view('dieta.dieta', compact('alimentos', 'tiposDeAlimentos', 'dietas'));
    }

    public function store(Request $request)
    {
       
        // Buscar o crear el tipo de alimento
       $dieta = Dieta::firstOrCreate(['nombre' => $request->nombreDieta,'descripcion' =>$request->descripcionDieta]);

        // Procesar alimentos seleccionados
        $alimentosSeleccionados = explode(',', $request->alimentosSeleccionados);
        $alimentosIds = array_map(function ($alimento) {
            return explode('_', $alimento)[0];  // Tomamos el ID del alimento
        }, $alimentosSeleccionados);

        // Procesar periodos, días y horas
        $periodos = $request->input('periodos', []);
        $dias = $request->input('dias', []);
        $horas = $request->input('horas', []);

        // Verificar la longitud de los arrays
        if (count($periodos) !== count($dias) || count($dias) !== count($horas)) {
            return response()->json(['error' => 'Los datos de periodos, días y horas no coinciden.'], 400);
        }

        // Iterar sobre los alimentos seleccionados y registrar los detalles
        foreach ($alimentosIds as $index => $alimentoId) {
            $periodoId = $periodos[$index];  // Obtener periodo
            $dia = $dias[$index];  // Obtener día
            $hora = $horas[$index];  // Obtener hora

            // Registrar el detalle en la tabla DetalleDieta
            DetalleDieta::create([
                'id_dieta' => $dieta->id,  // Usar el id de la dieta recién creada
                'id_alimento' => $alimentoId,  // Id del alimento
                'id_periodo' => $periodoId,  // Id del periodo
                'id_dia' => $dia,  // Id del día
                'id_horario' => $hora,  // Id de la hora
            ]);

            // Log para verificar que se ha insertado correctamente
            Log::info("Registro insertado para: Alimento ID: $alimentoId, Periodo ID: $periodoId, Dia: $dia, Hora: $hora");
        }

        // Redirigir con éxito
        return redirect()->back()->with('success', 'Dieta registrada con éxito.');
    }
}
