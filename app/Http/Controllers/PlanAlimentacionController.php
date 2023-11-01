<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
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

class PlanAlimentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $detallePlan = DetallePlanAlimentaciones::find($id);

        if(!$detallePlan){
            return redirect()->back()->with('errorAlimentoNoEncontrado', 'No se encontró el alimento a eliminar del plan de alimentación.');
        }

        $detallePlan->alimento_id = $request->input('alimento');
        $detallePlan->cantidad = $request->input('cantidad');
        $detallePlan->unidad_medida = $request->input('unidad_medida');
        $detallePlan->observacion = $request->input('observaciones');
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

        return view('plan-alimentacion.plan-generado', compact('paciente', 'turno', 'nutricionista' , 'planGenerado', 'detallesPlan', 'alimentos', 'historiaClinica', 'datosMedicos', 'alergias', 'patologias', 'intolerancias', 'cirugias', 'cirugiasPaciente', 'tratamientos', 'tratamientosPaciente', 'anamnesisPaciente', 'unidadesMedidas'));

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



}
