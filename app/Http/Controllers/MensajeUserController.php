<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeNotificacion;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;

class MensajeUserController extends Controller
{
    public function show($id)
    {
        // Obtener el usuario autenticado
        $user = auth()->user();
        // Obtener el registro del paciente relacionado con el usuario autenticado
        $paciente = Paciente::where('id_user', $user->id)->first();
        $mensaje = MensajeNotificacion::findOrFail($id);
        $mensaje->update(['read' => true]);
        // Si quieres que la pestaña de mensajes sea la predeterminada
        session(['show_messages' => true]);

        return view('mensajes.show', compact('mensaje', 'paciente'));
    }

    public function markAsRead($id)
    {
        $mensaje = MensajeNotificacion::findOrFail($id);
        $mensaje->update(['read' => true]);

        return response()->json(['success' => true, 'redirect_url' => route('mensajeUser.show', $mensaje->id)]);
    }

    public function mostrar()
    {
        $user = Auth::user();

        $mensajes = MensajeNotificacion::where('id_user', $user->id)->get();
        // Obtener el registro del paciente relacionado con el usuario autenticado
        $paciente = Paciente::where('id_user', $user->id)->first();

        return view('perfil.perfil', compact('mensajes', 'paciente'));
    }
}
