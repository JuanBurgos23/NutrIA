<?php

use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\MensajeUserController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\PlanNutricionalController;
use App\Http\Controllers\ReportarController;
use App\Models\Ejercicio;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\PlanNutricional;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');





//perfil
Route::get('perfil', [PacienteController::class, 'perfil'])->name('perfil');
Route::post('user-perfil', [PacienteController::class, 'actualizarPerfil'])->name('user-perfil');

//Consulta
Route::get('Consulta', [ConsultaController::class, 'index'])->name('consulta');
Route::get('Registro', [ConsultaController::class, 'registro'])->name('registro');
Route::get('Consultas', [ConsultaController::class, 'mostrarConsultas'])->name('mostrar_consulta');
Route::post('Registrar/Consulta', [ConsultaController::class, 'storeConsulta'])->name('registrar_consulta');
Route::post('Registrar/Adicional', [ConsultaController::class, 'store'])->name('registrar_adicional');

//diagnostico
Route::get('/diagnostico/{id}', [DiagnosticoController::class, 'mostrarDiagnostico'])->name('diagnostico');
//historial
Route::get('/Historial', [DiagnosticoController::class, 'historial'])->name('historial');
Route::get('/detalle/historial/{id}',[DiagnosticoController::class,'detalleHistorial'])->name('detalle_historial');
    Route::get('/Historial/Fecha', [DiagnosticoController::class, 'historialRangoFecha'])->name('historialFecha');

//periodo
Route::get('/Periodo', [PeriodoController::class, 'index'])->name('periodo');
Route::post('/registrar/periodo', [PeriodoController::class, 'store'])->name('registrar_periodo');

//Alimento
Route::get('/Alimento', [AlimentoController::class, 'index'])->name('alimento')->middleware('checkRole:admin');
Route::post('registrar-alimento', [AlimentoController::class, 'store'])->middleware('checkRole:admin');
Route::get('/alimento/edit/{id}', [AlimentoController::class, 'edit'])->middleware('checkRole:admin');
Route::put('/alimento-update/{id}', [AlimentoController::class, 'update'])->middleware('checkRole:admin');
Route::delete('/alimento/delete-image/{id}', [AlimentoController::class, 'deleteImage'])->middleware('checkRoke:admin');


//Dieta
Route::get('/Dieta', [DietaController::class, 'index'])->name('dieta')->middleware('checkRole:admin');
Route::post('registrar-dieta', [DietaController::class, 'store'])->middleware('checkRole:admin');

Route::get('/periodos', [PeriodoController::class, 'obtenerPeriodos'])->middleware('checkRole:admin');
Route::get('/dias/{idPeriodo}', [PeriodoController::class, 'obtenerDias'])->middleware('checkRole:admin');
Route::get('/horas/{idDia}', [PeriodoController::class, 'obtenerHoras'])->middleware('checkRole:admin');

//Ejercicio
Route::get('/Ejercicio', [EjercicioController::class, 'index'])->name('ejercicio')->middleware('checkRole:admin');
Route::post('registrar-ejercicio', [EjercicioController::class, 'store'])->middleware('checkRole:admin');


//API
Route::get('/llamar-api', [ConsultaController::class, 'ejecutarApi']);

//plan nutricional
Route::get('/plan/{id}', [PlanNutricionalController::class, 'index'])->name('plan_nutricional');
Route::post('crear/plan', [PlanNutricionalController::class, 'store'])->name('plan');
Route::get('/plan/historial/{id}', [PlanNutricionalController::class, 'planHistorial'])->name('plan_nutriHistorial');
Route::get('/plan-nutricional/{id}/pdf', [PlanNutricionalController::class, 'generarPDF'])->name('plan_pdf');
//enviar correo planNutricional

Route::post('/plan/enviar-correo/{id}', [PlanNutricionalController::class, 'enviarPlanPorCorreo'])->name('enviarPlanCorreo');


//enviar reporte
Route::get('/Reportar', [ContactoController::class, 'index'])->name('reportar');
;
 Route::post('/Reportar', [ContactoController::class, 'store'])->name('contactoStore');


 //ver mensajes
 //ver mensajes
 Route::get('/mensajeUser/{id}', [MensajeUserController::class, 'show'])->name('mensajeUser.show');
 Route::post('/mensajeUser/{id}/markAsRead', [MensajeUserController::class, 'markAsRead'])->name('mensajeUser.markAsRead');
 Route::get('/mensajesUser', [MensajeUserController::class, 'mostrar'])->name('mensajesUser');
