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
        $dias = DiasAtencion::where('id', $horario->dia_atencion_id)->get(); //Obtenemos los días
        $hora = HorasAtencion::where('id', $horario->hora_atencion_id)->first(); //Obtenemos las horas registradas
        return view('nutricionista.atencion.edit', compact('horario', 'nutricionista', 'dias', 'hora'));
    }

    public function update(Request $request, $id)
    {
         // Obtén el horario a actualizar
        $horario = HorariosAtencion::find($id);

        // Validar los datos
        $data = $request->validate([
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin' => ['required', 'date_format:H:i'],
            'etiqueta' => ['required', 'string'],
            'dias_atencion' => ['array', 'min:1'], // Validar que al menos un día esté seleccionado
        ]);

        // Obtener las horas de atención actuales
        $horaInicio = $data['hora_inicio'];
        $horaFin = $data['hora_fin'];
        $etiqueta = $data['etiqueta'];

        // Obtener las horas de atención actuales
        $horasAtencion = $horario->horasAtencion;

        if ($horasAtencion) {
            $horasAtencion->hora_inicio = $horaInicio;
            $horasAtencion->hora_fin = $horaFin;
            $horasAtencion->etiqueta = $etiqueta;
            $horasAtencion->save();
        } else {
            return redirect()->back()->with('error', 'Horas de atención no encontradas');
        }

        // Obtener los días de atención seleccionados
        $dias = $data['dias_atencion'];

        $diaIds = [];

        // Obtener los IDs de los días de atención
        foreach ($dias as $dia) {
            $diaExistente = DiasAtencion::where('dia', $dia)->first();
            if ($diaExistente) {
                $diaIds[] = $diaExistente->id;
            }
        }

        // Actualizar los días de atención
        $horario->diasAtencion()->sync($diaIds);

        return redirect()->route('nutricionista.atencion.index')->with('success', 'Horario modificado.');
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
