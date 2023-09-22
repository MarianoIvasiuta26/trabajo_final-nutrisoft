<?php

use App\Http\Controllers\admin\GestionUsuariosController;
use App\Http\Controllers\DiaController;
use App\Http\Controllers\HoraController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\nutricionista\HorasDiasAtencionController;
use App\Http\Controllers\NutricionistaController;
use App\Http\Controllers\paciente\AdelantamientoTurnoController;
use App\Http\Controllers\admin\AlergiaController;
use App\Http\Controllers\admin\AlimentoController;
use App\Http\Controllers\admin\AnalisisClinicoController;
use App\Http\Controllers\admin\CirugiaController;
use App\Http\Controllers\admin\FuenteAlimentoController;
use App\Http\Controllers\admin\GrupoAlimentoController;
use App\Http\Controllers\admin\IntoleranciaController;
use App\Http\Controllers\admin\NutrienteController;
use App\Http\Controllers\admin\PatologiaController;
use App\Http\Controllers\paciente\DatosMedicosController;
use App\Http\Controllers\paciente\HistoriaClinicaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Admin
    Route::get('profile',[UserController::class,'show'])->name('profile');
    Route::resource('gestion-usuarios', GestionUsuariosController::class)->names('gestion-usuarios');
    Route::resource('gestion-alergias', AlergiaController::class)->names('gestion-alergias');
    Route::resource('gestion-intolerancias', IntoleranciaController::class)->names('gestion-intolerancias');
    Route::resource('gestion-cirugias', CirugiaController::class)->names('gestion-cirugias');
    Route::resource('gestion-analisis', AnalisisClinicoController::class)->names('gestion-analisis');
    Route::resource('gestion-patologias', PatologiaController::class)->names('gestion-patologias');
    Route::resource('gestion-alimentos', AlimentoController::class)->names('gestion-alimentos');
    Route::resource('gestion-grupos-alimento', GrupoAlimentoController::class)->names('gestion-grupos-alimento');
    Route::resource('gestion-fuentes', FuenteAlimentoController::class)->names('gestion-fuentes');
    Route::resource('gestion-nutrientes', NutrienteController::class)->names('gestion-nutrientes');

    //Route::resource('gestion-atencion', HorasDiasAtencionController::class)->names('gestion-atencion');

    //Nutricionista

/*
    Route::resources([
        'nutricionista' => NutricionistaController::class,
        'dia' => DiaController::class,
        'hora' => HoraController::class,
        'horario' => HorarioController::class,
    ]);
*/

    Route::get('gestion-atencion', [HorasDiasAtencionController::class, 'index'])->name('gestion-atencion.index');
    Route::get('gestion-atencion/consulta', [NutricionistaController::class, 'consultaForm'])->name('gestion-atencion.consultaForm');
    //Route::post('gestion-atencion/guardar', [NutricionistaController::class, 'guardarHorarios'])->name('gestion-atencion.guardarHorarios');
    Route::delete('gestion-atencion/{id}', [HorasDiasAtencionController::class, 'destroy'])->name('gestion-atencion.destroy');
    Route::post('gestion-atencion/guardar', [HorasDiasAtencionController::class, 'store'])->name('gestion-atencion.store');

    //Paciente
    Route::resource('historia-clinica', HistoriaClinicaController::class)->names('historia-clinica');
    Route::get('/complete-history', [HistoriaClinicaController::class, 'index'])->name('complete-history');
    Route::post('datos-personales/store', [PacienteController::class, 'store'])->name('datos-personales.store');

    Route::get('datos-personales/edit/{id}', [PacienteController::class, 'edit'])->name('datos-personales.edit');
    Route::post('datos-personales/update/{id}', [PacienteController::class, 'update'])->name('datos-personales.update');

    Route::resource('adelantamiento-turno', AdelantamientoTurnoController::class)->names('adelantamiento-turno');
    Route::resource('datos-medicos', DatosMedicosController::class)->names('datos-medicos');
    Route::post('adelantamiento-turno/guardar', [AdelantamientoTurnoController::class, 'guardar'])->name('adelantamiento-turno.guardar');

    Route::resource('gestion-turnos', TurnoController::class)->names('turnos');
    Route::post('turnos.horas-disponibles', [TurnoController::class, 'horasDisponibles'])->name('turnos.horas-disponibles');
});
