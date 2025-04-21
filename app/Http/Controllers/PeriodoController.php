<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\Horario;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeriodoController extends Controller
{
    public function index()
    {
        // Cargamos los horarios agrupados por período y día
        $diasS = Dia::all();
        $horarios = Horario::with(['periodo', 'dia'])
            ->get()
            ->groupBy('periodo.nombre') // Agrupamos por nombre del período
            ->map(function ($items) {
                return $items->groupBy('dia.nombre'); // Agrupamos por nombre del día dentro de cada período
            });

        return view('periodo.periodo', compact('horarios', 'diasS'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre_periodo' => 'required|string',
            'dias' => 'required|array',
            'horas' => 'required|string', // Verificamos que 'horas' se reciba como cadena y luego lo convertimos
        ]);

        // Recibe el rango de fechas desde el formulario
        $rangoFechas = $request->input('nombre_periodo');

        // Divide el rango de fechas en fecha_inicio y fecha_fin
        [$fechaInicio, $fechaFin] = explode(' - ', $rangoFechas);

        // Formatear las fechas, si es necesario
        $fechaInicio = \Carbon\Carbon::createFromFormat('d / m / Y', trim($fechaInicio))->format('Y-m-d');
        $fechaFin = \Carbon\Carbon::createFromFormat('d / m / Y', trim($fechaFin))->format('Y-m-d');

        // Guarda el periodo en la base de datos
        $periodo = new Periodo();
        $periodo->nombre = $request->nombre;
        $periodo->fecha_inicio = $fechaInicio;
        $periodo->fecha_fin = $fechaFin;
        $periodo->save();

        // Obtener los IDs de los días seleccionados
        $diasSeleccionados = $request->input('dias'); // Array de IDs de días

        // Procesar las horas seleccionadas
        $horasSeleccionadas = explode(',', $request->input('horas'));

        // Insertar en la tabla 'horario' para cada combinación de día y hora seleccionada
        foreach ($diasSeleccionados as $diaId) {
            foreach ($horasSeleccionadas as $hora) {
                // Crear un registro en la tabla 'horario' con id_periodo, id_dia y hora
                Horario::create([
                    'id_periodo' => $periodo->id,
                    'id_dia' => $diaId,
                    'hora' => $hora,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Periodo registrado con éxito.');
    }

    // Obtener todos los periodos
    // Obtener todos los periodos
    public function obtenerPeriodos()
    {
        $periodos = Periodo::all();
        return response()->json($periodos);
    }

    public function obtenerDias($idPeriodo)
    {
        $dias = Dia::whereHas('horarios', function ($query) use ($idPeriodo) {
            $query->where('id_periodo', $idPeriodo);
        })->get();
        return response()->json($dias);
    }

    public function obtenerHoras($idDia)
    {
        $horas = Horario::where('id_dia', $idDia)->get();
        return response()->json($horas);
    }
}
