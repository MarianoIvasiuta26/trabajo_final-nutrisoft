<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\HorasAtencion;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\AdelantamientoTurno;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use DateInterval;
use DateTime;
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
        $horas = HorasAtencion::all();
        $horarios = HorariosAtencion::all();
        $profesionales = Nutricionista::where('user_id', 2)->get();
        return view('paciente.historia-clinica.adelantamiento-turnos.create', compact('dias', 'horas', 'horarios', 'paciente', 'profesionales'));
    }

    public function guardar(Request $request){
        // Obtenemos el nutricionista autenticado
        $paciente = Paciente::where('user_id', auth()->id())->first();/*
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
        }*/

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

/*
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
        $profesional = $request->input('profesional');
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
        session()->put('profesional', $profesional);
        session()->put('dias_y_horas_fijas', true);
        return redirect()->route('historia-clinica.create')->with('success', 'Días y horas disponibles registrados');
        //return response()
        //->json(array('success' => true, 'horarios_libres' => true, 'message' => 'Días y horas libres registrados'));
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

    public function obtenerDias(Request $request){
        $profesionalSeleccionado = $request->input('profesional');
        $profesional = Nutricionista::find($profesionalSeleccionado);

        if(!$profesional){
            return response()->json(['error' => 'No se encontró el profesional']);
        }

        $horarios = HorariosAtencion::where('nutricionista_id', $profesional->id)->get();
        $diasAtencion = DiasAtencion::all();

        $diasFijos = [];
        $diasAgregados = [];

        foreach($horarios as $horario){
            foreach($diasAtencion as $diaAtencion){
                if($horario->dia_atencion_id == $diaAtencion->id && !in_array($diaAtencion->dia, $diasAgregados)){
                    $diasFijos[] = $diaAtencion->dia;
                    $diasAgregados[] = $diaAtencion->dia;
                }
            }
        }

        if(empty($diasFijos)){
            return response()->json(['error' => 'No se encontraron días disponibles']);
        }

        return response()->json([
            'diasFijos' => $diasFijos,
        ]);

    }

    public function obtenerHoras(Request $request){

        $profesionalSeleccionado = $request->input('profesional');
        $profesional = Nutricionista::find($profesionalSeleccionado);
        $diaSeleccionado = $request->input('dia');

        $horasManiana = HorasAtencion::where('etiqueta', 'Maniana')->get();
        $horasTarde = HorasAtencion::where('etiqueta', 'Tarde')->get();
        $intervalo = new DateInterval('PT30M'); //Intervalo de 30 minutos
        $diasAtencion = DiasAtencion::all();

        if(!$profesional){
            return response()->json(['error' => 'No se encontró el profesional']);
        }

        $horarios = HorariosAtencion::where('nutricionista_id', $profesional->id)->get();
        $horas = [];
        foreach($horarios as $horario){
            foreach($diasAtencion as $diaAtencion){
                foreach($horasManiana as $horaManiana){
                    if($horario->dia_atencion_id == $diaAtencion->id && $horario->hora_atencion_id == $horaManiana->id && $diaAtencion->dia == $diaSeleccionado){
                        $horaInicio = new DateTime($horaManiana->hora_inicio);
                        $horaFin = new DateTime($horaManiana->hora_fin);
                        while ($horaInicio < $horaFin) {
                            $horas[] = $horaInicio->format('H:i');
                            $horaInicio->add($intervalo);
                        }
                    }
                }
            }
        }

        foreach($horarios as $horario){
            foreach($diasAtencion as $diaAtencion){
                foreach($horasTarde as $horaTarde){
                    if($horario->dia_atencion_id == $diaAtencion->id && $horario->hora_atencion_id == $horaTarde->id && $diaAtencion->dia == $diaSeleccionado){
                        $horaInicio = new DateTime($horaTarde->hora_inicio);
                        $horaFin = new DateTime($horaTarde->hora_fin);
                        while ($horaInicio < $horaFin) {
                            $horas[] = $horaInicio->format('H:i');
                            $horaInicio->add($intervalo);
                        }
                    }
                }
            }
        }

        if(empty($horas)){
            return response()->json(['error' => 'No se encontraron horas disponibles']);
        }

        return response()->json([
            'profesional' => $profesional,
            'horas' => $horas,
        ]);
    }
}
