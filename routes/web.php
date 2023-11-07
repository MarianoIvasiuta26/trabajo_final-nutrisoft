<?php

use App\Http\Controllers\admin\ActividadController;
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
use App\Http\Controllers\AlimentosPorDietasController;
use App\Http\Controllers\nutricionista\GestionConsultasController;
use App\Http\Controllers\nutricionista\GestionPlieguesCutaneosController;
use App\Http\Controllers\nutricionista\GestionTurnosController;
use App\Http\Controllers\paciente\DatosMedicosController;
use App\Http\Controllers\paciente\HistoriaClinicaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PlanAlimentacionController;
use App\Http\Controllers\ProhibicionesAlergiaController;
use App\Http\Controllers\ProhibicionesIntoleranciaController;
use App\Http\Controllers\ProhibicionesPatologiaController;
use App\Http\Controllers\TratramientoController;
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
    Route::resource('prohibiciones-alergias', ProhibicionesAlergiaController::class)->names('prohibiciones-alergias');
    Route::resource('gestion-intolerancias', IntoleranciaController::class)->names('gestion-intolerancias');
    Route::resource('prohibiciones-intolerancias', ProhibicionesIntoleranciaController::class)->names('prohibiciones-intolerancias');
    Route::resource('gestion-cirugias', CirugiaController::class)->names('gestion-cirugias');
    Route::resource('gestion-analisis', AnalisisClinicoController::class)->names('gestion-analisis');
    Route::resource('gestion-patologias', PatologiaController::class)->names('gestion-patologias');
    Route::resource('prohibiciones-patologias', ProhibicionesPatologiaController::class)->names('prohibiciones-patologias');
    Route::resource('gestion-alimentos', AlimentoController::class)->names('gestion-alimentos');
    Route::resource('gestion-grupos-alimento', GrupoAlimentoController::class)->names('gestion-grupos-alimento');
    Route::resource('gestion-fuentes', FuenteAlimentoController::class)->names('gestion-fuentes');
    Route::resource('gestion-nutrientes', NutrienteController::class)->names('gestion-nutrientes');
    Route::resource('gestion-actividades', ActividadController::class)->names('gestion-actividades');

    //Route::resource('gestion-atencion', HorasDiasAtencionController::class)->names('gestion-atencion');



/*
    Route::resources([
        'nutricionista' => NutricionistaController::class,
        'dia' => DiaController::class,
        'hora' => HoraController::class,
        'horario' => HorarioController::class,
    ]);
*/

    //Nutricionista

    Route::get('completar-registro/{id}', [NutricionistaController::class, 'showRegistrationForm'])->name('mostrar-completar-registro');
    Route::post('completar-registro', [NutricionistaController::class, 'completarRegistro'])->name('completar-registro');

    Route::get('gestion-atencion', [HorasDiasAtencionController::class, 'index'])->name('gestion-atencion.index');
    Route::get('gestion-atencion/consulta', [NutricionistaController::class, 'consultaForm'])->name('gestion-atencion.consultaForm');
    //Route::post('gestion-atencion/guardar', [NutricionistaController::class, 'guardarHorarios'])->name('gestion-atencion.guardarHorarios');
    Route::delete('gestion-atencion/{id}', [HorasDiasAtencionController::class, 'destroy'])->name('gestion-atencion.destroy');
    Route::get('gestion-atencion/{id}', [HorasDiasAtencionController::class, 'edit'])->name('gestion-atencion.edit');
    Route::post('gestion-atencion/update/{id}', [HorasDiasAtencionController::class, 'update'])->name('gestion-atencion.update');
    Route::post('gestion-atencion/guardar', [HorasDiasAtencionController::class, 'store'])->name('gestion-atencion.store');
    Route::resource('gestion-turnos-nutricionista', GestionTurnosController::class)->names('gestion-turnos-nutricionista');
    Route::get('gestion-turnos-nutricionista.showHistorialTurnos', [GestionTurnosController::class, 'showHistorialTurnos'])->name('gestion-turnos-nutricionista.showHistorialTurnos');
    Route::post('gestion-turnos-nutricionista.confirmarInasistencia/{id}', [GestionTurnosController::class, 'confirmarInasistencia'])->name('gestion-turnos-nutricionista.confirmarInasistencia');
    Route::get('gestion-turnos-nutricionista.iniciarConsulta/{id}', [GestionTurnosController::class, 'iniciarConsulta'])->name('gestion-turnos-nutricionista.iniciarConsulta');

    Route::resource('gestion-consultas', GestionConsultasController::class)->names('gestion-consultas');
    Route::post('gestion-consultas.realizarCalculos', [GestionConsultasController::class, 'realizarCalculos'])->name('gestion-consultas.realizarCalculos');
    Route::post('gestion-consultas.calcularIMC', [GestionConsultasController::class, 'calcularIMC'])->name('gestion-consultas.calcularIMC');

    Route::post('gestion-consultas.store/{id}', [GestionConsultasController::class, 'store'])->name('gestion-consultas.store');

    Route::resource('gestion-tratamientos', TratramientoController::class)->names('gestion-tratamientos');

    Route::resource('gestion-pliegues-cutaneos', GestionPlieguesCutaneosController::class)->names('gestion-pliegues-cutaneos');

    Route::resource('gestion-alimento-por-dietas', AlimentosPorDietasController::class)->names('gestion-alimento-por-dietas');

    Route::resource('plan-alimentacion', PlanAlimentacionController::class)->names('plan-alimentacion');
    Route::post('plan-alimentacion.guardarDetalle/{planId}/{alimentoNuevo}/{comida}/{cantidad}/{unidadMedida}/{observacion}', [PlanAlimentacionController::class, 'guardarDetalle'])->name('plan-alimentacion.guardarDetalle');
    Route::get('plan-alimentacion.consultarPlanGenerado/{pacienteId}/{turnoId}/{nutricionistaId}', [PlanAlimentacionController::class, 'consultarPlanGenerado'])->name('plan-alimentacion.consultarPlanGenerado');
    Route::post('plan-alimentacion.confirmarPlan/{planId}', [PlanAlimentacionController::class, 'confirmarPlan'])->name('plan-alimentacion.confirmarPlan');
    Route::get('plan-alimentacion.planesAlimentacionAConfirmar', [PlanAlimentacionController::class, 'planesAlimentacionAConfirmar'])->name('plan-alimentacion.planesAlimentacionAConfirmar');
    Route::get('plan-alimentacion.pdf/{planId}', [PlanAlimentacionController::class, 'pdf'])->name('plan-alimentacion.pdf');



    //Paciente

    Route::resource('historia-clinica', HistoriaClinicaController::class)->names('historia-clinica');
    Route::get('/complete-history', [HistoriaClinicaController::class, 'index'])->name('complete-history');
    Route::post('datos-personales/store', [PacienteController::class, 'store'])->name('datos-personales.store');

    Route::get('datos-personales/edit/{id}', [PacienteController::class, 'edit'])->name('datos-personales.edit');
    Route::post('datos-personales/update/{id}', [PacienteController::class, 'update'])->name('datos-personales.update');

    Route::resource('adelantamiento-turno', AdelantamientoTurnoController::class)->names('adelantamiento-turno');
    Route::post('adelantamiento-turno.obtener-horas', [AdelantamientoTurnoController::class, 'obtenerHoras'])->name('adelantamiento-turno.obtener-horas');
    Route::post('adelantamiento-turno/obtener-dias', [AdelantamientoTurnoController::class, 'obtenerDias'])->name('adelantamiento-turno.obtener-dias');
    Route::resource('datos-medicos', DatosMedicosController::class)->names('datos-medicos');
    Route::post('adelantamiento-turno/guardar', [AdelantamientoTurnoController::class, 'guardar'])->name('adelantamiento-turno.guardar');

    Route::resource('gestion-turnos', TurnoController::class)->names('turnos');
    Route::post('turnos.horas-disponibles', [TurnoController::class, 'horasDisponibles'])->name('turnos.horas-disponibles');

    Route::get('show-detalles-consulta/{id}', [TurnoController::class, 'showDetallesConsulta'])->name('turnos.show-detalles-consulta');

    Route::get('obtener-confirmacion-nuevo-turno/{id}', [TurnoController::class, 'showConfirmacionNuevoTurno'])->name('obtener-confirmacion-nuevo-turno');
    Route::post('confirmar-adelantamiento-turno/{id}', [TurnoController::class, 'confirmarAdelantamientoTurno'])->name('confirmar-adelantamiento-turno');
    Route::post('rechazar-adelantamiento-turno/{id}', [TurnoController::class, 'rechazarAdelantamientoTurno'])->name('rechazar-adelantamiento-turno');

    //Proceso automatizado Generación automática de Planes de Alimentación
    Route::get('generar-plan-alimentacion', [GestionConsultasController::class, 'generarPlanesAlimentacion'])->name('generar-plan-alimentacion');




});
