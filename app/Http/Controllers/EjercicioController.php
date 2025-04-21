<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\Ejercicio;
use App\Models\EjercicioDia;
use App\Models\TipoEjercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function index()
    {
        $tipoEjercicio = TipoEjercicio::all();
        // Obtener todos los días
        $diasE = Dia::all();

        // Obtén todos los ejercicios con sus relaciones (tipo de ejercicio y días)
        $ejercicios = Ejercicio::with(['tipoEjercicio', 'dias'])->get();

        // Pasar datos a la vista
        return view('ejercicio.ejercicio', compact('ejercicios', 'diasE','tipoEjercicio'));
    }


    // Método para guardar un nuevo ejercicio
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'nombreTipoEjercicio' => 'required|string|max:255',
            'ejercicios' => 'required|array',
            'ejercicios.*.nombreEjercicio' => 'required|string|max:255',
            'ejercicios.*.descripcion' => 'nullable|string',
            'ejercicios.*.series' => 'nullable|string',
            'ejercicios.*.repeticiones' => 'nullable|string',
            'ejercicios.*.descanso' => 'nullable|string',

        ]);

       // Buscar o crear el tipo de alimento
       $tipoEjercicio = TipoEjercicio::firstOrCreate(['nombre' => $validatedData['nombreTipoEjercicio']]);

        // Obtener los IDs de los días seleccionados
        $diasSeleccionados = $request->input('dias'); // Array de IDs de días

        // Guardar los ejercicios asociados al tipo de ejercicio
        foreach ($validatedData['ejercicios'] as $ejercicioData) {
            $ejercicio = new Ejercicio();
            $ejercicio->nombre = $ejercicioData['nombreEjercicio'];
            $ejercicio->descripcion = $ejercicioData['descripcion'] ?? null;
            $ejercicio->series = $ejercicioData['series'] ?? null;
            $ejercicio->repeticiones = $ejercicioData['repeticiones'] ?? null;
            $ejercicio->descanso = $ejercicioData['descanso'] ?? null;
            $ejercicio->id_tipoEjercicio = $tipoEjercicio->id;

            // Guardar el ejercicio
            $ejercicio->save();

            // Asociar los días al ejercicio
            foreach ($diasSeleccionados as $diaId) {
                EjercicioDia::create([
                    'id_ejercicio' => $ejercicio->id,
                    'id_dia' => $diaId,
                ]);
            }
        }

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Ejercicios y días registrados con éxito.');
    }
}
