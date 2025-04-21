<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use App\Models\oficial;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MensajeNotificacion;
use App\Models\Paciente;

class ContactoController extends Controller
{
    public function index()
    {
        $usuarios = User::where('email', 'like', '%@correo.nutria.com')->get();
        return view("reportar.reportar", compact('usuarios'));
    }
    public function correoOficial()
    {
        $pacientes = Paciente::all();
        return view("pages.contacto.correoOficiales", compact('oficiales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asunto' => 'required',
            'nombre' => 'required',
            'correo_remitente' => 'required|email',
            'correo_destino' => 'required|array',
            'correo_destino.*' => 'email',
            'mensaje' => 'required',
        ]);

        $correo = new ContactoMailable($request->all());
        // Determina el mailer a utilizar
        // Iterar sobre los correos de destino y enviar el correo con el mailer adecuado
        foreach ($request->correo_destino as $destino) {
            if (str_contains($destino, 'correo.nutria.com')) {
                Mail::mailer('smtp_local')->to($destino)->send($correo);
            } else {
                Mail::mailer('smtp')->to($destino)->send($correo);
            }

            //dd($destino);
            $user = User::where('email', $destino)->first();
            
            if ($user) {
                //dd($user);
                $mensajeUser = new MensajeNotificacion();
                $mensajeUser->id_user = $user->id;
                $mensajeUser->type = 'message';
                $mensajeUser->correo_remitente = $request->correo_remitente;
                $mensajeUser->data = $request->nombre;
                $mensajeUser->asunto = $request->asunto;
                $mensajeUser->mensaje = $request->mensaje;
                $mensajeUser->read = false;
                $mensajeUser->save();
                //dd($mensajeUser);
            }
        }

        return redirect()->route('reportar')->with('info', 'Tu mensaje ha sido enviado correctamente!!');

    }

   
    
}
