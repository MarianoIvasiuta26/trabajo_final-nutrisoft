<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesPorTiposDeActividades;
use App\Models\ActividadesProhibidasCirugia;
use App\Models\ActividadesProhibidasPatologia;
use App\Models\ActividadRecPorTipoActividades;
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
        $planesPaciente = PlanesDeSeguimiento::where('paciente_id', auth()->user()->paciente->id)->get();
        return view('plan-alimentacion.index', compact('planesPaciente'));
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

        if (!$planGenerado) {
            return redirect()->back()->with('errorPlanNoEncontrado', 'Error, no se pudo encontrar el plan generado. Inténtelo de nuevo por favor.');
        }

        $actividadesSeleccionadas = $request->input('actividades_seleccionadas', []);
        $unidadesTiempo = UnidadesDeTiempo::all();
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $planGenerado->id)->get();

        foreach ($actividadesSeleccionadas as $actividadNueva) {
            $tipoActividad = ActividadesPorTiposDeActividades::find($actividadNueva);
            $actividad = Actividades::where('id', $tipoActividad->actividad_id)->first();

            if ($this->esActividadProhibida($actividad, $planGenerado)) {
                return back()
                    ->with('planId', $planGenerado->id)
                    ->with('tipoActividadId', $actividadNueva)
                    ->with('info', 'La actividad ' . $actividad->actividad . ' podría no ser recomendable para este paciente. ¿Desea agregarlo igualmente?');
            }

            $usuario = auth()->user()->apellido . ' ' . auth()->user()->name;

            $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $tipoActividad->id)->first();

            foreach($detallesPlan as $detalle){
                $unidadTiempo = $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo;
                if($detalle->actividad_id == $actividad->id && $detalle->tiempo_realizacion == $actividadRecomendada->duracion_actividad && $detalle->unidad_tiempo_realizacion == $unidadTiempo){
                    continue 2;
                }
            }

            DetallesPlanesSeguimiento::create([
                'plan_de_seguimiento_id' => $planGenerado->id,
                'actividad_id' => $actividad->id,
                'completada' => 0,
                'tiempo_realizacion' => $actividadRecomendada->duracion_actividad,
                'unidad_tiempo_realizacion' => $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo,
                'recursos_externos' => '',
                'estado_imc' => $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->first()->estado_imc,
                'peso_ideal' => $detallesPlan->where('plan_de_seguimiento_id', $planGenerado->id)->first()->peso_ideal,
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
    public function guardarDetalle($planId, $tipoActividadId)
    {
        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;
        $tipo = ActividadesPorTiposDeActividades::where('tipo_actividad_id', $tipoActividadId)->first();
        $actividad = Actividades::where('id', $tipo->actividad_id)->first();

        $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $tipo->id)->first();
        $unidadesTiempo = UnidadesDeTiempo::all();
        $detallesPlan = DetallesPlanesSeguimiento::where('plan_de_seguimiento_id', $planId)->get();

        $detalleNuevoPlan = DetallesPlanesSeguimiento::create([
            'plan_de_seguimiento_id' => $planId,
            'actividad_id' => $actividad->id,
            'tiempo_realizacion' => $actividadRecomendada->duracion_actividad,
            'unidad_tiempo_realizacion' => $unidadesTiempo->where('id', $actividadRecomendada->unidad_tiempo_id)->first()->nombre_unidad_tiempo,
            'recursos_externos' => '',
            'estado_imc' => $detallesPlan->where('plan_de_seguimiento_id', $planId)->first()->estado_imc,
            'peso_ideal' => $detallesPlan->where('plan_de_seguimiento_id', $planId)->first()->peso_ideal,
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        if(!$planAConfirmar){
            return redirect()->back()->with('errorPlanNoEncontrado', 'No se encontró el plan de alimentación a confirmar.');
        }

        $planAConfirmar->estado = 1;
        $planAConfirmar->save();

        return redirect()->route('nutricionista.planes-a-confirmar.plan-seguimiento.index')->with('successPlanConfirmado', 'Plan de alimentación confirmado y asociado al paciente.');

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
        $pdf = Pdf::loadView('plan-seguimiento.pdf', compact('plan','detallesPlan','actividades'));
        return $pdf->stream();
    }


}
