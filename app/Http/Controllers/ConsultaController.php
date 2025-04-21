<?php

namespace App\Http\Controllers;

use App\Models\Condicion;
use App\Models\Consulta;
use App\Models\Diagnostico;
use App\Models\Examen;
use App\Models\Imc;
use App\Models\Paciente;
use App\Models\TipoExamen;
use Database\Seeders\TipoExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http; // Importa la clase HTTP
use Illuminate\Http\JsonResponse;

class ConsultaController extends Controller
{
    public function index()
    {
        $tipoExamen = TipoExamen::all();
        return view('consulta.consulta', compact('tipoExamen'));
    }
    public function registro()
    {
        return view('consulta.registro');
    }
    public function mostrarConsultas()
    {
        $consultas = Consulta::with('paciente', 'imc')->get();

        return view('consulta.mostrar_consulta', compact('consultas'));
    }


    public function storeConsulta(Request $request)
    {
        // Crear la consulta
        $consulta = new Consulta();
        $consulta->objetivo = $request->objetivo;
        $consulta->motivo = $request->motivo;
        $consulta->fecha_consulta = $request->fecha_consulta;
        $consulta->save();

        // Redirigir a la siguiente vista pasando el id de la consulta creada
        return redirect()->route('consulta', ['consulta_id' => $consulta->id])
            ->with('success', 'Consulta registrada. Ahora ingresa los datos adicionales.');
    }


    public function store(Request $request)
    {
        // Validar la existencia de consulta_id
        $consulta_id = $request->input('consulta_id');

        if (!$consulta_id) {
            return redirect()->back()->withErrors(['error' => 'Consulta no encontrada.']);
        }

        // Buscar la consulta
        $consulta = Consulta::find($consulta_id);
        if (!$consulta) {
            return redirect()->back()->withErrors(['error' => 'Consulta no encontrada.']);
        }

        // Crear registros de IMC, Condición y Examen
        $imc = new Imc();
        $imc->peso = $request->peso;
        $imc->altura = $request->altura;
        $imc->save();

        $condicion = new Condicion();
        $condicion->operaciones = $request->operaciones;
        $condicion->alergia = $request->alergia;
        $condicion->discapacidad = $request->discapacidad;
        $condicion->save();

        $examen = new Examen();
        $examen->descripcion = $request->descripcion;
        $examen->id_tipoExamen = $request->examen;
        $examen->save();

        // Asignar los registros a la consulta
        $consulta->id_imc = $imc->id;
        $consulta->id_condicion = $condicion->id;
        $consulta->id_examen = $examen->id;

        $paciente = Paciente::where('id_user', auth()->user()->id)->first();
        if ($paciente) {
            $consulta->id_paciente = $paciente->id_paciente;
        } else {
            return redirect()->back()->with('error', 'No se encontró el paciente asociado con el usuario.');
        }
        $consulta->save();

        // Preparar los datos para la API
        $datosAPI = [
            "peso" => $imc->peso,
            "altura" => $imc->altura,
            "objetivo" => $consulta->objetivo,
            "motivo" => $consulta->motivo,
            "condicion" => $condicion->operaciones ?: 'ninguna',
            "alergia" => $condicion->alergia ?: 'ninguna',
            "discapacidad" => $condicion->discapacidad ?: 'ninguna',
            "enfermedades" => $examen->descripcion ?: 'ninguna',
        ];

        try {
            // Enviar datos a la API externa
            $response = Http::post('https://magicloops.dev/api/loop/d269036f-1fb6-4544-b8d7-36c95f6a9d1d/run', $datosAPI);

            if ($response->successful()) {
                // Capturar el resultado de la API
                $resultado = $response->json();

                // Asegúrate de que $resultado contenga el texto completo que quieres guardar
                $detalleDiagnostico = $resultado ?? 'Diagnóstico no especificado'; // Ajusta la clave según el campo devuelto

                // Extraer la sección de recomendaciones usando una expresión regular
                preg_match('/#### Recomendaciones(.*)/s', $detalleDiagnostico, $coincidencias);

                // Guardar las recomendaciones y el resto del texto por separado
                $recomendacion = $coincidencias[1] ?? ''; // Captura la sección de recomendaciones
                $detalle = preg_replace('/#### Recomendaciones.*/s', '', $detalleDiagnostico); // Elimina la sección de recomendaciones

                // Crear el registro en la tabla diagnostico
                $diagnostico = new Diagnostico();
                $diagnostico->detalle = trim($detalle); // Guarda la parte del detalle
                $diagnostico->recomendacion = trim($recomendacion); // Guarda la parte de las recomendaciones
                $diagnostico->id_consulta = $consulta->id; // Relacionar el diagnóstico con la consulta
                $diagnostico->save();

                // Redirigir a la vista de consulta con éxito
                return redirect()->route('diagnostico', ['id' => $diagnostico->id])
                    ->with('success', 'Consulta y diagnóstico registrados correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error en la API externa: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
