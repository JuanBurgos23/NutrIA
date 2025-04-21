<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login'); // Redirigir al inicio de sesión si el usuario no está autenticado
        }

        // Verificar si el usuario tiene al menos uno de los roles proporcionados
        foreach ($roles as $role) {
            if (Auth::user()->hasRole($role)) {
                return $next($request); // El usuario tiene el rol adecuado, permite continuar
            }
        }

        // Si el usuario no tiene ninguno de los roles proporcionados, redirigir a una ruta denegada
        return redirect('home'); // Puedes cambiar esto a cualquier ruta de acceso denegado que desees
    }
}
