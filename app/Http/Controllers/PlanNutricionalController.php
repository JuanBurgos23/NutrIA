<?php

namespace App\Http\Controllers;

use App\Mail\PlanNutricionalMail;
use App\Models\Alimento;
use App\Models\DetalleDieta;
use App\Models\Dia;
use App\Models\Diagnostico;
use App\Models\Dieta;
use App\Models\Ejercicio;
use App\Models\EjercicioDia;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\PlanEjercicio;
use App\Models\PlanNutricional;
use App\Models\TipoAlimento;
use App\Models\TipoEjercicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;

class PlanNutricionalController extends Controller
{

    public function index($id)
    {
        // Buscar el plan nutricional por ID
        $planNutricional = PlanNutricional::with([
            'dieta.detalleDietas2.alimento',  // Cargamos los alimentos relacionados
            'dieta.detalleDietas2.horario',   // Cargamos los horarios
            'dieta.detalleDietas2.periodo',   // Cargamos los periodos
            'dieta.detalleDietas2.dia',       // Cargamos los días

        ])->findOrFail($id);

        // Obtén todos los ejercicios con sus relaciones (tipo de ejercicio y días)
        $ejercicios = Ejercicio::with(['tipoEjercicio', 'dias', 'ejercicios'])->get();

        //dd($ejercicios);
        return view('plan_nutricional.plan_nutricional', compact('planNutricional', 'ejercicios'));
    }
    public function planHistorial($id)
    {
        // Buscar el plan nutricional por ID
        $planNutricional = PlanNutricional::with([
            'dieta.detalleDietas2.alimento',  // Cargamos los alimentos relacionados
            'dieta.detalleDietas2.horario',   // Cargamos los horarios
            'dieta.detalleDietas2.periodo',   // Cargamos los periodos
            'dieta.detalleDietas2.dia', // Cargamos los días
            'ejercicios.tipoEjercicio',
            'ejercicios.dias'

        ])->findOrFail($id);

        
        return view('plan_nutricional.plan_nutricional', compact('planNutricional'));
    }
    public function generarPDF($id)
    {
        $planNutricional = PlanNutricional::with([
            'dieta.detalleDietas2.alimento',
            'dieta.detalleDietas2.horario',
            'dieta.detalleDietas2.periodo',
            'dieta.detalleDietas2.dia',
            'ejercicios.tipoEjercicio',
            'ejercicios.dias'
        ])->findOrFail($id);

        $ejercicios = Ejercicio::with(['tipoEjercicio', 'dias', 'ejercicios'])->get();

        $html = view('plan_nutricional.plan_pdf', compact('planNutricional'))->render();
        // Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);


        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        // Renderizar el PDF
        $dompdf->render();

        // Obtener el contenido del PDF como una cadena
        $output = $dompdf->output();

        // Send the email with the PDF attached


        return response()->view('plan_nutricional.plan_pdf', compact('planNutricional', 'ejercicios', 'output'));
    }
    public function enviarPlanPorCorreo($id)
    {
        $planNutricional = PlanNutricional::with([
            'dieta.detalleDietas2.alimento',
            'dieta.detalleDietas2.horario',
            'dieta.detalleDietas2.periodo',
            'dieta.detalleDietas2.dia',
            'ejercicios.tipoEjercicio',
            'ejercicios.dias'
        ])->findOrFail($id);

        // Generar el PDF con estilos y opciones adecuadas
        $pdf = PDF::loadView('plan_nutricional.plan_pdf', compact('planNutricional'))
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true)
            ->setOption('isCssFloatEnabled', true)
            ->setOption('css', public_path('styles/all.min.css'));

        // Obtener el contenido como un string binario
        $pdfContent = $pdf->output();

        // Enviar el correo con el PDF adjunto
        $user = auth()->user();
        Mail::to($user->email)->send(new PlanNutricionalMail($planNutricional, $pdfContent));

        return back()->with('success', 'Plan nutricional enviado con éxito.');
    }

    public function store(Request $request)
    {

        // Validar la existencia de diagnostico_id
        $diagnostico_id = $request->input('diagnostico_id');

        if (!$diagnostico_id) {
            return redirect()->back()->withErrors(['error' => 'Diagnostico no encontrada.']);
        }

        // Buscar el diagnostico
        $diagnostico = Diagnostico::find($diagnostico_id);
        if (!$diagnostico) {
            return redirect()->back()->withErrors(['error' => 'Diagnostico no encontrada.']);
        }


        // Preparar los datos para la API
        $datosAPI = [
            "recomendacion" => $diagnostico->recomendacion,
        ];

        try {
            // Enviar datos a la API externa
            $response = Http::post('https://magicloops.dev/api/loop/d3e77574-b34f-4cf0-969a-fc6c81b85ea6/run', $datosAPI);


            if ($response->successful()) {
                // Capturar el resultado de la API
                $resultado = $response->json();
                // Guardar en la base de datos

                $dieta = new Dieta();
                $dieta->nombre = $resultado["Plan Nutricional y de Ejercicio"]["Nombre de la dieta"];
                $dieta->save();
                // Procesar las fechas
                $fechas = explode(' - ', $resultado["Plan Nutricional y de Ejercicio"]["Fechas de inicio y fin"]);

                // Extrae las fechas desde las coincidencias
                // Configurar Carbon en español
                Carbon::setLocale('es');
                setlocale(LC_TIME, 'es_ES.UTF-8'); // o 'es_MX.UTF-8' según tu servidor

                // Convierte las fechas
                $fechaInicio = Carbon::createFromLocaleFormat('j \d\e F \d\e Y', 'es', trim($fechas[0]))->format('Y-m-d');
                $fechaFin = Carbon::createFromLocaleFormat('j \d\e F \d\e Y', 'es', trim($fechas[1]))->format('Y-m-d');

                //crear periodo
                $periodo = new Periodo();
                $periodo->fecha_inicio = $fechaInicio;
                $periodo->fecha_fin = $fechaFin;
                $periodo->save();


                // Crear el registro en la tabla PlanNutricional dentro del mismo bloque
                $planNutricional = new PlanNutricional();
                $planNutricional->descripcion = $resultado["Plan Nutricional y de Ejercicio"]["Nombre de la dieta"];
                $planNutricional->estado = 'Activo';
                $planNutricional->id_diagnostico = $diagnostico->id;
                $planNutricional->id_periodo = $periodo->id; // Ahora $periodo está garantizado
                $planNutricional->id_dieta = $dieta->id; // Ahora $periodo está garantizado
                $planNutricional->save();

                $tipoAlimento = new TipoAlimento();
                $tipoAlimento->nombre = $resultado["Plan Nutricional y de Ejercicio"]["Tipos de alimentos"];
                $tipoAlimento->save();

                $tipoEjercicio1 = new TipoEjercicio();
                $tipoEjercicio1->nombre = $resultado['Plan Nutricional y de Ejercicio']["Plan de Ejercicio"]['Tipos de ejercicio'];
                $tipoEjercicio1->save();

                // Recorrer cada tipo de comida (Desayuno, Almuerzo, Cena)
                foreach ($resultado["Plan Nutricional y de Ejercicio"]['Plan de Comidas'] as $comida => $diasComida) {
                    // Extraer la hora de la comida desde el string de 'Horario'
                    preg_match("/$comida a las (\d{1,2}:\d{2})/", $resultado["Plan Nutricional y de Ejercicio"]['Horario'], $matches);
                    $horaComida = isset($matches[1]) ? $matches[1] : null;

                    if ($horaComida) {
                        // Recorrer cada día asociado a esta comida
                        foreach ($diasComida as $diaNombre => $menu) {
                            // Limpia el texto del menú eliminando caracteres no visibles y espacios extras
                            $menu = trim(preg_replace('/\s+/', ' ', $menu));
                            $menu = preg_replace('/[\x00-\x1F\x7F]/', '', $menu);  // Elimina caracteres de control ocultos

                            // Verificar si el día existe en la base de datos o crearlo
                            $dia = Dia::firstOrCreate(['nombre' => $diaNombre]);

                            // Expresión regular mejorada para capturar los campos
                            preg_match('/^(.*)\s*\(\s*(\d+)\s*kcal(?:,\s*(\d+)\s*g\s+de\s+proteína)?(?:,\s*(\d+)\s*g\s+de\s+grasa)?(?:,\s*(\d+)\s*g\s+de\s+carbohidratos)?\s*\)$/i', $menu, $matches);

                            $nombreAlimento = trim($matches[1]);
                            $calorias = isset($matches[2]) ? $matches[2] : null;
                            $proteinas = isset($matches[3]) ? $matches[3] : null;
                            $grasas = isset($matches[4]) ? $matches[4] : null;
                            $carbohidratos = isset($matches[5]) ? $matches[5] : null;

                            // Registrar la hora en la tabla de horarios
                            $horario = Horario::create([
                                'id_periodo' => $periodo->id,
                                'id_dia' => $dia->id,
                                'hora' => $horaComida
                            ]);

                            // Registrar el alimento en la base de datos
                            $alimento = Alimento::create([
                                'nombre' => $nombreAlimento,
                                'caloria' => $calorias ?? 0,
                                'proteina' => $proteinas ?? 0,
                                'grasa' => $grasas ?? 0,
                                'carbohidrato' => $carbohidratos ?? 0,
                                'id_tipoAlimento' => $tipoAlimento->id
                            ]);

                            DetalleDieta::create([
                                'id_periodo' => $periodo->id,
                                'id_dia' => $dia->id,
                                'id_horario' => $horario->id,
                                'id_alimento' => $alimento->id,
                                'id_dieta' => $dieta->id
                            ]);
                            Log::info("Alimento registrado correctamente: $nombreAlimento");
                        }
                    }
                }
                //dd($resultado["Plan Nutricional y de Ejercicio"]['Plan de Ejercicio']['Ejercicios']);


                // Recorrer los días de ejercicio (Lunes, Miércoles, Viernes, Sábado)
                // Recorrer los días de ejercicio directamente desde el array "Ejercicios"
                foreach ($resultado["Plan Nutricional y de Ejercicio"]['Plan de Ejercicio']['Ejercicios'] as $diaNombre => $ejerciciosDia) {
                    // Verificar si el día de ejercicio existe en la base de datos o crear uno nuevo
                    $dia = Dia::firstOrCreate(['nombre' => $diaNombre]);

                    // Obtener los ejercicios del día
                    // $ejerciciosDia ya contiene los ejercicios para ese día, no es necesario obtenerlo de otra parte

                    // Recorrer los tipos de ejercicio (Cardio, Fuerza, Flexibilidad)
                    foreach ($ejerciciosDia as $tipoEjercicio => $ejercicio) {
                        // Limpiar el texto del ejercicio
                        $ejercicio = trim(preg_replace('/\s+/', ' ', $ejercicio));
                        $ejercicio = preg_replace('/[\x00-\x1F\x7F]/', '', $ejercicio);

                        // Verificar si el ejercicio ya existe en la base de datos, si no, crear uno nuevo
                        $ejercicioRegistrado = Ejercicio::firstOrCreate([
                            'nombre' => $ejercicio,
                            'series' => $resultado['Plan Nutricional y de Ejercicio']['Plan de Ejercicio']['Series'],
                            'repeticiones' => $resultado['Plan Nutricional y de Ejercicio']['Plan de Ejercicio']['Repeticiones'],
                            'descanso' => $resultado['Plan Nutricional y de Ejercicio']['Plan de Ejercicio']['Períodos de descanso'],
                            'id_tipoEjercicio' => $tipoEjercicio1->id // Relacionado con el tipo de ejercicio
                        ]);

                        // Registrar la relación ejercicio-dia en la tabla intermedia
                        EjercicioDia::create([
                            'id_ejercicio' => $ejercicioRegistrado->id,
                            'id_dia' => $dia->id, // Asociar el ejercicio con el día correspondiente
                        ]);

                        PlanEjercicio::create([
                            'id_planNutricional' => $planNutricional->id,
                            'id_ejercicio' => $ejercicioRegistrado->id
                        ]);

                        Log::info("Ejercicio registrado correctamente: $ejercicio");
                    }
                }

                // Redirigir a la vista de consulta con éxito
                return redirect()->route('plan_nutricional', ['id' => $planNutricional->id])
                    ->with('success', 'Consulta y diagnóstico registrados correctamente.');
            }
        } catch (\Exception $e) {
            Log::info("no hay plan:");
            return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage());
        }
    }
}
