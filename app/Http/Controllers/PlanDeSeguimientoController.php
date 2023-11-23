<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesPorTiposDeActividades;
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

        return view('plan-alimentacion.plan-generado', compact('paciente', 'turno', 'nutricionista' , 'planSeguimientoGenerado', 'detallesPlan', 'alimentos', 'historiaClinica', 'datosMedicos', 'alergias', 'patologias', 'intolerancias', 'cirugias', 'cirugiasPaciente', 'tratamientos', 'tratamientosPaciente', 'unidadesTiempo', 'tiposActividades', 'actividadesPorTipo', 'actividadesRecomendadas'));

    }

}
