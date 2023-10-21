<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetallePlanAlimentaciones;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\PlanAlimentaciones;
use App\Models\Turno;
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

        $planGenerado = PlanAlimentaciones::where('paciente_id', $paciente->id)->where('estado', 'Activo')->first();
        $detallesPlan = DetallePlanAlimentaciones::where('plan_alimentacion_id', $planGenerado->id)->get();

        return view('plan-alimentacion.plan-generado', compact('paciente', 'turno', 'nutricionista' , 'planGenerado', 'detallesPlan'));

    }
}
