<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use Carbon\Carbon;
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

        $request->validate([
            'dni' => ['required', 'string', 'max:8'],
            'sexo' => ['required', 'string', 'max:10'],
            'fecha_nacimiento' => ['required', 'date'],
            'telefono' => ['required', 'string', 'max:10'],
        ]);

        //Obtenemos los datos del form
        $dni = $request->input('dni');
        $sexo = $request->input('sexo');
        $fechaNacimiento = $request->input('fecha_nacimiento');
        $telefono = $request->input('telefono');

        //Validamos si existen estos ya registrados
        $datosPersonales = Paciente::where([
            ['fecha_nacimiento', $fechaNacimiento],
            ['dni', $dni],
            ['sexo', $sexo],
            ['telefono', $telefono],
        ])->first();


        if(!$datosPersonales){
            // Obtenemos el paciente autenticado
            $paciente = Paciente::where('user_id', auth()->id())->first();

            //Calculamos edad
            $fecha_nacimientoIngresado = Carbon::parse($request->fecha_nacimiento);
            $fecha_actual = Carbon::now();
            $edad = $fecha_actual->diffInYears($fecha_nacimientoIngresado);

            //Si no existen los datos ingresados Agregamos estos datos al paciente
            $paciente->dni = $dni;
            $paciente->sexo = $sexo;
            $paciente->fecha_nacimiento = $fechaNacimiento;
            $paciente->edad = $edad;
            $paciente->telefono = $telefono;

            $paciente->save();

            //Verificacimos que no existe ya la historia clínica para el paciente
            $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

            if(!$historiaClinica){
                //Si no existe se crea
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
            return redirect()->route('historia-clinica.create')->with('success', 'Datos personales registrados');
        }else{
            return redirect()->route('historia-clinica.create')->with('error', 'Ya existe un paciente con estos datos');
        }
    }

    public function edit($id)
    {
        $paciente = Paciente::find($id);
        return view('paciente.historia-clinica.datos-personales.edit')->with('paciente', $paciente);
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
        $request->validate([
            'dni' => ['required', 'string', 'max:8'],
            'sexo' => ['required', 'string', 'max:10'],
            'fecha_nacimiento' => ['required', 'date'],
            'edad' => ['required', 'integer'],
            'telefono' => ['required', 'string', 'max:10'],
        ]);

        $paciente = Paciente::find($id);

        if($paciente){
            // Actualiza los campos del paciente
            $paciente->dni = $request->input('dni');
            $paciente->sexo = $request->input('sexo');
            $paciente->fecha_nacimiento = $request->input('fecha_nacimiento');
            $paciente->edad = $request->input('edad');
            $paciente->telefono = $request->input('telefono');

            // Guarda los cambios en la base de datos
            $paciente->save();

            return redirect()->route('historia-clinica.index')->with('success', 'Datos personales actualizados');
        }else{
            return redirect()->route('historia-clinica.index')->with('error', 'Paciente no encontrado');
        }
    }

}

