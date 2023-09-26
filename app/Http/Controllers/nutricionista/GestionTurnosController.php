<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\TipoConsulta;
use App\Models\Turno;
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
        return view ('nutricionista.gestion-turnos.index', compact('turnos', 'pacientes'));
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

        if(!$historiaClinica){
            return redirect()->back()->with('error', 'No se encontró la historia clínica');
        }

        return view('nutricionista.gestion-turnos.gestion-consultas.registrarConsulta', compact('paciente', 'turno', 'tipoConsultas', 'historiaClinica'));
    }
}
