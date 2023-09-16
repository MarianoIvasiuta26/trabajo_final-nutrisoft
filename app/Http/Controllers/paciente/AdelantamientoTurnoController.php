<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\Paciente;
use App\Models\Paciente\AdelantamientoTurno;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
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
        $paciente = Paciente::where('user_id', auth()->id())->first();
        $dias = DiasAtencion::all();
        $horarios = HorariosAtencion::all();
        return view('paciente.historia-clinica.adelantamiento-turnos.create', compact('dias', 'horarios', 'paciente'));
    }

    public function guardar(Request $request){
        // Obtenemos el nutricionista autenticado
        $paciente = Paciente::where('user_id', auth()->id())->first();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Si no existe la historia clinica del paciente, la creamos
        if (!$historiaClinica) {
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => 0,
                'altura' => 0,
                'circunferencia_munieca' => 0,
                'circunferencia_cadera' => 0,
                'circunferencia_cintura' => 0,
                'circunferencia_pecho' => 0,
                'estilo_vida' => '',
                'objetivo_salud' => '',
            ]);
        }
/*
        //Obtenemos los datos médicos de la historia clínica
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();

        if(!$datosMedicos){
            //Si no existe se crea
            $datosMedicos = DatosMedicos::create([
                'historia_clinica_id' => $historiaClinica->id,
                'alergia_id' => 0,
                'patologia_id' => 0,
                'intolerancia_id' => 0,
                'valor_analisis_clinico_id' => 0,
            ]);
        }
*/
        // Días y horarios fijos
        $diasFijos = $request->input('diasFijos');
        $horasFijas = $request->input('horasFijas');

        foreach ($diasFijos as $diaFijo) {
            foreach ($horasFijas as $horaFija) {
                // Verificamos si ya existe un registro de esos días y horarios fijos
                $existe = AdelantamientoTurno::where([
                    ['paciente_id', $paciente->id],
                    ['horas_fijas', $horaFija],
                    ['dias_fijos', $diaFijo],
                ])->first();

                if (!$existe) {
                    AdelantamientoTurno::create([
                        'paciente_id' => $paciente->id,
                        'horas_fijas' => $horaFija,
                        'dias_fijos' => $diaFijo,
                    ]);
                }
            }
        }

        return redirect()->route('historia-clinica.index')->with('success', 'Días y horas disponibles registrados');
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
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Si no existe la historia clinica del paciente, la creamos
        if (!$historiaClinica) {
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => 0,
                'altura' => 0,
                'circunferencia_munieca' => 0,
                'circunferencia_cadera' => 0,
                'circunferencia_cintura' => 0,
                'circunferencia_pecho' => 0,
                'estilo_vida' => '',
                'objetivo_salud' => '',
            ]);
        }
/*
        //Obtenemos los datos médicos de la historia clínica
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();

        if(!$datosMedicos){
            //Si no existe se crea
            $datosMedicos = DatosMedicos::create([
                'historia_clinica_id' => $historiaClinica->id,
                'alergia_id' => 0,
                'patologia_id' => 0,
                'intolerancia_id' => 0,
                'valor_analisis_clinico_id' => 0,
            ]);
        }
*/
        // Días y horarios fijos
        $diasFijos = $request->input('diasFijos');
        $horasFijas = $request->input('horasFijas');

        foreach ($diasFijos as $diaFijo) {
            foreach ($horasFijas as $horaFija) {
                // Verificamos si ya existe un registro de esos días y horarios fijos
                $existe = AdelantamientoTurno::where([
                    ['paciente_id', $paciente->id],
                    ['horas_fijas', $horaFija],
                    ['dias_fijos', $diaFijo],
                ])->first();

                if (!$existe) {
                    AdelantamientoTurno::create([
                        'paciente_id' => $paciente->id,
                        'horas_fijas' => $horaFija,
                        'dias_fijos' => $diaFijo,
                    ]);
                }
            }
        }

        return redirect()->route('historia-clinica.create')->with('success', 'Días y horas disponibles registrados');
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
        $paciente = Paciente::find($id);
        $dias = DiasAtencion::all();
        $horarios = HorariosAtencion::all();
        $adelantamientos = AdelantamientoTurno::where('paciente_id', $paciente->id)->get();
        return view('paciente.historia-clinica.adelantamiento-turnos.edit', compact('dias', 'horarios', 'adelantamientos', 'paciente'));
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
        $paciente = Paciente::find($id);

        // Días y horarios fijos
        $diasFijos = $request->input('diasFijos');
        $horasFijas = $request->input('horasFijas');

        if($paciente){
            foreach ($diasFijos as $diaFijo) {
                foreach ($horasFijas as $horaFija) {
                    // Verificamos si ya existe un registro de esos días y horarios fijos
                    $adelantamiento = AdelantamientoTurno::where([
                        ['paciente_id', $paciente->id],
                        ['horas_fijas', $horaFija],
                        ['dias_fijos', $diaFijo],
                    ])->first();

                    if (!$adelantamiento) {
                        AdelantamientoTurno::create([
                            'paciente_id' => $paciente->id,
                            'horas_fijas' => $horaFija,
                            'dias_fijos' => $diaFijo,
                        ]);
                    }else{
                        $adelantamiento->horas_fijas->$request->input('horasFijas');
                        $adelantamiento->dias_fijos->$request->input('diasFijos');

                        $adelantamiento->save();
                    }
                }
            }
            return redirect()->route('historia-clinica.index', $paciente->id)->with('success', 'Días y horas disponibles actualizados');
        } else {
            return redirect()->route('adelantamiento-turnos.edit', $paciente->id)->with('error', 'No se pudo actualizar los días y horas disponibles');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adelantamiento = AdelantamientoTurno::find($id);

        if($adelantamiento){
            $adelantamiento->delete();
            return redirect()->route('historia-clinica.index')->with('success', 'Día y hora disponible eliminado');
        } else {
            return redirect()->route('historia-clinica.index')->with('error', 'No se pudo eliminar el día y hora disponible');
        }
    }
}
