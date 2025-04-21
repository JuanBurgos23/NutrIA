<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener todos los pacientes
        $pacientes = Paciente::with('user')->get(); 
        // Pasar los pacientes a la vista
        return view('dashboard.dashboard', compact('pacientes'));
        
    }
    
}
