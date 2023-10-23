<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Models\MedicionesDePlieguesCutaneos;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\TipoConsulta;
use App\Models\TiposDePliegueCutaneo;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GestionTurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnos = Turno::all();
        $pacientes = Paciente::all();

        $fechaActual = Carbon::now()->format('Y-m-d');
        $hoy = Carbon::now();
        $inicioSemana = $hoy->startOfWeek()->addDay();
        $finSemana = $hoy->endOfWeek()->addDay();

        //Obtenemos los turnos pendientes de la semana
        $turnosSemanaPendiente = Turno::where('estado', 'Pendiente')
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->where('fecha', '!=', $fechaActual)
            ->get();

        return view ('nutricionista.gestion-turnos.index', compact('turnos', 'pacientes', 'fechaActual', 'turnosSemanaPendiente'));
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

    public function showHistorialTurnos() {
        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $historiasClinicas = HistoriaClinica::all();
        $tipoConsultas = TipoConsulta::all();

        return view('nutricionista.gestion-turnos.showHistorialTurno', compact('turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas'));
    }

    public function iniciarConsulta($id){
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'No se encontró el turno');
        }

        $paciente = Paciente::where('id', $turno->paciente_id)->first();

        if(!$paciente){
            return redirect()->back()->with('error', 'No se encontró el paciente');
        }

        $tipoConsultas = TipoConsulta::all();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $tratamientos = Tratamiento::all();
        $plieguesCutaneos = TiposDePliegueCutaneo::all();

        $turnosPaciente = Turno::where('paciente_id', $paciente->id)->where('estado', 'Realizado')->get();
        $tratamientosPaciente = TratamientoPorPaciente::where('paciente_id', $paciente->id)->get();

        $turnoAnteriorPaciente = Turno::where('paciente_id', $paciente->id)->where('estado', 'Realizado')->orderBy('id', 'desc')->first();
        $consultaAnteriorPaciente = Consulta::where('turno_id', $turnoAnteriorPaciente->id)->first();

        $medidaPliegueTricep = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 1)->orderBy('id', 'desc')->first();
        $medidaPliegueBicep = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 3)->orderBy('id', 'desc')->first();
        $medidaPliegueSubescapular = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 4)->orderBy('id', 'desc')->first();
        $medidaPliegueSuprailiaco = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 5)->orderBy('id', 'desc')->first();
        $medidaDiametroHumero = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 6)->orderBy('id', 'desc')->first();
        $medidaDiametroMunieca = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 7)->orderBy('id', 'desc')->first();
        $medidaDiametroFemur = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 8)->orderBy('id', 'desc')->first();
        $medidaDiametroTobillo = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 9)->orderBy('id', 'desc')->first();

        if(!$historiaClinica){
            return redirect()->back()->with('error', 'No se encontró la historia clínica');
        }

        return view('nutricionista.gestion-turnos.gestion-consultas.registrarConsulta', compact('paciente', 'turno', 'tipoConsultas', 'historiaClinica', 'tratamientos', 'plieguesCutaneos', 'turnosPaciente', 'tratamientosPaciente', 'turnoAnteriorPaciente', 'consultaAnteriorPaciente', 'medidaPliegueTricep', 'medidaPliegueBicep', 'medidaPliegueSubescapular', 'medidaPliegueSuprailiaco', 'medidaDiametroHumero', 'medidaDiametroMunieca', 'medidaDiametroFemur', 'medidaDiametroTobillo'));
    }

    public function confirmarInasistencia($id){
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'No se encontró el turno');
        }

        $turno->estado = 'Inasistencia';
        $turno->save();

        return redirect()->back()->with('success', 'Se confirmó la inasistencia del paciente');

    }
}
