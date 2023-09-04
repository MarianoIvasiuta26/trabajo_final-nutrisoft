<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\Nutricionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class HorasDiasAtencionController extends Controller
{
    public function index(){
        $nutricionistas = Nutricionista::all();
        $dias = DiasAtencion::all();
        return view ('nutricionista.atencion.index', compact('nutricionistas', 'dias'));
    }

    public function create(){

        return view('nutricionista.atencion.create');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            // Tus reglas de validación aquí...
            'hora_inicio_maniana' => ['required', 'date_format:H:i'],
            'hora_fin_maniana' => ['required', 'date_format:H:i'],
            'hora_inicio_tarde' => ['required', 'date_format:H:i'],
            'hora_fin_tarde' => ['required', 'date_format:H:i'],
        ])->validate();

        $nutri = Nutricionista::find($request->input('nutricionista_id'));

        if ($nutri) {
            $dias = $request->input('dias_atencion');
            $diasAtencion = [];

            foreach ($dias as $dia) {
                $diasAtencion[] = new DiasAtencion(['dia' => $dia]);
            }

            $nutri->diasAtencion()->saveMany($diasAtencion);

            // Actualiza los campos del nutricionista
            $nutri->hora_inicio_maniana = $request->input('hora_inicio_maniana');
            $nutri->hora_fin_maniana = $request->input('hora_fin_maniana');
            $nutri->hora_inicio_tarde = $request->input('hora_inicio_tarde');
            $nutri->hora_fin_tarde = $request->input('hora_fin_tarde');
            $nutri->save();

            return redirect()->route('gestion-atencion.index')->with('success', 'Dias y horarios registrados!');

        }else{
            return redirect()->route('gestion-atencion.index')->with('error', 'Nutricionista no encontrado');
        }
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

}
