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

        //Creamos el registro en la tabla horas_atencions
        $horas = HorasAtencion::create([
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'etiqueta' => $etiqueta,
        ]);

        //días
        $dias = $request->input('dias_atencion');

        foreach ($dias as $dia) {

            //Verificamos que existe el día en la tabla DiasAtencion
            $diaExistente = DiasAtencion::where('dia', $dia)->first();

            HorariosAtencion::create([
                'nutricionista_id' => $nutricionista->id,
                'dia_atencion_id' => $diaExistente->id,
                'hora_atencion_id' =>$horas->id,
            ]);


        }

        return redirect()->route('gestion-atencion.index')->with('success', 'Dias y horarios registrados!');
    }


    public function edit($id){
        $nutricionista = Nutricionista::find($id);
        return view('nutricionista.atencion.edit')->with('nutricionista', $nutricionista);
    }

    public function update(Request $request, $id)
    {
        $nutri = Nutricionista::find($id);

        Validator::make($request->all(), [
            // Tus reglas de validación aquí...
            'hora_inicio_maniana' => ['required', 'date_format:H:i'],
            'hora_fin_maniana' => ['required', 'date_format:H:i'],
            'hora_inicio_tarde' => ['required', 'date_format:H:i'],
            'hora_fin_tarde' => ['required', 'date_format:H:i'],
        ])->validate();

        if (!$nutri) {
            $nutri->hora_inicio_maniana = $request->input('hora_inicio_maniana');
            $nutri->hora_fin_maniana = $request->input('hora_fin_maniana');
            $nutri->hora_inicio_tarde = $request->input('hora_inicio_tarde');
            $nutri->hora_fin_tarde = $request->input('hora_fin_tarde');
            $nutri->save();

            return $nutri;
        } else{
            return redirect()->route('nutricionista.atencion.index')->with('error', 'Usuario no encontrado');
        }

    }

    public function destroy($id){



    }

}
