<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\AdelantamientoTurno;
use Illuminate\Http\Request;

class AdelantamientoTurnoController extends Controller
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
        // Obtenemos el nutricionista autenticado
        $paciente = Paciente::where('user_id', auth()->id())->first();

        //Días y horarios fijos
        $diasFijos = $request->input('diasFijos');
        $horasFijas = $request->input('horasFijas');
        $existe = false;

        foreach($diasFijos as $diaFijo){
            foreach($horasFijas as $horaFija){
                //Verificamos si ya existe un registro de esos días y horarios fijos
                $existe = AdelantamientoTurno::where(
                    [
                        ['paciente_id', $paciente->id],
                        ['horas_fijas', $horaFija],
                        ['dias_fijos', $diaFijo],
                    ]
                )->first();

                if(!$existe){
                    AdelantamientoTurno::create([
                        'paciente_id' => $paciente->id,
                        'horas_fijas' => $horaFija,
                        'dias_fijos' => $diaFijo,
                    ]);

                    return redirect()->route('historia-clinica.create')->with('success', 'Días y horas disponibles registrados');
                }else{
                    break;
                }
            }
        }

        if($existe){
            return redirect()->route('historia-clinica.create')->with('error', 'Ya existe un paciente con estos datos');
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
}
