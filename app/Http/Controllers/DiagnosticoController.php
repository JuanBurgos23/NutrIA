<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiagnosticoController extends Controller
{
    public function mostrarDiagnostico($id)
    {

        // Buscar el diagnóstico con la relación de consulta
        $diagnostico = Diagnostico::findOrFail($id);


        return view('diagnostico.diagnostico', compact('diagnostico'));
    }

    public function historial()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene un paciente asociado
        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->back()->with('error', 'No se encontró un paciente asociado.');
        }


        // Obtener los diagnósticos del paciente con la relación de consulta y otras relaciones necesarias
        $diagnosticos = Diagnostico::with(['consulta.imc', 'consulta.condicion', 'consulta.examen'])
            ->whereHas('consulta', function ($query) use ($paciente) {
                $query->where('id_paciente', $paciente->id_paciente);
            })
            ->get();

        
        // Pasar los diagnósticos a la vista
        return view('diagnostico.historial', compact('diagnosticos'));
    }
    public function historialRangoFecha(Request $request)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene un paciente asociado
        $paciente = $user->paciente;

        if (!$paciente) {
            return redirect()->back()->with('error', 'No se encontró un paciente asociado.');
        }
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $fechaInicio = Carbon::parse($request->input('fecha_inicio'))->startOfDay();
        $fechaFinal = Carbon::parse($request->input('fecha_fin'))->endOfDay();

        // Obtener los diagnósticos del paciente con la relación de consulta y otras relaciones necesarias
        $diagnosticos = Diagnostico::with(['consulta.imc', 'consulta.condicion', 'consulta.examen'])
            ->whereHas('consulta', function ($query) use ($paciente, $fechaInicio, $fechaFinal) {
                $query->where('id_paciente', $paciente->id_paciente)
                    ->whereBetween('fecha_consulta', [$fechaInicio, $fechaFinal]);
            })
            ->get();

        // Pasar los diagnósticos a la vista
        return view('diagnostico.historial', compact('diagnosticos'));
    }

    public function detalleHistorial($id)
    {


        // Obtener los diagnósticos del paciente con la relación de consulta y otras relaciones necesarias
        $diagnosticos = Diagnostico::with(['consulta.imc', 'consulta.condicion', 'consulta.examen'])->findOrFail($id);

        
        // Pasar los diagnósticos a la vista
        return view('diagnostico.detalle_historial', compact('diagnosticos'));
    }
}
