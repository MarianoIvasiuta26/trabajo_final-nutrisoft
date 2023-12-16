<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesPorTiposDeActividades;
use App\Models\ActividadesProhibidasCirugia;
use App\Models\ActividadesProhibidasPatologia;
use App\Models\ActividadRecPorTipoActividades;
use App\Models\Consulta;
use App\Models\DetallesPlanesSeguimiento;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use App\Models\PlanesDeSeguimiento;
use App\Models\TiposDeActividades;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
use App\Models\UnidadesDeTiempo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PlanDeSeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $paciente = Paciente::find(auth()->user()->paciente->id);
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        if(!$historiaClinica){
            return redirect()->route('dashboard')->with('info', 'No puede acceder a este módulo hasta que complete su registro.');
        }

        if($historiaClinica->completado == 0){
            return redirect()->route('dashboard')->with('info', 'No puede acceder a este módulo hasta que complete su registro.');
        }

        $planesPaciente = PlanesDeSeguimiento::where('paciente_id', auth()->user()->paciente->id)->get();
        return view('plan-seguimiento.index', compact('planesPaciente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    /*
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $planGenerado = PlanesDeSeguimiento::find($request->input('plan_id'));
        $consulta = Consulta::where('id', $planGenerado->consulta_id)->first();

        $obtenerDatosPlan = $this->obtenerDatosPlan($consulta->imc_actual, $consulta->peso_actual, $consulta->altura_actual);
        $estadoIMC = $obtenerDatosPlan['estadoIMC'];
        $pesoIdeal = $obtenerDatosPlan['pesoIdeal'];

        if (!$planGenerado) {
            return redirect()->back()->with('errorPlanNoEncontrado', 'Error, no se pudo encontrar el plan generado. Inténtelo de nuevo por favor.');
        }

        $actividadesSeleccionadas = $request->input('actividades_seleccionadas', []);
        $unidadesTiempo = UnidadesDeTiempo::all();
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $planGenerado->id)->get();

        foreach ($actividadesSeleccionadas as $actividadNueva) {
            $actividadRecomendada = ActividadRecPorTipoActividades::find($actividadNueva);
            $tipoActividad = ActividadesPorTiposDeActividades::where('id', $actividadRecomendada->act_tipoAct_id)->first();
            $actividad = Actividades::where('id', $tipoActividad->actividad_id)->first();

            if ($this->esActividadProhibida($actividad, $planGenerado)) {
                return back()
                    ->with('planId', $planGenerado->id)
                    ->with('actRecomendadaId', $actividadNueva)
                    ->with('estadoIMC', $estadoIMC)
                    ->with('pesoIdeal', $pesoIdeal)
                    ->with('info', 'La actividad ' . $actividad->actividad . ' podría no ser recomendable para este paciente. ¿Desea agregarlo igualmente?');
            }

            $usuario = auth()->user()->apellido . ' ' . auth()->user()->name;

            foreach($detallesPlan as $detalle){
                $unidadTiempo = $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo;
                if($detalle->act_rec_id == $actividadRecomendada->id && $detalle->actividad_id == $actividad->id && $detalle->tiempo_realizacion == $actividadRecomendada->duracion_actividad && $detalle->unidad_tiempo_realizacion == $unidadTiempo){
                    continue 2;
                }
            }

            DetallesPlanesSeguimiento::create([
                'plan_de_seguimiento_id' => $planGenerado->id,
                'act_rec_id' => $actividadRecomendada->id,
                'actividad_id' => $actividad->id,
                'completada' => 0,
                'tiempo_realizacion' => $actividadRecomendada->duracion_actividad,
                'unidad_tiempo_realizacion' => $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo,
                'recursos_externos' => '',
                'estado_imc' => $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->isNotEmpty()
                    ? $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->first()->estado_imc
                    : $estadoIMC,
                'peso_ideal' => $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->isNotEmpty()
                    ? $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->first()->peso_ideal
                    : $pesoIdeal,
                'usuario' => $usuario,
            ]);
        }

        return redirect()->back()->with('successActividadAgregada', 'Actividad agregada al plan de seguimiento.');
    }

    private function esActividadProhibida($actividad, $planGenerado)
    {
        $paciente = Paciente::find($planGenerado->paciente_id);
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();
        $cirugias = Cirugia::all();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();
        $patologias = Patologia::all();
        $actividadesProhibidasCirugias = ActividadesProhibidasCirugia::all();
        $actividadesProhibidasPatologias = ActividadesProhibidasPatologia::all();

        foreach ($cirugiasPaciente as $cirugiaPaciente) {
            foreach ($cirugias as $cirugia) {
                foreach ($actividadesProhibidasCirugias as $prohibido) {
                    if ($cirugiaPaciente->cirugia_id == $cirugia->id && $cirugia->id == $prohibido->cirugia_id && $prohibido->actividad_id == $actividad->id) {
                        return true;
                    }
                }
            }
        }

        foreach ($datosMedicos as $datoMedico) {
            foreach ($patologias as $patologia) {
                foreach ($actividadesProhibidasPatologias as $prohibido) {
                    if ($datoMedico->patologia_id == $patologia->id && $patologia->id == $prohibido->patologia_id && $prohibido->actividad_id == $actividad) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

       //Función para guardar el detalle del plan de seguimiento al agregar una nueva actividad
    public function guardarDetalle($planId, $actRecomendadaId, $estadoIMC, $pesoIdeal)
    {
        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;
        $actividadRecomendada = ActividadRecPorTipoActividades::find($actRecomendadaId)->first();
        $tipo = ActividadesPorTiposDeActividades::where('id', $actividadRecomendada->act_tipoAct_id)->first();
        $actividad = Actividades::where('id', $tipo->actividad_id)->first();

        $unidadesTiempo = UnidadesDeTiempo::all();
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $planId)->get();

        $detalleNuevoPlan = DetallesPlanesSeguimiento::create([
            'plan_de_seguimiento_id' => $planId,
            'act_rec_id' => $actividadRecomendada->id,
            'actividad_id' => $actividad->id,
            'tiempo_realizacion' => $actividadRecomendada->duracion_actividad,
            'unidad_tiempo_realizacion' => $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo,
            'recursos_externos' => '',
            'estado_imc' => $detallesPlan->where('plan_de_seguimiento_id', $planId->id)->isNotEmpty()
                    ? $detallesPlan->where('plan_de_seguimiento_id', $planId->id)->first()->estado_imc
                    : $estadoIMC,
                'peso_ideal' => $detallesPlan->where('plan_de_seguimiento_id', $planId->id)->isNotEmpty()
                    ? $detallesPlan->where('plan_de_seguimiento_id', $planId->id)->first()->peso_ideal
                    : $pesoIdeal,
            'usuario' => $usuario,
        ]);

        if($detalleNuevoPlan){
            return response()->json([
                'success' => 'Actividad agregada al plan de seguimiento.',
            ]);
        }else{
            return response()->json([
                'error' => 'Error, no se pudo agregar la actividad al plan de seguimiento. Inténtelo de nuevo por favor.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     */

     /*
        * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = PlanesDeSeguimiento::find($id);
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $plan->id)->get();
        $actividades = Actividades::all();
        $unidadesTiempo = UnidadesDeTiempo::all();

        $actividadesRecomendadas = ActividadRecPorTipoActividades::all();
        $tiposActividades = TiposDeActividades::all();
        $actividadesPorTipo = ActividadesPorTiposDeActividades::all();

        if(!$plan){
            return redirect()->back()->with('errorPlanNoEncontrado', 'No se encontró el plan de seguimiento a consultar.');
        }

        return view('plan-seguimiento.show', compact('plan','detallesPlan','actividades', 'unidadesTiempo', 'actividadesRecomendadas', 'tiposActividades', 'actividadesPorTipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */

     /*

     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detallePlan = DetallesPlanesSeguimiento::find($id);

        if(!$detallePlan){
            return redirect()->back()->with('errorActividadNoEncontrada', 'No se encontró la actividad a editar del plan de seguimiento.');
        }

        $request->validate([
            'actividad' => ['required', 'integer'],
            'duracion'=> ['required','numeric'],
            'unidad_tiempo'=> ['required','string'],
            'recursos_externos'=> ['nullable', 'string'],
        ]);

        $unidadTiempo = UnidadesDeTiempo::where('nombre_unidad_tiempo', $request->input('unidad_tiempo'))->first();

        $recomendada = ActividadRecPorTipoActividades::where('id', $detallePlan->act_rec_id)->first();
        $recomendada->duracion_actividad = $request->input('duracion');
        $recomendada->unidad_tiempo_id = $unidadTiempo->id;
        $recomendada->save();

        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;

        $detallePlan->actividad_id = $request->input('actividad');
        $detallePlan->tiempo_realizacion = $request->input('duracion');
        $detallePlan->unidad_tiempo_realizacion = $request->input('unidad_tiempo');
        $detallePlan->recursos_externos = $request->input('recursos_externos') ?? '';
        $detallePlan->usuario = $usuario;
        $detallePlan->save();

        return redirect()->back()->with('successActividadActualizada', 'Actividad actualizada del plan de seguimiento.');
    }

    /**
     * Remove the specified resource from storage.
     *
     */

     /*
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $detallePlan = DetallesPlanesSeguimiento::find($id);

        if(!$detallePlan){
            return redirect()->back()->with('errorActividadNoEncontrada', 'No se encontró la actividad a eliminar del plan de seguimiento.');
        }

        $detallePlan->delete();

        return redirect()->back()->with('successActividadEliminada', 'Actividad eliminada del plan de seguimiento.');
    }

    public function consultarPlanGenerado($pacienteId, $turnoId, $nutriconistaId){
        $paciente = Paciente::find($pacienteId);
        $turno = Turno::find($turnoId);
        $nutricionista = Nutricionista::find($nutriconistaId);

        $planSeguimientoGenerado = PlanesDeSeguimiento::where('paciente_id', $paciente->id)->where('estado', 2)->first();
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $planSeguimientoGenerado->id)->get();

        $unidadesTiempo = UnidadesDeTiempo::all();

        $actividades = Actividades::all();
        $tiposActividades = TiposDeActividades::all();
        $actividadesPorTipo = ActividadesPorTiposDeActividades::all();
        $actividadesRecomendadas = ActividadRecPorTipoActividades::all();

        //Datos clínicos del paciente
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();

        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();

        $cirugias = Cirugia::all();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();

        $tratamientos = Tratamiento::all();
        $tratamientosPaciente = TratamientoPorPaciente::where('paciente_id', $paciente->id)->get();

        return view('plan-seguimiento.plan-generado', compact('paciente', 'actividades', 'turno', 'nutricionista' , 'planSeguimientoGenerado', 'detallesPlan', 'historiaClinica', 'datosMedicos', 'alergias', 'patologias', 'intolerancias', 'cirugias', 'cirugiasPaciente', 'tratamientos', 'tratamientosPaciente', 'unidadesTiempo', 'tiposActividades', 'actividadesPorTipo', 'actividadesRecomendadas'));

    }

    //Función para confirmar el plan generado
    public function confirmarPlan($id){

        $planAConfirmar = PlanesDeSeguimiento::find($id);
        $paciente = Paciente::find($planAConfirmar->paciente_id);

        if(!$planAConfirmar){
            return redirect()->back()->with('errorPlanNoEncontrado', 'No se encontró el plan de alimentación a confirmar.');
        }

        $ultimoPlanSeguimientoPaciente = PlanesDeSeguimiento::where('paciente_id', $paciente->id)->where('estado', 1)->orderBy('id', 'desc')->first();

        if($ultimoPlanSeguimientoPaciente){
            $ultimoPlanSeguimientoPaciente->estado = 0;
            $ultimoPlanSeguimientoPaciente->save();
        }

        $planAConfirmar->estado = 1;
        $planAConfirmar->save();

        return redirect()->route('plan-seguimiento.planesSeguimientoAConfirmar')->with('successPlanConfirmado', 'Plan de seguimiento confirmado y asociado al paciente.');

    }

    //Función para nutricionista consultar los planes generados
    public function planesSeguimientoAConfirmar(){
        $planesAConfirmar = PlanesDeSeguimiento::where('estado', 2)->get();
        $planesGenerados =  PlanesDeSeguimiento::all();

        return view('nutricionista.planes-a-confirmar.plan-seguimiento.index', compact('planesAConfirmar', 'planesGenerados'));

    }

    //Generación de pdf
    public function pdf($id){

        $plan = PlanesDeSeguimiento::find($id);
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $plan->id)->get();
        $actividades = Actividades::all();
        $tiposActividades = TiposDeActividades::all();
        $actividadesPorTipo = ActividadesPorTiposDeActividades::all();
        $actividadesRecomendadas = ActividadRecPorTipoActividades::all();
        $unidadesTiempo = UnidadesDeTiempo::all();
        $fechaActual = now()->format('d-m-Y');

        $pdf = Pdf::loadView('plan-seguimiento.pdf', compact('plan','detallesPlan','actividades','tiposActividades', 'actividadesPorTipo', 'actividadesRecomendadas', 'unidadesTiempo', 'fechaActual'));
        return $pdf->stream();
    }

    public function obtenerDatosPlan($imc, $peso, $altura){

        $estadoIMC = '';
        $alturaMetro = $altura / 100;

        if($imc < 18.5){
            $estadoIMC = 'IMC bajo. Bajo peso. ';
            $pesoIdeal = 18.5 * ($alturaMetro * $alturaMetro); //Bajo peso
        }else if($imc >= 18.5 && $imc <= 24.99){
            $estadoIMC = 'IMC normal. Peso saludable. ';
            $pesoIdeal = $peso; //Peso normal
        }else if($imc >= 25 && $imc <= 29.99){
            $estadoIMC = 'IMC elevado. Sobrepeso. ';
            $pesoIdeal = 25 * ($alturaMetro * $alturaMetro); //Sobrepeso
        }else if($imc >= 30 && $imc <= 34.99){
            $estadoIMC = 'IMC elevado. Obesidad de grado 1. ';
            $pesoIdeal = 30 * ($alturaMetro * $alturaMetro); //Obesidad grado 1
        }else if($imc >= 35 && $imc <= 39.99){
            $estadoIMC = 'IMC elevado. Obesidad de grado 2. ';
            $pesoIdeal = 35 * ($alturaMetro * $alturaMetro); //Obesidad grado 2
        }else if($imc >= 40){
            $estadoIMC = 'IMC elevado. Obesidad mórbida. ';
            $pesoIdeal = 40 * ($alturaMetro * $alturaMetro); //Obesidad grado 3 o mórbida
        }

        return [
            'estadoIMC' => $estadoIMC,
            'pesoIdeal' => $pesoIdeal,
        ];

    }

}
