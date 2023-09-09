<?php

use App\Http\Controllers\admin\GestionUsuariosController;
use App\Http\Controllers\DiaController;
use App\Http\Controllers\HoraController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\nutricionista\HorasDiasAtencionController;
use App\Http\Controllers\NutricionistaController;
use App\Http\Controllers\paciente\HistoriaClinicaController;
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

});
