<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\HorasAtencion;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\TipoConsulta;
use App\Models\Turno;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnos = Turno::all();
        $paciente = Paciente::where('user_id', auth()->user()->id)->first();
        $tipo_consultas = TipoConsulta::all();
        return view('paciente.turnos-paciente.index', compact('turnos', 'paciente', 'tipo_consultas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $horarios = HorariosAtencion::all();
        $tipo_consultas = TipoConsulta::all();
        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $profesionales = Nutricionista::all();
        $historias_clinicas = HistoriaClinica::all();
        $horas = HorasAtencion::all();
        $dias = DiasAtencion::all();
        $paciente = Paciente::where('user_id', auth()->user()->id)->first();

        return view ('paciente.turnos-paciente.create', compact('horarios', 'tipo_consultas', 'turnos', 'pacientes', 'profesionales', 'historias_clinicas', 'horas', 'dias', 'paciente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos el formulario
        $request->validate([
            'profesional' => ['required', 'integer'],
            'tipo_consulta' => ['required', 'integer'],
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
        ]);

        //Obtenemos los datos del formulario
        $profesional = $request->input('profesional');
        $paciente = Paciente::where('user_id', auth()->user()->id)->first();
        $tipo_consulta = $request->input('tipo_consulta');
        $fecha = $request->input('fecha');
        $hora = $request->input('hora');

        //Buscamos el profesional seleccionado
        $profesionalExistente = Nutricionista::find($profesional);

        //Verificamos que exista
        if(!$profesionalExistente){
            return redirect()->back()->with('error', 'Profesional no válido');
        }

        //Buscamos el paciente
        $pacienteExistente = Paciente::find($paciente->id);

        //Verificamos que exista
        if(!$pacienteExistente){
            return redirect()->back()->with('error', 'Paciente no válido');
        }

        //Buscamos y verificamos que exista el tipo de consulta
        $tipoConsultaExistente = TipoConsulta::find($tipo_consulta);

        if(!$tipoConsultaExistente){
            return redirect()->back()->with('error', 'Tipo de consulta no válido');
        }

        //Validamos que se solicite el turno con al menos 24 horas de anticipación
        // Obtener la fecha y hora actual
        $fechaActual = Carbon::now();
        // Calcular la fecha mínima permitida (24 horas de anticipación)
        $fechaMinima = $fechaActual->copy()->addDay();
        //Obtenemos la fecha y hora seleccionada
        $fechaElegida = Carbon::parse($fecha . ' ' . $hora);
        //Comparamos las fechas
        if($fechaElegida < $fechaMinima){
            return redirect()->back()->with('error', 'Debes solicitar un turno con al menos 24 horas de anticipación.');
        }

        //Obtenemos la fecha actual con formato: año-mes-día y validamos
        $fechaActual = date('Y-m-d');

        if($fecha < $fechaActual){
            return redirect()->back()->with('error', 'La fecha no puede ser anterior a la fecha actual');
        }

        $fechaActual = date('Y-m-d');

        if($fecha == $fechaActual){
            $horaActual = date('H:i');
            if($hora < $horaActual){
                return redirect()->back()->with('error', 'La hora no puede ser anterior a la hora actual');
            }
        }

        $fechaActual = date('Y-m-d');

        if($fecha == $fechaActual){
            $horaActual = date('H:i');
            if($hora == $horaActual){
                return redirect()->back()->with('error', 'La hora no puede ser igual a la hora actual');
            }
        }

        $fechaSeleccionada = $request->input('fecha');
            $fechaNueva = new DateTime($fechaSeleccionada);
            //Obtenemos el número del día de la semana
            $numeroDiaSemana = $fechaNueva->format('w'); // 0: Domingo, 1: Lunes, 2: Martes, etc.
            switch ($numeroDiaSemana) {
                case 0:
                    $diaSeleccionado = 'Domingo';
                    break;
                case 1:
                    $diaSeleccionado = 'Lunes';
                    break;
                case 2:
                    $diaSeleccionado = 'Martes';
                    break;
                case 3:
                    $diaSeleccionado = 'Miercoles';
                    break;
                case 4:
                    $diaSeleccionado = 'Jueves';
                    break;
                case 5:
                    $diaSeleccionado = 'Viernes';
                    break;
                case 6:
                    $diaSeleccionado = 'Sabado';
                    break;
                default:

                    break;
            }

            $diasAtencion = DiasAtencion::where('dia', $diaSeleccionado)->get();
            $horarios = HorariosAtencion::all();
            $horasAtencion = HorasAtencion::all();

            // Obtenemos la hora seleccionada en formato "H:i" (por ejemplo, "14:30")
            $horaSeleccionada = $request->input('hora');

            // Crea un objeto Carbon a partir de la hora seleccionada
            $horaCarbon = Carbon::createFromFormat('H:i', $horaSeleccionada);

            // Comprueba si la hora está en la mañana (antes de las 12:00 PM)
            if ($horaCarbon->lt(Carbon::createFromTime(12, 0))) {
                $periodoDelDia = 'Maniana';
            } else {
                $periodoDelDia = 'Tarde';
            }

            $horarioId = null;

            foreach($diasAtencion as $diaAtencion){
                foreach($horarios as $horario){
                    if($diaAtencion->id == $horario->dia_atencion_id && $horario->nutricionista_id == $profesionalExistente->id){
                        foreach($horasAtencion as $horaAtencion){
                            if($horaAtencion->id == $horario->hora_atencion_id && $periodoDelDia == $horaAtencion->etiqueta){
                                $horarioId = $horario->id;
                                break;
                            }
                        }
                    }
                }
            }

        $turnoCreado = Turno::create([
            'paciente_id' => $pacienteExistente->id,
            'horario_id' => $horarioId,
            'tipo_consulta_id' => $tipo_consulta,
            'fecha' => $fecha,
            'hora' => $hora,
            'estado' => 'Pendiente',
        ]);

        if(!$turnoCreado){
            return redirect()->back()->with('error', 'Error al registrar el turno.');
        }

        return redirect()->route('turnos.index')->with('success', 'Turno registrado correctamente.');


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
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        $paciente = Paciente::where('user_id', auth()->user()->id)->first();
        $horarios = HorariosAtencion::all();
        $tipo_consultas = TipoConsulta::all();
        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $profesionales = Nutricionista::all();
        $historias_clinicas = HistoriaClinica::all();
        $horas = HorasAtencion::all();
        $dias = DiasAtencion::all();
        $horaSeleccionada = $turno->hora;

        return view('paciente.turnos-paciente.edit', compact('turno', 'paciente', 'horarios', 'tipo_consultas', 'turnos', 'pacientes', 'profesionales', 'historias_clinicas', 'horas', 'dias', 'paciente', 'horaSeleccionada'));

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
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'El turno no existe.');
        }

        $turno->estado = 'Cancelado';
        $turno->save();

        return redirect()->route('turnos.index')->with('success', 'Turno cancelado correctamente.');
    }

    public function horasDisponibles(Request $request){

        $horarios = HorariosAtencion::all();
        $dias = DiasAtencion::all();
        $profesionalSeleccionado = $request->input('profesional');
        $profesional = Nutricionista::find($profesionalSeleccionado);

        if($profesional){
            $fechaSeleccionada = $request->input('fecha');
            $fecha = new DateTime($fechaSeleccionada);
            //Obtenemos el número del día de la semana
            $numeroDiaSemana = $fecha->format('w'); // 0: Domingo, 1: Lunes, 2: Martes, etc.
            switch ($numeroDiaSemana) {
                case 0:
                    $diaSeleccionado = 'Domingo';
                    break;
                case 1:
                    $diaSeleccionado = 'Lunes';
                    break;
                case 2:
                    $diaSeleccionado = 'Martes';
                    break;
                case 3:
                    $diaSeleccionado = 'Miercoles';
                    break;
                case 4:
                    $diaSeleccionado = 'Jueves';
                    break;
                case 5:
                    $diaSeleccionado = 'Viernes';
                    break;
                case 6:
                    $diaSeleccionado = 'Sabado';
                    break;
                default:

                    break;
            }

            $horasManiana = HorasAtencion::where('etiqueta', 'Maniana')->get();
            $horasTarde = HorasAtencion::where('etiqueta', 'Tarde')->get();

            $turnos = Turno::all();

            $intervalo = new DateInterval('PT30M'); //Intervalo de 30 minutos
            $horasDisponiblesManiana = [];
            $horasDisponiblesTarde = [];

            // Recorremos las horas de la mañana para dividirlas en un rango de 30 minutos
            foreach ($horasManiana as $horaManiana) {
                foreach($dias as $dia){
                    foreach($horarios as $horario){
                        if($dia->id == $horario->dia_atencion_id && $horario->nutricionista_id == $profesional->id && $diaSeleccionado == $dia->dia && $horaManiana->
                        id == $horario->hora_atencion_id){
                            $horaInicio = new DateTime($horaManiana->hora_inicio);
                            $horaFin = new DateTime($horaManiana->hora_fin);
                            while ($horaInicio < $horaFin) {
                                $horaActual = $horaInicio->format('H:i');
                                $horaOcupada = false; // Variable para indicar si la hora está ocupada

                                // Comprobamos si hay un turno pendiente en esta hora
                                foreach ($turnos as $turno) {
                                    $horaTurno = Carbon::parse($turno->hora)->format('H:i');
                                    if ($turno->fecha == $fechaSeleccionada && $horaTurno == $horaActual && $turno->estado == 'Pendiente') {
                                        $horaOcupada = true;
                                        break; // No necesitamos seguir buscando
                                    }
                                }

                                // Si la hora no está ocupada, la agregamos a las disponibles
                                if (!$horaOcupada) {
                                    $horasDisponiblesManiana[] = $horaActual;
                                }

                                // Incrementamos la hora actual
                                $horaInicio->add($intervalo);
                            }
                        }
                    }
                }
            }

            //Recorremos las horas de la tarde para dividirla en un rango de 30 minutos

            foreach ($horasTarde as $horaTarde) {
                foreach($dias as $dia){
                    foreach($horarios as $horario){
                        if($dia->id == $horario->dia_atencion_id && $horario->nutricionista_id == $profesional->id && $diaSeleccionado == $dia->dia && $dia->seleccionado == 1 && $horaTarde->id == $horario->hora_atencion_id){
                            $horaInicio = new DateTime($horaTarde->hora_inicio);
                            $horaFin = new DateTime($horaTarde->hora_fin);
                            while ($horaInicio < $horaFin) {
                                $horaActual = $horaInicio->format('H:i');
                                $horaOcupada = false; // Variable para indicar si la hora está ocupada

                                // Comprobamos si hay un turno pendiente en esta hora
                                foreach ($turnos as $turno) {
                                    if ($turno->fecha == $fechaSeleccionada && $turno->hora == $horaActual && $turno->estado == 'Pendiente') {
                                        $horaOcupada = true;
                                        break; // No necesitamos seguir buscando
                                    }
                                }

                                // Si la hora no está ocupada, la agregamos a las disponibles
                                if (!$horaOcupada) {
                                    $horasDisponiblesTarde[] = $horaActual;
                                }

                                // Incrementamos la hora actual
                                $horaInicio->add($intervalo);
                            }
                        }
                    }
                }
            }
            if ($horasDisponiblesManiana || $horasDisponiblesTarde) {
                return response()->json([
                    'horasDisponiblesManiana' => $horasDisponiblesManiana,
                    'horasDisponiblesTarde' => $horasDisponiblesTarde
                ]);
            } else {
                return response()->json(['error' => 'No hay horarios disponibles para la fecha seleccionada o este día no se realizan consultas.']);
            }
        } else {
            return response()->json(['error' => 'Profesional no válido']);
        }
    }
}
