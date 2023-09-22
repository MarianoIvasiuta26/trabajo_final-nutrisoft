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
        $paciente = Paciente::where('id', auth()->user()->id)->first();
        return view('paciente.turnos-paciente.index', compact('turnos', 'paciente'));
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
        /*
        $horasManiana = HorasAtencion::where('etiqueta', 'Maniana')->get();
        $horasTarde = HorasAtencion::where('etiqueta', 'Tarde')->get();

        $intervalo = new DateInterval('PT30M'); //Intervalo de 30 minutos
        $horasDisponiblesManiana = [];
        $horasDisponiblesTarde = [];

       // Recorremos las horas de la mañana para dividirlas en un rango de 30 minutos
        foreach ($horasManiana as $horaManiana) {
            $horaInicio = new DateTime($horaManiana->hora_inicio);
            $horaFin = new DateTime($horaManiana->hora_fin);
            while ($horaInicio < $horaFin) {
                $horasDisponiblesManiana[] = $horaInicio->format('H:i');
                $horaInicio->add($intervalo);
            }
        }

        //Recorremos las horas de la tarde para dividirla en un rango de 30 minutos

        foreach ($horasTarde as $horaTarde) {
            $horaInicio = new DateTime($horaTarde->hora_inicio);
            $horaFin = new DateTime($horaTarde->hora_fin);
            while ($horaInicio < $horaFin) {
                $horasDisponiblesTarde[] = $horaInicio->format('H:i');
                $horaInicio->add($intervalo);
            }
        }*/


        return view ('paciente.turnos-paciente.create', compact('horarios', 'tipo_consultas', 'turnos', 'pacientes', 'profesionales', 'historias_clinicas', 'horas', 'dias'));
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
/*
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
                        if($dia->id == $horario->dia_atencion_id && $horario->nutricionista_id == $profesional->id && $diaSeleccionado == $dia->dia && $horaManiana->id == $horario->hora_atencion_id){
                            $horaInicio = new DateTime($horaManiana->hora_inicio);
                            $horaFin = new DateTime($horaManiana->hora_fin);
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
                                    $horasDisponiblesManiana[] = $horaActual;
                                }
                            }
                        }
                    }
                    // Incrementamos la hora actual
                    $horaInicio->add($intervalo);
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
            return response()->json([
                'horasDisponiblesManiana' => $horasDisponiblesManiana,
                'horasDisponiblesTarde' => $horasDisponiblesTarde
            ]);
        }else{
            return response()->json(['error' => 'Profesional no válido']);
        }

    }
*/

//Crea la función horasDisponibles(Request $request) y que las horas que se muestren sean del profesional seleccionado, y que se muestren las horas libres solo si la fecha seleccionada coincide con los días de atención de dicho profesional

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
                                    if ($turno->fecha == $fechaSeleccionada && $turno->hora == $horaActual && $turno->estado == 'Pendiente') {
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
            return response()->json([
                'horasDisponiblesManiana' => $horasDisponiblesManiana,
                'horasDisponiblesTarde' => $horasDisponiblesTarde
            ]);
        } else {
            return response()->json(['error' => 'Profesional no válido']);
        }
    }






}
