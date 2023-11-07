<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentosProhibidosAlergia;
use App\Models\AlimentosProhibidosIntolerancia;
use App\Models\AlimentosProhibidosPatologia;
use App\Models\Comida;
use App\Models\DetallePlanAlimentaciones;
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
use App\Models\PlanAlimentaciones;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
use App\Models\UnidadesMedidasPorComida;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PlanAlimentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planesPaciente = PlanAlimentaciones::where('paciente_id', auth()->user()->paciente->id)->get();
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
     */
     //@param  \Illuminate\Http\Request  $request
     //@return \Illuminate\Http\Response

    public function store(Request $request)
    {

        $planGenerado = PlanAlimentaciones::find($request->input('plan_id'));

        if(!$planGenerado){
            return redirect()->back()->with('errorPlanNoEncontrado','Error, no se puedo encontrar el plan generado. Inténtelo de nuevo por favor.');
        }

        $request->validate([
            'alimento' => ['required', 'integer'],
            'cantidad'=> ['required','integer'],
            'unidad_medida'=> ['required','string'],
            'observaciones'=> ['required','string'],
        ]);

        $alimentoNuevo = $request->input('alimento');
        $comida = $request->input('comida');

        $paciente = Paciente::find($planGenerado->paciente_id);
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();

        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();

        $alimentosProhibidosAlergias = AlimentosProhibidosAlergia::all();
        $alimentosProhibidosPatologias = AlimentosProhibidosPatologia::all();
        $alimentosProhibidosIntolerancias = AlimentosProhibidosIntolerancia::all();

        $alimento = Alimento::find($alimentoNuevo);

        foreach($datosMedicos as $datoMedico){
            foreach($alergias as $alergia){
                foreach($alimentosProhibidosAlergias as $prohibido){
                    if($datoMedico->alergia_id == $alergia->id && $alergia->id == $prohibido->alergia_id && $prohibido->alimento_id == $alimentoNuevo){
                        return back()
                            ->with('planId',$planGenerado->id)
                            ->with('alimentoNuevo', $alimentoNuevo)
                            ->with('comida', $comida)
                            ->with('cantidad', $request->input('cantidad'))
                            ->with('unidadMedida', $request->input('unidad_medida'))
                            ->with('observacion',  $request->input('observaciones'))
                            ->with('info', 'El alimento '. $alimento->alimento .' podría no ser recomendable para este paciente. ¿Desea agregarlo igualmente?');
                    }
                }
            }

            foreach($patologias as $patologia){
                foreach($alimentosProhibidosPatologias as $prohibido){
                    if($datoMedico->patologia_id == $patologia->id && $patologia->id == $prohibido->patologia_id && $prohibido->alimento_id == $alimentoNuevo){
                        return back()
                            ->with('planId',$planGenerado->id)
                            ->with('alimentoNuevo', $alimentoNuevo)
                            ->with('comida', $comida)
                            ->with('cantidad', $request->input('cantidad'))
                            ->with('unidadMedida', $request->input('unidad_medida'))
                            ->with('observacion',  $request->input('observaciones'))
                            ->with('info', 'El alimento '. $alimento->alimento .' podría no ser recomendable para este paciente. ¿Desea agregarlo igualmente?');
                    }
                }
            }
             foreach($intolerancias as $intolerancia){
                foreach($alimentosProhibidosIntolerancias as $prohibido){
                    if($datoMedico->intolerancia_id == $intolerancia->id && $intolerancia->id == $prohibido->intolerancia_id && $prohibido->alimento_id == $alimentoNuevo){
                        return back()
                            ->with('planId',$planGenerado->id)
                            ->with('alimentoNuevo', $alimentoNuevo)
                            ->with('comida', $comida)
                            ->with('cantidad', $request->input('cantidad'))
                            ->with('unidadMedida', $request->input('unidad_medida'))
                            ->with('observacion',  $request->input('observaciones'))
                            ->with('info', 'El alimento '. $alimento->alimento .' podría no ser recomendable para este paciente. ¿Desea agregarlo igualmente?');
                    }
                }
            }
        }

        $detallesExistentes = DetallePlanAlimentaciones::where('plan_alimentacion_id', $planGenerado->id)->get();

        foreach($detallesExistentes as $detalle){
            if($detalle->alimento_id ==  $alimentoNuevo && $detalle->horario_consumicion == $comida){
                return redirect()->back()
                    ->with('planId',$planGenerado->id)
                    ->with('alimentoNuevo', $alimentoNuevo)
                    ->with('comida', $comida)
                    ->with('cantidad', $request->input('cantidad'))
                    ->with('unidadMedida', $request->input('unidad_medida'))
                    ->with('observacion',  $request->input('observaciones'))
                    ->with('errorAlimentoYaAgregado', 'El alimento ya se encuentra agregado al plan de alimentación. Elimine el anterior registro o modifíquelo por favor.');
            }
        }

        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;

        $detalleNuevoPlan = DetallePlanAlimentaciones::create([
            'plan_alimentacion_id' => $planGenerado->id,
            'alimento_id' => $alimentoNuevo,
            'horario_consumicion' => $comida,
            'cantidad' => $request->input('cantidad'),
            'unidad_medida' => $request->input('unidad_medida'),
            'observacion' => $request->input('observaciones'),
            'usuario' => $usuario,
        ]);

        if($detalleNuevoPlan){
            return redirect()->back()->with('successAlimentoAgregado', 'Alimento agregado al plan de alimentación.');
        }else{
            return redirect()->back()->with('errorAlimentoNoAgregado', 'Error, no se pudo agregar el alimento al plan de alimentación. Inténtelo de nuevo por favor.');
        }

    }

    public function guardarDetalle($planId, $alimentoNuevo, $comida, $cantidad, $unidadMedida, $observacion){
        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;

        $detalleNuevoPlan = DetallePlanAlimentaciones::create([
            'plan_alimentacion_id' => $planId,
            'alimento_id' => $alimentoNuevo,
            'horario_consumicion' => $comida,
            'cantidad' => $cantidad,
            'unidad_medida' => $unidadMedida,
            'observacion' => $observacion,
            'usuario' => $usuario,
        ]);

        if($detalleNuevoPlan){
            return response()->json([
                'success' => 'Alimento agregado al plan de alimentación.',
            ]);
        }else{
            return response()->json([
                'error' => 'Error, no se pudo agregar el alimento al plan de alimentación. Inténtelo de nuevo por favor.',
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
        $plan = PlanAlimentaciones::find($id);
        $detallesPlan = DetallePlanAlimentaciones::where('plan_alimentacion_id', $plan->id)->get();
        $alimentos = Alimento::all();
        $comidas = Comida::all();

        if(!$plan){
            return redirect()->back()->with('errorPlanNoEncontrado', 'No se encontró el plan de alimentación a consultar.');
        }

        return view('plan-alimentacion.show', compact('plan','detallesPlan','alimentos', 'comidas'));

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
        $detallePlan = DetallePlanAlimentaciones::find($id);

        if(!$detallePlan){
            return redirect()->back()->with('errorAlimentoNoEncontrado', 'No se encontró el alimento a eliminar del plan de alimentación.');
        }

        $request->validate([
            'alimento' => ['required', 'integer'],
            'cantidad'=> ['required','integer'],
            'unidad_medida'=> ['required','string'],
            'observaciones'=> ['required','string'],
        ]);

        $usuario = auth()->user()-> apellido . ' ' . auth()->user()->name;

        $detallePlan->alimento_id = $request->input('alimento');
        $detallePlan->cantidad = $request->input('cantidad');
        $detallePlan->unidad_medida = $request->input('unidad_medida');
        $detallePlan->observacion = $request->input('observaciones');
        $detallePlan->usuario = $usuario;
        $detallePlan->save();

        return redirect()->back()->with('successAlimentoActualizado', 'Alimento actualizado del plan de alimentación.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detallePlan = DetallePlanAlimentaciones::find($id);

        if(!$detallePlan){
            return redirect()->back()->with('errorAlimentoNoEncontrado', 'No se encontró el alimento a eliminar del plan de alimentación.');
        }

        $detallePlan->delete();

        return redirect()->back()->with('successAlimentoEliminado', 'Alimento eliminado del plan de alimentación.');
    }

    public function consultarPlanGenerado($pacienteId, $turnoId, $nutriconistaId){
        $paciente = Paciente::find($pacienteId);
        $turno = Turno::find($turnoId);
        $nutricionista = Nutricionista::find($nutriconistaId);

        $planGenerado = PlanAlimentaciones::where('paciente_id', $paciente->id)->where('estado', 2)->first();
        $detallesPlan = DetallePlanAlimentaciones::where('plan_alimentacion_id', $planGenerado->id)->get();

        $unidadesMedidas = UnidadesMedidasPorComida::all();

        $alimentos = Alimento::all();
        $comidas = Comida::all();

        //Datos clínicos dell paciente
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();
        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();

        $cirugias = Cirugia::all();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();

        $tratamientos = Tratamiento::all();
        $tratamientosPaciente = TratamientoPorPaciente::where('paciente_id', $paciente->id)->get();
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->get();

        return view('plan-alimentacion.plan-generado', compact('paciente', 'turno', 'nutricionista' , 'planGenerado', 'detallesPlan', 'alimentos', 'historiaClinica', 'datosMedicos', 'alergias', 'patologias', 'intolerancias', 'cirugias', 'cirugiasPaciente', 'tratamientos', 'tratamientosPaciente', 'anamnesisPaciente', 'unidadesMedidas', 'comidas'));

    }

    public function confirmarPlan($id){

        $planAConfirmar = PlanAlimentaciones::find($id);

        if(!$planAConfirmar){
            return redirect()->back()->with('errorPlanNoEncontrado', 'No se encontró el plan de alimentación a confirmar.');
        }

        $planAConfirmar->estado = 1;
        $planAConfirmar->save();

        return redirect()->route('gestion-turnos-nutricionista.index')->with('successPlanConfirmado', 'Plan de alimentación confirmado y asociado al paciente.');

    }

    public function planesAlimentacionAConfirmar(){
        $planesAConfirmar = PlanAlimentaciones::where('estado', 2)->get();
        $planesGenerados =  PlanAlimentaciones::all();

        return view('nutricionista.planes-a-confirmar.plan-alimentacion.index', compact('planesAConfirmar', 'planesGenerados'));

    }

    public function pdf($id){

        $plan = PlanAlimentaciones::find($id);
        $detallesPlan = DetallePlanAlimentaciones::where('plan_alimentacion_id', $plan->id)->get();
        $alimentos = Alimento::all();
        $comidas = Comida::all();
        $pdf = Pdf::loadView('plan-alimentacion.pdf', compact('plan','detallesPlan','alimentos','comidas'));
        return $pdf->stream();
    }

}
