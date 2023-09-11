<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    function hasCompletedHistory() {
        // Obtén el ID del paciente autenticado.
        $pacienteId = auth()->user()->paciente->id;

        // Verifica si existe un registro en la tabla 'historias_clinicas' para el paciente.
        $history = HistoriaClinica::where('paciente_id', $pacienteId)->first();

        // Si se encuentra un registro, el paciente ha completado la Historia Clínica.
        return $history !== null;
    }

    function store(Request $request){

        //Datos personales
    /*
        Validator::make($request->all(), [
            'dni' => ['required', 'string', 'max:8'],
            'sexo' => ['required', 'string', 'max:10'],
            'fecha_nacimiento' => ['required', 'date'],
            'edad' => ['required', 'integer'],
            'telefono' => ['required', 'string', 'max:10'],
        ]);
    */

        $request->validate([
            'dni' => ['required', 'string', 'max:8'],
            'sexo' => ['required', 'string', 'max:10'],
            'fecha_nacimiento' => ['required', 'date'],
            'edad' => ['required', 'integer'],
            'telefono' => ['required', 'string', 'max:10'],
        ]);

        //Obtenemos los datos del form
        $dni = $request->input('dni');
        $sexo = $request->input('sexo');
        $fechaNacimiento = $request->input('fecha_nacimiento');
        $edad = $request->input('edad');
        $telefono = $request->input('telefono');

        //Validamos si existen estos ya registrados
        $datosPersonales = Paciente::where([
            ['fecha_nacimiento' => $fechaNacimiento],
            ['dni' => $dni],
            ['sexo' => $sexo],
            ['edades' => $edad],
            ['telefono' => $telefono],
        ])->first();

        if(!$datosPersonales){
            // Obtenemos el paciente autenticado
            $paciente = Paciente::where('user_id', auth()->id())->first();

            //Si no existen los datos ingresados Agregamos estos datos al paciente
            $paciente->dni = $dni;
            $paciente->sexo = $sexo;
            $paciente->fecha_nacimiento = $fechaNacimiento;
            $paciente->edad = $edad;
            $paciente->telefono = $telefono;

            $paciente->save();
            return redirect()->route('historia-clinica.create')->with('success', 'Datos personales registrados');
        }else{
            return redirect()->route('historia-clinica.create')->with('error', 'Ya existe un paciente con estos datos');
        }
    }
}
