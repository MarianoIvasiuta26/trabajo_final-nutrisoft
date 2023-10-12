<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\HorasAtencion;
use App\Models\Nutricionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class HorasDiasAtencionController extends Controller
{
    public function index(){

        $nutricionista = Nutricionista::where('user_id', auth()->id())->first(); //Obtenemos al nutricionista
        $dias = DiasAtencion::all(); //Obtenemos los días
        $horarios = HorariosAtencion::all(); //Obtenemos los horairos registrados
        $horas = HorasAtencion::all(); //Obtenemos las horas registradas

        return view('nutricionista.atencion.index', compact('nutricionista', 'dias', 'horarios', 'horas'));
    }

    public function create(){
        $nutricionista = Nutricionista::where('user_id', auth()->id())->first(); //Obtenemos al nutricionista
        return view('nutricionista.atencion.consulta', compact('nutricionista'));
    }

    public function store(Request $request)
    {
        // Validamos los datos
        Validator::make($request->all(), [
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i'],
            'etiqueta' => ['required', 'string'],
        ])->validate();

        // Obtenemos el nutricionista autenticado
        $nutricionista = Nutricionista::where('user_id', auth()->id())->first();

        //horas
        $horaInicio = $request->input('hora_inicio');
        $horaFin = $request->input('hora_fin');
        $etiqueta = $request->input('etiqueta');

        //Verificamos si ya existe un registro con los mismos datos
        $horas = HorasAtencion::where(
            [
                ['hora_inicio', $horaInicio],
                ['hora_fin', $horaFin],
                ['etiqueta', $etiqueta],
            ]
        )->first();

        if(!$horas){
            //Si no existe ningún registro dehora con los mismos datos
            //Creamos el registro en la tabla horas_atencions
            $horas = HorasAtencion::create([
                'hora_inicio' => $horaInicio,
                'hora_fin' => $horaFin,
                'etiqueta' => $etiqueta,
            ]);
        }

        //días
        $dias = $request->input('dias_atencion');
        $horarioExistente =false;

        foreach ($dias as $dia) {

            //Verificamos que existe el día en la tabla DiasAtencion
            $diaExistente = DiasAtencion::where('dia', $dia)->first();

            $horarioExistente = HorariosAtencion::where(
                [
                    ['nutricionista_id', $nutricionista->id],
                    ['dia_atencion_id', $diaExistente->id],
                    ['hora_atencion_id', $horas->id],
                ]
            )->first();

            if(!$horarioExistente){
                //Si no existe el horario se crea
                HorariosAtencion::create([
                    'nutricionista_id' => $nutricionista->id,
                    'dia_atencion_id' => $diaExistente->id,
                    'hora_atencion_id' =>$horas->id,
                ]);
                $diaExistente->seleccionado = true;
                $diaExistente->save();
            }else{
                //Si ya existe un registro con los mismos datos
                break;
            }

        }

        if($horarioExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Horario ya registrado');
        }

        return redirect()->route('gestion-atencion.index')->with('success', 'Dias y horarios registrados!');
    }


    public function edit($id){
        $horario = HorariosAtencion::find($id);
        $nutricionista = Nutricionista::where('user_id', auth()->id())->first(); //Obtenemos al nutricionista
        $dia = DiasAtencion::where('id', $horario->dia_atencion_id)->first(); //Obtenemos los días
        $hora = HorasAtencion::where('id', $horario->hora_atencion_id)->first(); //Obtenemos las horas registradas
        return view('nutricionista.atencion.edit', compact('horario', 'nutricionista', 'dia', 'hora'));
    }

    public function update(Request $request, $id)
    {
        $horario = HorariosAtencion::find($id);

        $rules = [
            'etiqueta' => ['required', 'string'],
        ];

        // Agrega validación de hora solo si se proporciona un valor
        if ($request->filled('hora_inicio') || $request->filled('hora_fin')) {
            $rules['hora_inicio'] = ['required', 'date_format:H:i'];
            $rules['hora_fin'] = ['required', 'date_format:H:i'];
        }

        $datos = $request->validate($rules);

        if ($horario) {

            // Obtén las horas existentes con los mismos valores
            $horaExistente = HorasAtencion::where([
                'hora_inicio' => $request->input('hora_inicio'),
                'hora_fin' => $request->input('hora_fin'),
                'etiqueta' => $request->input('etiqueta'),
            ])->first();

            if (!$horaExistente) {
                // Si no existe una hora con los mismos valores, crea una nueva
                $horaExistente = HorasAtencion::create([
                    'hora_inicio' => $request->input('hora_inicio'),
                    'hora_fin' => $request->input('hora_fin'),
                    'etiqueta' => $request->input('etiqueta'),
                ]);
            }

            // Asigna la hora existente al horario
            $horario->hora_atencion_id = $horaExistente->id;
            $horario->save();
            
            return redirect()->route('gestion-atencion.index')->with('success', 'Horario editado correctamente');
        } else {
            return redirect()->route('gestion-atencion.index')->with('error', 'No se pudo editar el horario');
        }
    }


    public function destroy($id){

        $horario = HorariosAtencion::find($id);

        if (!$horario) {
            return redirect()->route('gestion-atencion.index')->with('error', 'Horario no encontrado');
        } else{
            $horario->delete();
            return redirect()->route('gestion-atencion.index')->with('success', 'Horario eliminado');
        }

    }

}
