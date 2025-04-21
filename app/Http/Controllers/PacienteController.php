<?php

namespace App\Http\Controllers;

use App\Models\MensajeNotificacion;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function perfil()
    {
        $user = auth()->user();

        $paciente = null;
        $mensajes = [];

        if ($user->id !== 1) {
            $paciente = Paciente::where('id_user', $user->id)->first();
            $mensajes = MensajeNotificacion::where('id_user', $user->id)->get();
        }

        return view('perfil.perfil', [
            'email' => $user->email,
            'name' => $user->name,
            'paciente' => $paciente,
            'mensajes' => $mensajes,
        ]);
    }

    public function actualizarPerfil(Request $request)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Obtener el registro del paciente relacionado con el usuario
        $paciente = Paciente::where('id_user', $user->id)->first();



        if ($user->id == 1) {
            $user->email = $request->emailUser;
            $user->name = $request->nameUser;
            $user->save();
        } else {
            // Actualizar los datos del usuario
            $user->email = $request->email;
            $user->name = $request->name;
            $user->save();
        }

        // Actualizar los datos del paciente
        if ($paciente) {
            $paciente->nombre = $request->name;
            $paciente->paterno = $request->paterno;
            $paciente->materno = $request->materno;
            $paciente->fecha_nac = $request->fecha_nac;
            $paciente->celular = $request->celular;
            $paciente->direccion = $request->direccion;
            $paciente->save();
        }

        // Redirigir con un mensaje de éxito
        return redirect()->route('perfil')->with('success', 'Datos del usuario y paciente actualizados correctamente');
    }
}
