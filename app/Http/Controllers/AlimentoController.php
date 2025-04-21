<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use App\Models\TipoAlimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlimentoController extends Controller
{
    public function index()
    {
        $tiposAlimentos = TipoAlimento::all();
        $alimentos = Alimento::with('tipoAlimento')->get();
        return view('alimento.alimento', compact('alimentos', 'tiposAlimentos'));
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'nombreAlimento' => 'required|string|max:255',
            'alimentos' => 'required|array',
            'alimentos.*.nombre' => 'required|string|max:255',
            'alimentos.*.caloria' => 'nullable|string',
            'alimentos.*.carbohidrato' => 'nullable|string',
            'alimentos.*.proteina' => 'nullable|string',
            'alimentos.*.grasa' => 'nullable|string',
            'alimentos.*.fibra' => 'nullable|string',
            'alimentos.*.vitamina' => 'nullable|string|max:255',
            'alimentos.*.potacio' => 'nullable|string',
           
        ]);

        // Buscar o crear el tipo de alimento
        $tipoAlimento = TipoAlimento::firstOrCreate(['nombre' => $validatedData['nombreAlimento']]);

        // Guardar los alimentos asociados
        foreach ($validatedData['alimentos'] as $key=> $alimentoData) {
            $alimento = new Alimento();
            $alimento->nombre = $alimentoData['nombre'];
            $alimento->caloria = $alimentoData['caloria'] ?? null;
            $alimento->carbohidrato = $alimentoData['carbohidrato'] ?? null;
            $alimento->proteina = $alimentoData['proteina'] ?? null;
            $alimento->grasa = $alimentoData['grasa'] ?? null;
            $alimento->fibra = $alimentoData['fibra'] ?? null;
            $alimento->vitamina = $alimentoData['vitamina'] ?? null;
            $alimento->potacio = $alimentoData['potacio'] ?? null;
            $alimento->id_tipoAlimento = $tipoAlimento->id;

            // Manejo de la imagen de cada alimento
            if ($request->hasFile("alimentos.{$key}.imagen")) {  // Cambia "alimentos.{$key}.imagen" a "imagen"
                $file = $request->file("alimentos.{$key}.imagen");
                $destinoPath = 'alimento_imagenes/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path($destinoPath), $filename);

                $alimento->nombreImagen = $destinoPath . $filename; // Guarda la ruta de la imagen
            }

            // Guardar cada alimento
            $alimento->save();
        }

        return redirect()->back()->with('success', 'Alimento registrado con éxito.');
    }
    public function edit($id)
    {
        // Carga el cuarto junto con sus relaciones de dimension e imagenes
        $alimentos = Alimento::with(['tipoAlimento'])->find($id);

        // Verifica si el alimento fue encontrado
        if (!$alimentos) {
            return response()->json(['error' => 'alimento no encontrado'], 404);
        }

        // Devuelve el cuarto como respuesta JSON
        return response()->json($alimentos);
    }

    public function update(Request $request, $id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento) {
            return redirect()->back()->with('error', 'alimento no encontrado');
        }

        $alimento->nombre = $request->nombre;
        $alimento->caloria = $request->caloria;
        $alimento->carbohidrato = $request->carbohidrato;
        $alimento->proteina = $request->proteina;
        $alimento->grasa = $request->grasa;


        // Manejo de una sola imagen
        if ($request->hasFile('imagen')) {  // Cambia "alimentos.{$key}.imagen" a "imagen"
            $file = $request->file('imagen');
            $destinoPath = 'alimento_imagenes/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path($destinoPath), $filename);

            $alimento->nombreImagen = $destinoPath . $filename; // Guarda la ruta de la imagen
        }

        $alimento->save();

        return redirect()->back()->with('success', 'Cuarto actualizado correctamente');
    }


    public function deleteImage($id)
    {
        $alimento = Alimento::find($id);

        if (!$alimento || !$alimento->nombreImagen) {
            return response()->json(['success' => false, 'message' => 'Imagen no encontrada.']);
        }

        // Ruta completa de la imagen
        $imagePath = public_path($alimento->nombreImagen); // Asumiendo que está en 'public'

        if (file_exists($imagePath)) {
            unlink($imagePath); // Eliminar archivo físico
            $alimento->nombreImagen = null; // Eliminar referencia de la base de datos
            $alimento->save();

            return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente.']);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo eliminar la imagen.']);
    }
}
