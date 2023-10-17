<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Consulta;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use App\Models\TipoConsulta;
use App\Models\TiposDePliegueCutaneo;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
use Illuminate\Http\Request;

class GestionConsultasController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //Validamos el form
        $request->validate([
            'tratamiento_paciente' => ['required', 'integer'],
            'observacion' => ['required', 'string', 'max:255'],
            'peso_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'altura_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_munieca_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_cintura_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_cadera_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_pecho_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'diagnostico' => ['required', 'string', 'max:255'],
        ]);

        //Obtenemos los datos del formulario
        $tratamientoPaciente = $request->input('tratamiento_paciente');
        $observacion = $request->input('observacion');
        $pesoActual = $request->input('peso_actual');
        $alturaActual = $request->input('altura_actual');
        $circMuniecaActual = $request->input('circ_munieca_actual');
        $circCinturaActual = $request->input('circ_cintura_actual');
        $circCaderaActual = $request->input('circ_cadera_actual');
        $circPechoActual = $request->input('circ_pecho_actual');
        $diagnostico = $request->input('diagnostico');
        $turno = Turno::find($id);
        $nutricionista = Nutricionista::where('user_id', auth()->user()->id)->first();
        if(!$turno){
            return back()->with('error', 'No se encontró el turno');
        }

        $consultas = Consulta::all();

        foreach($consultas as $consulta){
            if($consulta->turno_id == $turno->id){
                return back()->with('error', 'Ya se realizó la consulta');
            }
        }

        $consulta= Consulta::create([
            'turno_id' => $turno->id,
            'nutricionista_id' => $nutricionista->id,
            'peso_actual' => $pesoActual,
            'altura_actual' => $alturaActual,
            'circunferencia_munieca_actual' => $circMuniecaActual,
            'circunferencia_cintura_actual' => $circCinturaActual,
            'circunferencia_cadera_actual' => $circCaderaActual,
            'circunferencia_pecho_actual' => $circPechoActual,
            'diagnostico' => $diagnostico,
        ]);

        TratamientoPorPaciente::create([
            'tratamiento_id' => $tratamientoPaciente,
            'paciente_id' => $turno->paciente_id,
            'fecha_alta' => $turno->fecha,
            'observaciones' => $observacion,
            'estado' => 'Activo',
        ]);

        $turno->estado = 'Realizado';
        $turno->save();

        //Obtener paciente de la consulta
        $paciente = Paciente::find($turno->paciente_id);

        //DESCOMENTAR
    /*
        if( $turno->estado == 'Realizado'){
            $this->generarPlanesAlimentacion($paciente->id);
        }
    */
        return redirect()->route('gestion-turnos-nutricionista.index')->with('success', 'Consulta realizada con éxito');


    }

    //Función para el 2do proceso automatizado: Generación automática de Plan de alimentación
    public function generarPlanesAlimentacion($id){
        //Buscamos el paciente
        $paciente = Paciente::find($id);

        //Buscamos historia clínica del paciente
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Buscamos datos médicos del paciente
        $datosMedicos = DatosMedicos::where('historia_clinica', $historiaClinica->id)->get();

        //Cirugías del paciente
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica', $historiaClinica->id)->get();

        //Anamnesis alimentaria del paciente
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica', $historiaClinica->id)->get();

        //Obtenemos el tratamiento activo del paciente
        $tratamientoActivo = TratamientoPorPaciente::where('paciente_id', $paciente->id)->where('estado', 'Activo')->first();

        //Obtenemos el tipo de consulta
        $tipoConsulta = TipoConsulta::where('nombre', 'Primera consulta')->first();

        //Obtenemos el nutricionista
        $nutricionista = Nutricionista::where('user_id', auth()->user()->id)->first();

        /* Ver si usar estos o no */

        //Obtenemos el turno
        $turno = Turno::where('paciente_id', $paciente->id)->where('estado', 'Realizado')->first();

        //Obtenemos la consulta
        $consulta = Consulta::where('turno_id', $turno->id)->first();

        //Comenzamos a implementar la lógica para generar el plan

        //Primero debemos calcular el IMC del paciente para saber si está normal o no
        $imc = $consulta->peso_actual / ($consulta->altura_actual * $consulta->altura_actual);

        //Si el IMC es menor a 18.5, el paciente está bajo de peso
        if($imc >= 18.5 && $imc <= 25){
            //IMC normal
            //Usamos la fórmula de Mifflin St. Jeor (No recomendable en pacientes menores de 18 años)
            //para calcular el gasto energético basal
            if($paciente->edad > 18){
                if($paciente->sexo == 'Masculino'){
                    $gastoEnergeticoBasal = (10 * $consulta->peso_actual) + (6.25 * $consulta->altura_actual) - (5 * $paciente->edad) + 5;
                }else{
                    $gastoEnergeticoBasal = (10 * $consulta->peso_actual) + (6.25 * $consulta->altura_actual) - (5 * $paciente->edad) - 161;
                }

                //Calculamos el gasto energético total

                if($historiaClinica->estilo_vida == 'Sedentario'){
                    $gastoEnergeticoTotal = $gastoEnergeticoBasal * 1.2;
                } else if ($historiaClinica->estilo_vida == 'Ligeramente activo'){
                    $gastoEnergeticoTotal = $gastoEnergeticoBasal * 1.375;
                } else if ($historiaClinica->estilo_vida == 'Moderadamente activo'){
                    $gastoEnergeticoTotal = $gastoEnergeticoBasal * 1.55;
                } else if ($historiaClinica->estilo_vida == 'Muy activo'){
                    $gastoEnergeticoTotal = $gastoEnergeticoBasal * 1.725;
                } else if ($historiaClinica->estilo_vida == 'Extra activo'){
                    $gastoEnergeticoTotal = $gastoEnergeticoBasal * 1.9;
                }

                //Verificamos cual es el objetivo de salud del paciente
                if($historiaClinica->objetivo_salud == 'Adelgazar'){
                    $gastoEnergeticoTotal = $gastoEnergeticoTotal - 500;
                } else if ($historiaClinica->objetivo_salud == 'Ganar masa muscular'){
                    $gastoEnergeticoTotal = $gastoEnergeticoTotal + 500;
                } else if ($historiaClinica->objetivo_salud == 'Mantener peso'){
                    $gastoEnergeticoTotal = $gastoEnergeticoTotal;
                }
                    //Calculamos el porcentaje de macronutrientes
                    $proteinas = $gastoEnergeticoTotal * 0.15;
                    $grasas = $gastoEnergeticoTotal * 0.3;
                    $carbohidratos = $gastoEnergeticoTotal * 0.55;

                    //Calculamos el porcentaje de micronutrientes

                    $calcio = $gastoEnergeticoTotal * 0.01;
                    $fosforo = $gastoEnergeticoTotal * 0.01;
                    $magnesio = $gastoEnergeticoTotal * 0.004;
                    $potasio = $gastoEnergeticoTotal * 0.004;
                    $sodio = $gastoEnergeticoTotal * 0.0015;
                    $cloro = $gastoEnergeticoTotal * 0.0023;
                    $hierro = $gastoEnergeticoTotal * 0.00002;
                    $zinc = $gastoEnergeticoTotal * 0.00002;
                    $selenio = $gastoEnergeticoTotal * 0.0000004;
                    $yodo = $gastoEnergeticoTotal * 0.00000015;
                    $vitaminaA = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaD = $gastoEnergeticoTotal * 0.000000015;
                    $vitaminaE = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaC = $gastoEnergeticoTotal * 0.000009;
                    $vitaminaB1 = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaB2 = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaB3 = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaB6 = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaB9 = $gastoEnergeticoTotal * 0.0000009;
                    $vitaminaB12 = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de fibra

                    $fibra = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de agua

                    $agua = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de colesterol

                    $colesterol = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de alcohol

                    $alcohol = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de cafeína

                    $cafeina = $gastoEnergeticoTotal * 0.0000009;

                    //Calculamos el porcentaje de azúcar

                    $azucar = $gastoEnergeticoTotal * 0.0000009;

            } else if($paciente->edad < 3){
                //Usamos fórmula de Schofield

                if($paciente->sexo == 'Masculino'){
                    $gastoEnergeticoBasal = (0.0007 * $consulta->peso_actual) + (6.349 * $consulta->altura_actual) - 2.584;
                }else if ($paciente->sexo == 'Femenino'){
                    $gastoEnergeticoBasal = (0.068 * $consulta->peso_actual) + (4.281 * $consulta->altura_actual) - 1.730;
                }

            }else if($paciente->edad >= 3 && $paciente->edad < 10){
                //Usamos fórmula de Schofield

                if($paciente->sexo == 'Masculino'){
                    $gastoEnergeticoBasal = (0.082 * $consulta->peso_actual) + (0.545 * $consulta->altura_actual) - 1.736;

                }else if($paciente->sexo == 'Femenino'){
                    $gastoEnergeticoBasal = (0.071 * $consulta->peso_actual) + (0.677 * $consulta->altura_actual) - 1.553;
                }
            }else if($paciente->edad >= 11 && $paciente->edad <18){
                //Usamos fórmula de Schofield

                if($paciente->sexo == 'Masculino'){
                    $gastoEnergeticoBasal = (0.068 * $consulta->peso_actual) + (0.574 * $consulta->altura_actual) - 2.157;

                }else if($paciente->sexo == 'Femenino'){
                    $gastoEnergeticoBasal = (0.035 * $consulta->peso_actual) + (1.9484 * $consulta->altura_actual) - 0.837;
                }
            }

        }
        return view('nutricionista.gestion-consultas.generar-plan-alimentacion', compact('paciente', 'historiaClinica', 'datosMedicos', 'cirugiasPaciente', 'anamnesisPaciente', 'tratamientoActivo', 'tipoConsulta', 'nutricionista', 'turno', 'consulta', 'imc', 'gastoEnergeticoBasal', 'gastoEnergeticoTotal', 'proteinas', 'grasas', 'carbohidratos', 'calcio', 'fosforo', 'magnesio', 'potasio', 'sodio', 'cloro', 'hierro', 'zinc', 'selenio', 'yodo', 'vitaminaA', 'vitaminaD', 'vitaminaE', 'vitaminaC', 'vitaminaB1', 'vitaminaB2', 'vitaminaB3', 'vitaminaB6', 'vitaminaB9', 'vitaminaB12', 'fibra', 'agua', 'colesterol', 'alcohol', 'cafeina', 'azucar'));
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
        //
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

    //Función para realizar los cálculos necesarios que selecciona en la consulta

    public function realizarCalculos(Request $request){

        // Obtenemos los datos del formulario
        $paciente = Paciente::find($request->input('paciente'));

        // Recopilamos los datos de la solicitud
        $pesoActual = floatval($request->input('peso'));
        $alturaActual = floatval($request->input('altura'));
        $calculosSeleccionados = $request->input('calculosSeleccionado');
        $plieguesSeleccionado = $request->input('plieguesSeleccionado');

        // Realiza los cálculos necesarios aquí

        $imc = 0;
        $pesoIdeal = 0;
        $masaGrasa = 0;
        $masaOsea = 0;
        $masaResidual = 0;
        $masaMuscular = 0;

        //Calculamos el IMC
        if(in_array('imc', $calculosSeleccionados) && $pesoActual && $alturaActual){
            //Primero pasamos la altura de cm a m
            $alturaMetro = $alturaActual / 100;
            $imc = $pesoActual / ($alturaMetro * $alturaMetro);

            //Calculamos el peso ideal

            if($imc < 18.5){
                $pesoIdeal = 18.5 * ($alturaMetro * $alturaMetro); //Bajo peso
            }else if($imc >= 18.5 && $imc <= 25){
                $pesoIdeal = $pesoActual; //Peso normal
            }else if($imc > 25){
                $pesoIdeal = 25 * ($alturaMetro * $alturaMetro); //Sobrepeso
            }else if($imc >= 30 && $imc < 35){
                $pesoIdeal = 30 * ($alturaMetro * $alturaMetro); //Obesidad grado 1
            }else if($imc >= 35 && $imc <= 40){
                $pesoIdeal = 35 * ($alturaMetro * $alturaMetro); //Obesidad grado 2
            }else if($imc > 40){
                $pesoIdeal = 40 * ($alturaMetro * $alturaMetro); //Obesidad grado 3 o mórbida
            }
        }

        //Calculamos masa grasa

        if(in_array('masa_grasa', $calculosSeleccionados)){

            // Calcula la sumatoria de los pliegues cutáneos
            $sumatoriaPliegues = 0;

            //Pliegues a sumar
            $biceps = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Pliegue del Bíceps')->first();
            $triceps = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Pliegue del Tríceps')->first();
            $subescapular = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Pliegue Subescapular')->first();
            $suprailiaco = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Pliegue del Suprailiaco')->first();

            $plieguesASumar = ['pliegue_'.$triceps->id, 'pliegue_'.$biceps->id, 'pliegue_'.$subescapular->id, 'pliegue_'.$suprailiaco->id];

            // Suma los valores de los pliegues cutáneos
            foreach ($plieguesASumar as $nombreCampo) {
                if (array_key_exists($nombreCampo, $plieguesSeleccionado)) {
                    $valorPliegue = floatval($plieguesSeleccionado[$nombreCampo]);
                    $sumatoriaPliegues += $valorPliegue;
                }
            }

            //Ecuación deDurnin & Womersley

            $densidadCorporal = 0;

            //Separamos según sexo y edad
            if($paciente->sexo == 'Masculino'){
                //Hombres entre 17 y 19 años
                if($paciente->edad >= 17 && $paciente->edad <= 19){
                    $densidadCorporal = 1.1620 - (0.0630 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }
                //Hombres entre 20 y 29 años
                if($paciente->edad >= 20 && $paciente->edad <= 29){
                    $densidadCorporal = 1.1631 - (0.0632 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 30 && $paciente->edad <= 39){
                    //Hombres entre 30 y 39 años
                    $densidadCorporal = 1.1422 - (0.0544 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 40 && $paciente->edad <= 49){
                    //Hombres entre 40 y 49 años
                    $densidadCorporal = 1.1620 - (0.0700 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 50 && $paciente->edad <= 72){
                    //Hombres entre 50 y 72 años
                    $densidadCorporal = 1.1715 - (0.0779 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }
            } else if($paciente->sexo == 'Femenino'){
                //Mujeres entre 17 y 19 años
                if($paciente->edad >= 17 && $paciente->edad <= 19){
                    $densidadCorporal = 1.1549 - (0.0678 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }
                //Mujeres entre 20 y 29 años
                if($paciente->edad >= 20 && $paciente->edad <= 29){
                    $densidadCorporal = 1.1599 - (0.0717 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 30 && $paciente->edad <= 39){
                    //Mujeres entre 30 y 39 años
                    $densidadCorporal = 1.1423 - (0.0632 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 40 && $paciente->edad <= 49){
                    //Mujeres entre 40 y 49 años
                    $densidadCorporal = 1.1333 - (0.0612 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }else if($paciente->edad >= 50 && $paciente->edad <= 68){
                    //Mujeres entre 50 y 68 años
                    $densidadCorporal = 1.1339 - (0.0645 * log10($sumatoriaPliegues));
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                }
            }
        }

        //Calculamos masa residual
        $masaResidual = 0;
        if(in_array('masa_residual', $calculosSeleccionados)){
            if($paciente->sexo == 'Masculino'){
                $masaResidual = 0.241 * $pesoActual; //en Kg
            }else if($paciente->sexo == 'Femenino'){
                $masaResidual = 0.209 * $pesoActual; //en Kg
            }
        }


        //Calculamos masa ósea
        //Ecuación de Martin
        if(in_array('masa_osea', $calculosSeleccionados)){
            $sumatoriaDiametros = 0;

            //Diametros a sumar
            $humero = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Diámetro de Húmero')->first();
            $femur = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Diámetro de Fémur')->first();
            $muneca = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Diámetro de Muñeca')->first();
            $tobillo = TiposDePliegueCutaneo::where('nombre_pliegue', '=', 'Diámetro de Tobillo')->first();

            $diametrosASumar = ['pliegue_'.$humero->id, 'pliegue_'.$femur->id, 'pliegue_'.$muneca->id, 'pliegue_'.$tobillo->id];

            // Suma los valores de los pliegues cutáneos
            foreach ($diametrosASumar as $nombreCampo) {
                // Asegúrate de que el nombre del campo comienza con "pliegue_"
                if (array_key_exists($nombreCampo, $plieguesSeleccionado)) {
                    $valorDiametro = floatval($plieguesSeleccionado[$nombreCampo]);
                    $sumatoriaDiametros += $valorDiametro;
                }
            }

            //Masa osea Kg
            $masaOsea = 0.00006*$pesoActual*($sumatoriaDiametros*$sumatoriaDiametros);
        }

        //Calculamos masa muscular
        //Ecuación de De Rose y Guimaraes

        if(in_array('masa_muscular', $calculosSeleccionados)){
            $sumatoriaMasas = ($masaGrasa + $masaOsea + $masaResidual);

            //Masa muscular Kg
            $masaMuscular = $pesoActual - $sumatoriaMasas;
        }

        //Generamos diagnóstico

        $diagnostico = '';

        if(in_array('imc', $calculosSeleccionados)){
            $diagnostico .= "IMC: $imc, ";
        }


        if (in_array('masa_grasa', $calculosSeleccionados)) {
            $diagnostico .= "Masa Grasa: $masaGrasa%, ";
        }

        if (in_array('masa_osea', $calculosSeleccionados)) {
            $diagnostico .= "Masa Ósea: $masaOsea Kg, ";
        }

        if (in_array('masa_residual', $calculosSeleccionados)) {
            $diagnostico .= "Masa Residual: $masaResidual Kg, ";
        }

        if (in_array('masa_muscular', $calculosSeleccionados)) {
            $diagnostico .= "Masa Muscular: $masaMuscular Kg, ";
        }

        // Quita la coma y el espacio extra al final del diagnóstico
        $diagnostico = rtrim($diagnostico, ', ');

        return response()->json([
            'diagnostico' => $diagnostico,
            'imc' => $imc,
            'pesoIdeal' => $pesoIdeal,
            'masaGrasa' => $masaGrasa,
            'masaOsea' => $masaOsea,
            'masaResidual' => $masaResidual,
            'masaMuscular' => $masaMuscular,
        ]);

    }

}
