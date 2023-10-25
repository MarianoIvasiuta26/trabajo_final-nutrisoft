<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Consulta;
use App\Models\DetallePlanAlimentaciones;
use App\Models\MedicionesDePlieguesCutaneos;
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
use App\Models\GrupoAlimento;
use App\Models\Nutriente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use App\Models\PlanAlimentaciones;
use App\Models\ValorNutricional;
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
     *
     */

     //@return \Illuminate\Http\Response
    public function store(Request $request, $id)
    {
        //dd($request->input('imc'), $request->input('masa_grasa'), $request->input('masa_osea'), $request->input('masa_residual'), $request->input('masa_muscular'));
        //dd($request->input('diagnostico'), $request->input('peso_actual'), $request->input('observacion'), $request->input('altura_actual'));
        //dd($request->all());
        //Validamos el form
        $request->validate([
            'tratamiento_paciente' => ['required', 'integer'],
            'observacion' => ['required', 'string', 'max:255'],
            'peso_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'altura_actual' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_munieca_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_cintura_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_cadera_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circ_pecho_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'diagnostico' => ['required', 'string', 'max:255'],
            'imc_actual' => ['required', 'numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_grasa_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'] ,
            'masa_osea_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_residual_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_muscular_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
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

        $imcActual = $request->input('imc_actual');
        $masaGrasaActual = $request->input('masa_grasa_actual');
        $masaOseaActual = $request->input('masa_osea_actual');
        $masaResidualActual = $request->input('masa_residual_actual');
        $masaMuscularActual = $request->input('masa_muscular_actual');

        $pacienteId = $request->input('paciente_id');
        $historiaClinica = HistoriaClinica::where('paciente_id', $pacienteId)->first();

        //Buscamos el turno
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

        if($imcActual != 0){
            $consulta->imc_Actual = $imcActual;
            $consulta->save();
        }

        if($masaGrasaActual != 0 && $masaOseaActual != 0 && $masaResidualActual != 0 && $masaMuscularActual != 0){
            $consulta->masa_grasa_actual = $masaGrasaActual;
            $consulta->masa_osea_actual = $masaOseaActual;
            $consulta->masa_residual_actual = $masaResidualActual;
            $consulta->masa_muscular_actual = $masaMuscularActual;
            $consulta->save();
        }else{
            $consulta->masa_grasa_actual = 0.00;
            $consulta->masa_osea_actual = 0.00;
            $consulta->masa_residual_actual = 0.00;
            $consulta->masa_muscular_actual = 0.00;
            $consulta->save();
        }

        $consulta->masa_grasa_actual = (!$masaGrasaActual) ? 0.00 : $masaGrasaActual;
        $consulta->masa_osea_actual = (!$masaOseaActual) ? 0.00 : $masaOseaActual;
        $consulta->masa_residual_actual = (!$masaResidualActual) ? 0.00 : $masaResidualActual;
        $consulta->masa_muscular_actual = (!$masaMuscularActual) ? 0.00 : $masaMuscularActual;
        $consulta->save();


        TratamientoPorPaciente::create([
            'tratamiento_id' => $tratamientoPaciente,
            'paciente_id' => $turno->paciente_id,
            'fecha_alta' => $turno->fecha,
            'observaciones' => $observacion,
            'estado' => 'Activo',
        ]);

        //Obtenemos los pliegues y medidas de pliegues
        $pliegues = TiposDePliegueCutaneo::all();

        foreach($pliegues as $pliegue){
            $campo = 'pliegue_'.$pliegue->id;
            $valor = $request->input($campo);
            if(!$valor){
                $valor = 0.00;
            }
            MedicionesDePlieguesCutaneos::create([
                'historia_clinica_id' => $historiaClinica->id,
                'consulta_id' => $consulta->id,
                'tipos_de_pliegue_cutaneo_id' => $pliegue->id,
                'valor_medicion' => $valor,
            ]);

        }

        $turno->estado = 'Realizado';
        $turno->save();

        //Obtener paciente de la consulta
        $paciente = Paciente::find($turno->paciente_id);

        if( $turno->estado == 'Realizado' && $request->has('generar-plan-alimentacion')){
            $planGenerado = $this->generarPlanesAlimentacion($paciente->id, $turno->id);
        }

        if($planGenerado){
            return redirect()->route('gestion-turnos-nutricionista.index')
            ->with('success', 'Consulta realizada con éxito. Se generó el plan de alimentación')
            ->with('pacienteId', $pacienteId)
            ->with('turnoId', $turno->id)
            ->with('nutricionistaId', $nutricionista->id);

        }else{
            return back()->with('error', 'No se pudo generar el plan');
        }

    }

    //Función para el 2do proceso automatizado: Generación automática de Plan de alimentación
    public function generarPlanesAlimentacion($id, $turnoId){
        //Buscamos el paciente
        $paciente = Paciente::find($id);

        //Buscamos historia clínica del paciente
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Obtenemos el tratamiento activo del paciente
        $tratamientoActivo = TratamientoPorPaciente::where('paciente_id', $paciente->id)->where('estado', 'Activo')->first();

        //Obtenemos el tipo de consulta
        $tipoConsulta = TipoConsulta::where('tipo_consulta', 'Primera consulta')->first();

        //Obtenemos el nutricionista
        $nutricionista = Nutricionista::where('user_id', auth()->user()->id)->first();

        /* Ver si usar estos o no */

        //Obtenemos el turno
        $turno = Turno::find($turnoId);

        //Obtenemos la consulta
        $consulta = Consulta::where('turno_id', $turno->id)->first();

        //Comenzamos a implementar la lógica para generar el plan

        //Primero debemos calcular el IMC del paciente para saber si está normal o no
        //$imc = $consulta->peso_actual / ($consulta->altura_actual * $consulta->altura_actual);
        $imc = $consulta->imc_actual;

        //Altura en metros
        $alturaMetro = $consulta->altura_actual / 100;
        $gastoEnergeticoBasal = 0;

        //Si el IMC es menor a 18.5, el paciente está bajo de peso
        //Dieta HIPERCALÓRICA
        if($imc < 18.50){
            //Bajo peso
            if($imc < 16){
                //Delgadez severa
            }else if($imc >= 16 && $imc <= 16.99){
                //Delgadez moderada
            }else if($imc >= 17 && $imc <= 18.49){
                //Delgadez aceptable
            }
        }

        //Si el IMC está entre 18.5 y 24.99, el paciente está normal
        //IMC normal -> Dieta NORMOCALÓRICA
        if($imc >= 18.5 && $imc <= 24.99){
            //Usamos la fórmula de Mifflin St. Jeor (No recomendable en pacientes menores de 18 años) para calcular el gasto energético basal

            if($paciente->edad > 18){
                if($paciente->sexo == 'Masculino'){
                    $gastoEnergeticoBasal = (10 * $consulta->peso_actual) + (6.25 * $consulta->altura_actual) - (5 * $paciente->edad) + 5;
                }else{
                    $gastoEnergeticoBasal = (10 * $consulta->peso_actual) + (6.25 * $consulta->altura_actual) - (5 * $paciente->edad) - 161;
                }
            }else if($paciente->edad < 18){
                if($paciente->edad < 3){
                    //Usamos fórmula de Schofield

                    if($paciente->sexo == 'Masculino'){
                        $gastoEnergeticoBasalMj = (0.0007 * $consulta->peso_actual) + (6.349 * $alturaMetro) - 2.584; //en Mj

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                    }else if ($paciente->sexo == 'Femenino'){
                        $gastoEnergeticoBasalMj = (0.068 * $consulta->peso_actual) + (4.281 * $alturaMetro) - 1.730;

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal
                    }
                }else if($paciente->edad >= 3 && $paciente->edad < 10){
                    //Usamos fórmula de Schofield

                    if($paciente->sexo == 'Masculino'){
                        $gastoEnergeticoBasalMj = (0.082 * $consulta->peso_actual) + (0.545 * $alturaMetro) - 1.736;

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                    }else if($paciente->sexo == 'Femenino'){
                        $gastoEnergeticoBasalMj = (0.071 * $consulta->peso_actual) + (0.677 * $alturaMetro) - 1.553;

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal
                    }
                }else if($paciente->edad >= 11 && $paciente->edad <18){
                    //Usamos fórmula de Schofield

                    if($paciente->sexo == 'Masculino'){
                        $gastoEnergeticoBasalMj = (0.068 * $consulta->peso_actual) + (0.574 * $alturaMetro) - 2.157;

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                    }else if($paciente->sexo == 'Femenino'){
                        $gastoEnergeticoBasalMj= (0.035 * $consulta->peso_actual) + (1.9484 * $alturaMetro) - 0.837;

                        //Pasamos de Mj a kj
                        $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                        //Pasamos de kj a kcal
                        $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal
                    }
                }
            }

        }

        //Si el IMC es mayor a 25, el paciente tiene sobrepeso
        //Dieta HIPOCALÓRICA
        if($imc >= 25){
            //Sobrepeso
            if($imc >= 25 && $imc <= 29.99){
                //Preobesidad
            }else if($imc >= 30 && $imc <= 34.99){
                //Obesidad grado 1
            }else if($imc >= 35 && $imc <= 39.99){
                //Obesidad grado 2
            }else if($imc >= 40){
                //Obesidad grado 3 o mórbida
            }
        }

        //Calculamos el gasto energético total
        $resultadoGET = $this->determinacionGET($gastoEnergeticoBasal, $historiaClinica->estilo_vida);

        $gastoEnergeticoTotal = $resultadoGET['get'];

        //Verificamos cual es el objetivo de salud del paciente
        if($historiaClinica->objetivo_salud == 'Adelgazar'){
            $gastoEnergeticoTotal = $gastoEnergeticoTotal - 500;
        } else if ($historiaClinica->objetivo_salud == 'Ganar masa muscular'){
            $gastoEnergeticoTotal = $gastoEnergeticoTotal + 500;
        } else if ($historiaClinica->objetivo_salud == 'Mantener peso'){
            $gastoEnergeticoTotal = $gastoEnergeticoTotal;
        }

        //Determinación de gramos de proteínas, carbohidratos y lípidos (Adultos)
        $resultadoNutriente = $this->determinacionNutrientes($gastoEnergeticoTotal, $paciente->edad);

        $carbohidratosRecomendados = $resultadoNutriente['carbohidratos'];
        $lipidosRecomendados = $resultadoNutriente['lipidos'];
        $proteinasRecomendadas = $resultadoNutriente['proteinas'];

        //Evaluamos el porcentaje necesario por grupo de alimentos (Según Guia Argentina)
        $resultadoEleccionAlimentos = $this->porcentajeAlimentos($gastoEnergeticoTotal);

        $porcentajeFrutasVerduras = $resultadoEleccionAlimentos['porcentajeFrutasVerduras'];
        $porcentajeLegumbresCereales = $resultadoEleccionAlimentos['porcentajeLegumbresCereales'];
        $porcentajeLecheYogurQueso = $resultadoEleccionAlimentos['porcentajeLecheYogurQueso'];
        $porcentajeCarnesHuevo = $resultadoEleccionAlimentos['porcentajeCarnesHuevo'];
        $porcentajeAceitesFrutasSecasSemillas = $resultadoEleccionAlimentos['porcentajeAceitesFrutasSecasSemillas'];
        $porcentajeAzucarDulcesGolosinas = $resultadoEleccionAlimentos['porcentajeAzucarDulcesGolosinas'];

        //Selección de alimentos
        $alimentosPaciente = $this->eleccionAlimentos($historiaClinica->id, $porcentajeFrutasVerduras, $porcentajeLegumbresCereales, $porcentajeLecheYogurQueso, $porcentajeCarnesHuevo, $porcentajeAceitesFrutasSecasSemillas, $porcentajeAzucarDulcesGolosinas, $carbohidratosRecomendados, $lipidosRecomendados, $proteinasRecomendadas);

        //Obtenemos los alimentos recomendados
        $alimentosRecomendadosFrutas = $alimentosPaciente['alimentosFrutas'];
        $alimentosRecomendadosVerduras = $alimentosPaciente['alimentosVerduras'];
        $alimentosRecomendadosLegumbres = $alimentosPaciente['alimentosLegumbres'];
        $alimentosRecomendadosLeche = $alimentosPaciente['alimentosLeche'];
        $alimentosRecomendadosYogur = $alimentosPaciente['alimentosYogur'];
        $alimentosRecomendadosQueso = $alimentosPaciente['alimentosQueso'];
        $alimentosRecomendadosCarnes = $alimentosPaciente['alimentosCarnes'];
        $alimentosRecomendadosHuevos = $alimentosPaciente['alimentosHuevos'];
        $alimentosRecomendadosPescados = $alimentosPaciente['alimentosPescados'];
        $alimentosRecomendadosAceites = $alimentosPaciente['alimentosAceites'];
        $alimentosRecomendadosFrutasSecas = $alimentosPaciente['alimentosFrutasSecas'];
        $alimentosRecomendadosAzucar = $alimentosPaciente['alimentosAzucar'];
        $alimentosRecomendadosGolosinas = $alimentosPaciente['alimentosGolosinas'];

        //dd($alimentosRecomendadosFrutas, $alimentosRecomendadosVerduras, $alimentosRecomendadosLegumbres, $alimentosRecomendadosLeche, $alimentosRecomendadosYogur, $alimentosRecomendadosQueso, $alimentosRecomendadosCarnes, $alimentosRecomendadosHuevos, $alimentosRecomendadosPescados, $alimentosRecomendadosAceites, $alimentosRecomendadosFrutasSecas, $alimentosRecomendadosAzucar, $alimentosRecomendadosGolosinas);

        //Crea un array con todos estos alimentos
        $alimentosRecomendados = array_merge(
            $alimentosRecomendadosFrutas,
            $alimentosRecomendadosVerduras,
            $alimentosRecomendadosLegumbres,
            $alimentosRecomendadosLeche,
            $alimentosRecomendadosYogur,
            $alimentosRecomendadosQueso,
            $alimentosRecomendadosCarnes,
            $alimentosRecomendadosHuevos,
            $alimentosRecomendadosPescados,
            $alimentosRecomendadosAceites,
            $alimentosRecomendadosFrutasSecas,
            $alimentosRecomendadosAzucar,
            $alimentosRecomendadosGolosinas
        );

        //dd($imc, $consulta->peso_actual, $consulta->altura_actual, $paciente->edad, $gastoEnergeticoTotal, $gastoEnergeticoBasal, $alimentosRecomendados, $carbohidratosRecomendados, $lipidosRecomendados, $proteinasRecomendadas,  $porcentajeFrutasVerduras, $porcentajeLegumbresCereales, $porcentajeLecheYogurQueso, $porcentajeCarnesHuevo, $porcentajeAceitesFrutasSecasSemillas, $porcentajeAzucarDulcesGolosinas);

        $alimentos = Alimento::All();

        // Crea un nuevo plan de alimentación
        $planAlimentacion = PlanAlimentaciones::create([
            'consulta_id' => $consulta->id, // Asocia el plan a la consulta
            'paciente_id' => $paciente->id, // Asocia el plan al paciente
            'descripcion' => 'Descripción del plan', // Añade una descripción
            'estado' => 1, // Establece el estado según tus necesidades
        ]);

        $planAlimentacion->save(); // Guarda el nuevo plan de alimentación
        //dd($consulta, $planAlimentacion);

        // Asocia los detalles del plan de alimentación al plan recién creado
        foreach ($alimentosRecomendados as $alimento) {
            foreach ($alimentos as $alim) {
                if ($alim->alimento == $alimento) {
                    $detallePlan = DetallePlanAlimentaciones::create([
                        'plan_alimentacion_id' => $planAlimentacion->id, // Asocia el plan al detalle del plan
                        'alimento_id' => $alim->id, // Asocia el alimento al detalle del plan
                        'horario_consumicion' => 'Horario', // Establece el horario según tus necesidades
                        'cantidad' => 100, // Establece la cantidad según tus necesidades
                        'unidad_medida' => 'gramos', // Establece la unidad de medida según tus necesidades
                        'observacion' => 'Observación', // Añade una observación según tus necesidades
                    ]);

                    $detallePlan->save(); // Guarda el detalle del plan
                }
            }
        }

/*
        return view('plan-alimentacion.index',
        compact(
            'paciente', 'historiaClinica', 'datosMedicos', 'cirugiasPaciente', 'anamnesisPaciente',
            'tratamientoActivo', 'tipoConsulta', 'nutricionista', 'turno', 'consulta', 'imc',
            'gastoEnergeticoBasal', 'gastoEnergeticoTotal', 'proteinasRecomendadas', 'lipidosRecomendados',
            'carbohidratosRecomendados', 'alimentosRecomendadosFrutas', 'alimentosRecomendadosVerduras',
            'alimentosRecomendadosLegumbres', 'alimentosRecomendadosLeche', 'alimentosRecomendadosYogur',
            'alimentosRecomendadosQueso', 'alimentosRecomendadosCarnes', 'alimentosRecomendadosHuevos',
            'alimentosRecomendadosPescados', 'alimentosRecomendadosAceites', 'alimentosRecomendadosFrutasSecas',
            'alimentosRecomendadosAzucar', 'alimentosRecomendadosGolosinas'
        ));
*/
        return [
            'paciente' => $paciente,
            'historiaClinica' => $historiaClinica,
            'tratamientoActivo' => $tratamientoActivo,
            'tipoConsulta' => $tipoConsulta,
            'nutricionista' => $nutricionista,
            'imc' => $imc,
            'gastoEnergeticoBasal' => $gastoEnergeticoBasal,
            'gastoEnergeticoTotal' => $gastoEnergeticoTotal,
            'proteinasRecomendadas' => $proteinasRecomendadas,
            'lipidosRecomendados' => $lipidosRecomendados,
            'carbohidratosRecomendados' => $carbohidratosRecomendados,
            'alimentosRecomendadosFrutas' => $alimentosRecomendadosFrutas,
            'alimentosRecomendadosVerduras' => $alimentosRecomendadosVerduras,
            'alimentosRecomendadosLegumbres' => $alimentosRecomendadosLegumbres,
            'alimentosRecomendadosLeche' => $alimentosRecomendadosLeche,
            'alimentosRecomendadosYogur' => $alimentosRecomendadosYogur,
            'alimentosRecomendadosQueso' => $alimentosRecomendadosQueso,
            'alimentosRecomendadosCarnes' => $alimentosRecomendadosCarnes,
            'alimentosRecomendadosHuevos' => $alimentosRecomendadosHuevos,
            'alimentosRecomendadosPescados' => $alimentosRecomendadosPescados,
            'alimentosRecomendadosAceites' => $alimentosRecomendadosAceites,
            'alimentosRecomendadosFrutasSecas' => $alimentosRecomendadosFrutasSecas,
            'alimentosRecomendadosAzucar' => $alimentosRecomendadosAzucar,
            'alimentosRecomendadosGolosinas' => $alimentosRecomendadosGolosinas,
        ];

    }

    public function determinacionGET($geb, $estilo_vida){
        if($estilo_vida == 'Sedentario'){
            $gastoEnergeticoTotal = $geb * 1.2;
        } else if ($estilo_vida == 'Ligeramente activo'){
            $gastoEnergeticoTotal = $geb * 1.375;
        } else if ($estilo_vida == 'Moderadamente activo'){
            $gastoEnergeticoTotal = $geb * 1.55;
        } else if ($estilo_vida == 'Muy activo'){
            $gastoEnergeticoTotal = $geb * 1.725;
        } else if ($estilo_vida == 'Extra activo'){
            $gastoEnergeticoTotal = $geb * 1.9;
        }

        return [
            'get' => $gastoEnergeticoTotal
        ];
    }

    public function determinacionNutrientes($get, $edad){

        $carbohidratosRecomendados = 0;
        $lipidosRecomendados = 0;
        $proteinasRecomendadas = 0;

        //ESTABLECER SEGÚN EL TIPO DE DIETA QUE NECESITA

        if($edad <= 10){
            //Determinación de gramos de proteínas, carbohidratos y lípidos (Niños)
            $carbohidratosRecomendados = ($get * 0.55) / 4;//Gramos
            $lipidosRecomendados = ($get * 0.30) / 9;//Gramos
            $proteinasRecomendadas = ($get * 0.15) / 4;//Gramos
        }

        if($edad >= 11 && $edad <18){
            //Determinación de gramos de proteínas, carbohidratos y lípidos (Adolescentes)
            $carbohidratosRecomendados = ($get * 0.6) / 4; //Gramos
            $lipidosRecomendados = ($get * 0.25) / 9;//Gramos
            $proteinasRecomendadas = ($get * 0.15) / 4;//Gramos
        }

        if($edad >= 18){
            //Determinación de gramos de proteínas, carbohidratos y lípidos (Adultos)
            $carbohidratosRecomendados = ($get * 0.6) / 4; //Gramos
            $lipidosRecomendados = ($get * 0.28) / 9; //Gramos
            $proteinasRecomendadas = ($get * 0.12) / 4; //Gramos
        }

        return [
            'carbohidratos' => $carbohidratosRecomendados,
            'lipidos' => $lipidosRecomendados,
            'proteinas' => $proteinasRecomendadas
        ];

    }

    public function porcentajeAlimentos($get){
        //Función para determinar los alimentos que debe consumir el paciente según grupos de alimentos.
        /* Tenemos en cuenta:
            40% Cereales y derivados.
            30% Frutas y verduras.
            20% Legunmbres y alimentos de origen animal
            8% Grasas y aceites.
            2% Azúcares refinados

            Argentina:
            50% Verduras y frutas
            25% Legumbres, cereales, papa, pan y pastas.
            10% Leche, yogur y queso.
            5% Carnes, huevo.
            5% Aceites, frutas secas y semillas
            5% Azúcar, dulces y golosinas (OPCIONAL).
        */

        //Resultados en Kcal/día
        $frutasVerduras = ($get * 0.5);
        $legumbresCereales = ($get * 0.25);
        $lecheYogurQueso = ($get * 0.1);
        $carnesHuevo = ($get * 0.05);
        $aceitesFrutasSecasSemillas = ($get * 0.05);
        $azucarDulcesGolosinas = ($get * 0.05);



        return [
            'porcentajeFrutasVerduras' => $frutasVerduras,
            'porcentajeLegumbresCereales' => $legumbresCereales,
            'porcentajeLecheYogurQueso' => $lecheYogurQueso,
            'porcentajeCarnesHuevo' => $carnesHuevo,
            'porcentajeAceitesFrutasSecasSemillas' => $aceitesFrutasSecasSemillas,
            'porcentajeAzucarDulcesGolosinas' => $azucarDulcesGolosinas,
        ];
    }

    public function eleccionAlimentos($historiaClinicaId, $porcentajeFrutasVerduras, $porcentajeLegumbresCereales, $porcentajeLecheYogurQueso, $porcentajeCarnesHuevo, $porcentajeAceitesFrutasSecasSemillas, $porcentajeAzucarDulcesGolosinas,  $carbohidratosRecomendados, $lipidosRecomendados, $proteinasRecomendadas){

        //Obtenemos los grupos de alimentos
        //50%
        $grupoAlimentoFruta = GrupoAlimento::where('grupo', 'Frutas')->first();
        $grupoAlimentoVerdura = GrupoAlimento::where('grupo', 'Verduras')->first();
        //25%
        $grupoAlimentoLegumbres = GrupoAlimento::where('grupo', 'Legumbres, cereales, papa, choclo, batata, pan y pastas')->first();
        //10%
        $grupoAlimentoLeche = GrupoAlimento::where('grupo', 'Leche y postres de leche')->first();
        $grupoAlimentoYogur = GrupoAlimento::where('grupo', 'Yogures')->first();
        $grupoAlimentoQueso = GrupoAlimento::where('grupo', 'Quesos')->first();
        //5%
        $grupoAlimentoCarnes = GrupoAlimento::where('grupo', 'Carnes')->first();
        $grupoAlimentoHuevos = GrupoAlimento::where('grupo', 'Huevos')->first();
        $grupoAlimentoPescados = GrupoAlimento::where('grupo', 'Pescados y mariscos')->first();
        //5%
        $grupoAlimentoAceites = GrupoAlimento::where('grupo', 'Aceites')->first();
        $grupoAlimentoFrutasSecas = GrupoAlimento::where('grupo', 'Frutas secas y semillas')->first();
        //5%
        $grupoAlimentoAzucar = GrupoAlimento::where('grupo', 'Azúcares, mermeladas y dulces')->first();
        $grupoGolosinas = GrupoAlimento::where('grupo', 'Golosinas y chocolates')->first();

        //Obtenemos los alimentos de cada grupo
        //50%
        $alimentosFruta = Alimento::where('grupo_alimento_id', $grupoAlimentoFruta->id)->get();
        $alimentosVerdura = Alimento::where('grupo_alimento_id', $grupoAlimentoVerdura->id)->get();
        //25%
        $alimentosLegumbres = Alimento::where('grupo_alimento_id', $grupoAlimentoLegumbres->id)->get();
        //10%
        $alimentosLeche = Alimento::where('grupo_alimento_id', $grupoAlimentoLeche->id)->get();
        $alimentosYogur = Alimento::where('grupo_alimento_id', $grupoAlimentoYogur->id)->get();
        $alimentosQueso = Alimento::where('grupo_alimento_id', $grupoAlimentoQueso->id)->get();
        //5%
        $alimentosCarnes = Alimento::where('grupo_alimento_id', $grupoAlimentoCarnes->id)->get();
        $alimentosHuevos = Alimento::where('grupo_alimento_id', $grupoAlimentoHuevos->id)->get();
        $alimentosPescados = Alimento::where('grupo_alimento_id', $grupoAlimentoPescados->id)->get();
        //5%
        $alimentosAceites = Alimento::where('grupo_alimento_id', $grupoAlimentoAceites->id)->get();
        $alimentosFrutasSecas = Alimento::where('grupo_alimento_id', $grupoAlimentoFrutasSecas->id)->get();
        //5%
        $alimentosAzucar = Alimento::where('grupo_alimento_id', $grupoAlimentoAzucar->id)->get();
        $alimentosGolosinas = Alimento::where('grupo_alimento_id', $grupoGolosinas->id)->get();

        //dd('Alimentos:', $alimentosVerdura);

        //Buscamos la historia Clinica
        $historiaClinica = HistoriaClinica::find($historiaClinicaId);
        $paciente = Paciente::wherE('id', $historiaClinica->paciente_id)->first();
        //Buscamos datos médicos del paciente
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinicaId)->get();
        //Cirugías del paciente
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinicaId)->get();
        //Anamnesis alimentaria del paciente
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinicaId)->get();
        //ValoresNutricionales y nutrientes
        $nutrientesKcal = Nutriente::where('nombre_nutriente', 'Valor energético')->first();
        $ValoresNutricionales = ValorNutricional::all();
        $nutrientes = Nutriente::all();

        //Obtenemos datos necesarios
        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();
        $cirugias = Cirugia::all();

        //Obtenemos los alimentos que debe consumir el paciente según su porcentaje
        //Tenemos en cuenta los datos médicos (Si tiene o no patologías, alergias etc.). Si tiene, se le recomienda alimentos que no le hagan mal.
        //También comprobamos la anamnesis alimentatia para saber sus preferencias alimenticias. Si no le gusta un alimento, se le recomienda otro.

        //Frutas y verduras -> 50%
        $alimentosRecomendadosFrutas = [];
        $alimentosRecomendadosVerduras = [];
        $caloriasTotalesFrutas = $porcentajeFrutasVerduras / 2; //en kcal
        $caloriasTotalesVerduras = $porcentajeFrutasVerduras / 2; //kcal

        //Porcentajes por comida
        $porcentajeDesayuno = 0.25;
        $porcentajeMediaManiana = 0.1;
        $porcentajeAlmuerzo = 0.35;
        $porcentajeMediaTarde = 0.1;
        $porcentajeCena = 0.20;

        //Macronutrientes por comida en gramos
        $carbohidratosDesayuno = $carbohidratosRecomendados * $porcentajeDesayuno; //Total de gramos de carbohidratos para el desayuno
        $lipidosDesayuno = $lipidosRecomendados * $porcentajeDesayuno; //Total de gramos de lípidos para el desayuno
        $proteinasDesayuno = $proteinasRecomendadas * $porcentajeDesayuno;  //Total de gramos de proteínas para el desayuno
        $carbohidratosMediaManiana = $carbohidratosRecomendados * $porcentajeMediaManiana; //Total de gramos de carbohidratos para la media mañana
        $lipidosMediaManiana = $lipidosRecomendados * $porcentajeMediaManiana; //Total de gramos de lípidos para la media mañana
        $proteinasMediaManiana = $proteinasRecomendadas * $porcentajeMediaManiana; //Total de gramos de proteínas para la media mañana
        $carbohidratosAlmuerzo = $carbohidratosRecomendados * $porcentajeAlmuerzo; //Total de gramos de carbohidratos para el almuerzo
        $lipidosAlmuerzo = $lipidosRecomendados * $porcentajeAlmuerzo; //Total de gramos de lípidos para el almuerzo
        $proteinasAlmuerzo = $proteinasRecomendadas * $porcentajeAlmuerzo; //Total de gramos de proteinas para el almuerzo
        $carbohidratosMediaTarde = $carbohidratosRecomendados * $porcentajeMediaTarde; //Total de gramos de carbohidratos para la media tarde
        $lipidosMediaTarde = $lipidosRecomendados * $porcentajeMediaTarde; //Total de gramos de lípidos para la media tarde
        $proteinasMediaTarde = $proteinasRecomendadas * $porcentajeMediaTarde; //Total de gramos de proteínas para la media tarde
        $carbohidratosCena = $carbohidratosRecomendados * $porcentajeCena; //Total de gramos de carbohidratos para la cena
        $lipidosCena = $lipidosRecomendados * $porcentajeCena; //Total de gramos de lípidos para la cena
        $proteinasCena = $proteinasRecomendadas * $porcentajeCena;  //Total de gramos de proteínas para la cena


        //Frutas por comida y por macronutriente
        $carbohidratoFrutasDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en desayuno
        $lipidoFrutasDesayuno = (($lipidosDesayuno * 9) * ($caloriasTotalesFrutas/3))/9; //Gramos totales de frutas en desayuno
        $proteinaFrutasDesayuno = (($proteinasDesayuno * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en desayuno

        $carbohidratoFrutasMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en media mañana
        $lipidoFrutasMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasTotalesFrutas/3))/9; //Gramos totales de frutas en media mañana
        $proteinaFrutasMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en media mañana

        $carbohidratoFrutasMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en media tarde
        $lipidoFrutasMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasTotalesFrutas/3))/9; //Gramos totales de frutas en media tarde
        $proteinaFrutasMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasTotalesFrutas/3))/4; //Gramos totales de frutas en media tarde

        //Verduras por comida y por macronutriente
        $carbohidratoVerdurasAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasTotalesVerduras/2))/4; //Gramos totales de verduras en almuerzo
        $lipidoVerdurasAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasTotalesVerduras/2))/9; //Gramos totales de verduras en almuerzo
        $proteinaVerdurasAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasTotalesVerduras/2))/4; //Gramos totales de verduras en almuerzo

        $carbohidratoVerdurasCena = (($carbohidratosCena * 4) * ($caloriasTotalesVerduras/2))/4; //Gramos totales de verduras en cena
        $lipidoVerdurasCena = (($lipidosCena * 9) * ($caloriasTotalesVerduras/2))/9; //Gramos totales de verduras en cena
        $proteinaVerdurasCena = (($proteinasCena * 4) * ($caloriasTotalesVerduras/2))/4; //Gramos totales de verduras en cena

        $desayuno = [];

        foreach($alimentosFruta as $fruta){
            foreach($ValoresNutricionales as $valorN){
                foreach($nutrientes as $nutriente){
                    if($fruta->id == $valorN->alimenot_id && $valorN->nutriente_id == $nutriente->id && $nutriente->nombre_nutriente == 'Valor energético'){

                    }
                }
                if($fruta->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $carbohidratoFrutasDesayuno){
                    if($carbohidratoFrutasDesayuno > 0){
                        $alimentosRecomendadosFrutasDesayuno[] = $fruta->alimento;
                        $carbohidratoFrutasDesayuno = $carbohidratoFrutasDesayuno - $valorN->valor;
                    }
                }
            }
        }


        //Evaluación de alimentos por 100 gramos
        foreach($alimentosFruta as $fruta){
            foreach($ValoresNutricionales as $valorN){
                if($fruta->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $caloriasTotalesFrutas){
                    if($caloriasTotalesFrutas > 0){
                        $alimentosRecomendadosFrutas[] = $fruta->alimento;
                        $caloriasTotalesFrutas = $caloriasTotalesFrutas - $valorN->valor;
                    }
                }
            }

        }

        foreach($alimentosVerdura as $verdura){
            foreach($ValoresNutricionales as $valorN){
                if($verdura->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $caloriasTotalesVerduras){
                    if($caloriasTotalesVerduras > 0){
                        $alimentosRecomendadosVerduras[] = $verdura->alimento;
                        $caloriasTotalesVerduras = $caloriasTotalesVerduras - $valorN->valor;
                    }
                }
            }
        }

        //Legumbres -> 25%
        $alimentosRecomendadosLegumbres = [];
            foreach($ValoresNutricionales as $valorN){
                foreach($alimentosLegumbres as $legumbre){
                    if($legumbre->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeLegumbresCereales){
                        if($porcentajeLegumbresCereales > 0){
                            $alimentosRecomendadosLegumbres[] = $legumbre->alimento;
                            $porcentajeLegumbresCereales = $porcentajeLegumbresCereales - $valorN->valor;
                        }
                    }
                }
        }

        //Leche, yogur y queso -> 10%
        $alimentosRecomendadosLeche = [];
        $alimentosRecomendadosYogur = [];
        $alimentosRecomendadosQueso = [];

        $porcentajeLeche = $porcentajeLecheYogurQueso / 3;
        $porcentajeYogur = $porcentajeLecheYogurQueso / 3;
        $porcentajeQueso = $porcentajeLecheYogurQueso / 3;

        foreach($alimentosLeche as $leche){
            foreach($ValoresNutricionales as $valorN){
                if($leche->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeLeche){
                    if($porcentajeLeche > 0){
                        $alimentosRecomendadosLeche[] = $leche->alimento;
                        $porcentajeLeche = $porcentajeLeche - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosYogur as $yogur){
            foreach($ValoresNutricionales as $valorN){
                if($yogur->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeYogur){
                    if($porcentajeYogur > 0){
                        $alimentosRecomendadosYogur[] = $yogur->alimento;
                        $porcentajeYogur = $porcentajeYogur - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosQueso as $queso){
            foreach($ValoresNutricionales as $valorN){
                if($queso->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeQueso){
                    if($porcentajeQueso > 0){
                        $alimentosRecomendadosQueso[] = $queso->alimento;
                        $porcentajeQueso = $porcentajeQueso - $valorN->valor;
                    }
                }
            }
        }

        //Carnes, huevo y pescados y mariscos -> 5%
        $alimentosRecomendadosCarnes = [];
        $alimentosRecomendadosHuevos = [];
        $alimentosRecomendadosPescados = [];

        $porcentajeCarnes = $porcentajeCarnesHuevo / 3;
        $porcentajeHuevos = $porcentajeCarnesHuevo / 3;
        $porcentajePescados = $porcentajeCarnesHuevo / 3;

        foreach($alimentosCarnes as $carne){
            foreach($ValoresNutricionales as $valorN){
                if($carne->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeCarnes){
                    if($porcentajeCarnes > 0){
                        $alimentosRecomendadosCarnes[] = $carne->alimento;
                        $porcentajeCarnes = $porcentajeCarnes - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosHuevos as $huevo){
            foreach($ValoresNutricionales as $valorN){
                if($huevo->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeHuevos){
                    if($porcentajeHuevos > 0){
                        $alimentosRecomendadosHuevos[] = $huevo->alimento;
                        $porcentajeHuevos = $porcentajeHuevos - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosPescados as $pescado){
            foreach($ValoresNutricionales as $valorN){
                if($pescado->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajePescados){
                    if($porcentajePescados > 0){
                        $alimentosRecomendadosPescados[] = $pescado->alimento;
                        $porcentajePescados = $porcentajePescados - $valorN->valor;
                    }
                }
            }
        }

        //Aceites y frutas secas -> 5%

        $alimentosRecomendadosAceites = [];
        $alimentosRecomendadosFrutasSecas = [];

        $porcentajeAceites = $porcentajeAceitesFrutasSecasSemillas / 2;
        $porcentajeFrutasSecas = $porcentajeAceitesFrutasSecasSemillas / 2;

        foreach($alimentosAceites as $aceite){
            foreach($ValoresNutricionales as $valorN){
                if($aceite->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeAceites){
                    if($porcentajeAceites > 0){
                        $alimentosRecomendadosAceites[] = $aceite->alimento;
                        $porcentajeAceites = $porcentajeAceites - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosFrutasSecas as $frutaSeca){
            foreach($ValoresNutricionales as $valorN){
                if($frutaSeca->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeFrutasSecas){
                    if($porcentajeFrutasSecas > 0){
                        $alimentosRecomendadosFrutasSecas[] = $frutaSeca->alimento;
                        $porcentajeFrutasSecas = $porcentajeFrutasSecas - $valorN->valor;
                    }
                }
            }
        }

        //Azúcares y golosinas -> 5%

        $alimentosRecomendadosAzucar = [];
        $alimentosRecomendadosGolosinas = [];

        $porcentajeAzucar = $porcentajeAzucarDulcesGolosinas / 2;
        $porcentajeGolosinas = $porcentajeAzucarDulcesGolosinas / 2;

        foreach($alimentosAzucar as $azucar){
            foreach($ValoresNutricionales as $valorN){
                if($azucar->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeAzucar){
                    if($porcentajeAzucar > 0){
                        $alimentosRecomendadosAzucar[] = $azucar->alimento;
                        $porcentajeAzucar = $porcentajeAzucar - $valorN->valor;
                    }
                }
            }
        }

        foreach($alimentosGolosinas as $golosina){
            foreach($ValoresNutricionales as $valorN){
                if($golosina->id == $valorN->alimento_id && $valorN->nutriente_id == $nutrientesKcal->id && $valorN->valor < $porcentajeGolosinas){
                    if($porcentajeGolosinas > 0){
                        $alimentosRecomendadosGolosinas[] = $golosina->alimento;
                        $porcentajeGolosinas = $porcentajeGolosinas - $valorN->valor;
                    }
                }
            }
        }
/*
        //Obtenemos los alimentos que no le gustan al paciente
        $alimentosNoGustan = [];
        foreach($anamnesisPaciente as $anamnesis){
            if($anamnesis->gusta == 0){
                $alimentosNoGustan[] = $anamnesis->alimento;
            }
        }
*/

        return [
            'alimentosFrutas' => $alimentosRecomendadosFrutas,
            'alimentosVerduras' => $alimentosRecomendadosVerduras,
            'alimentosLegumbres' => $alimentosRecomendadosLegumbres,
            'alimentosLeche' => $alimentosRecomendadosLeche,
            'alimentosYogur' => $alimentosRecomendadosYogur,
            'alimentosQueso' => $alimentosRecomendadosQueso,
            'alimentosCarnes' => $alimentosRecomendadosCarnes,
            'alimentosHuevos' => $alimentosRecomendadosHuevos,
            'alimentosPescados' => $alimentosRecomendadosPescados,
            'alimentosAceites' => $alimentosRecomendadosAceites,
            'alimentosFrutasSecas' => $alimentosRecomendadosFrutasSecas,
            'alimentosAzucar' => $alimentosRecomendadosAzucar,
            'alimentosGolosinas' => $alimentosRecomendadosGolosinas,
        ];



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

    public function calcularIMC(Request $request){
        // Recopilamos los datos de la solicitud
        $pesoActual = floatval($request->input('peso'));
        $alturaActual = floatval($request->input('altura'));

        $imc = 0;
        $pesoIdeal = 0;
        //Generamos diagnóstico
        $diagnostico = '';

         //Calculamos el IMC
        if($pesoActual && $alturaActual){
            //Primero pasamos la altura de cm a m
            $alturaMetro = $alturaActual / 100;
            $imc = $pesoActual / ($alturaMetro * $alturaMetro);

            // Redondeamos el IMC a 2 decimales
            $imc = number_format($imc, 2, '.', ''); // Formato decimal(8,2)

            //Calculamos el peso ideal
            if($imc < 18.5){
                $diagnostico .= 'Paciente con bajo peso. ';
                $pesoIdeal = 18.5 * ($alturaMetro * $alturaMetro); //Bajo peso
            }else if($imc >= 18.5 && $imc <= 24.99){
                $diagnostico .= 'Paciente con un peso saludable. ';
                $pesoIdeal = $pesoActual; //Peso normal
            }else if($imc >= 25 && $imc <= 29.99){
                $diagnostico .= 'Paciente con sobrepeso. ';
                $pesoIdeal = 25 * ($alturaMetro * $alturaMetro); //Sobrepeso
            }else if($imc >= 30 && $imc <= 34.99){
                $diagnostico .= 'Paciente con obesidad de grado 1. ';
                $pesoIdeal = 30 * ($alturaMetro * $alturaMetro); //Obesidad grado 1
            }else if($imc >= 35 && $imc <= 39.99){
                $diagnostico .= 'Paciente con obesidad de grado 2. ';
                $pesoIdeal = 35 * ($alturaMetro * $alturaMetro); //Obesidad grado 2
            }else if($imc >= 40){
                $diagnostico .= 'Paciente con obesidad mórbida. ';
                $pesoIdeal = 40 * ($alturaMetro * $alturaMetro); //Obesidad grado 3 o mórbida
            }
        }

        return [
            'imc' => $imc,
            'pesoIdeal' => $pesoIdeal,
            'diagnostico' => $diagnostico,
        ];

    }

    public function realizarCalculos(Request $request){

        // Obtenemos los datos del formulario
        $paciente = Paciente::find($request->input('paciente'));

        // Recopilamos los datos de la solicitud
        $pesoActual = floatval($request->input('peso'));
        $alturaActual = floatval($request->input('altura'));
        $calculosSeleccionados = $request->input('calculosSeleccionado');
        $plieguesSeleccionado = $request->input('plieguesSeleccionado');


        // Realiza los cálculos necesarios aquí

        $masaGrasa = 0;
        $masaOsea = 0;
        $masaResidual = 0;
        $masaMuscular = 0;
        //Generamos diagnóstico
        $diagnostico = '';

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
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa

                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }
                //Hombres entre 20 y 29 años
                if($paciente->edad >= 20 && $paciente->edad <= 29){
                    $densidadCorporal = 1.1631 - (0.0632 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 30 && $paciente->edad <= 39){
                    //Hombres entre 30 y 39 años
                    $densidadCorporal = 1.1422 - (0.0544 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 40 && $paciente->edad <= 49){
                    //Hombres entre 40 y 49 años
                    $densidadCorporal = 1.1620 - (0.0700 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 50 && $paciente->edad <= 72){
                    //Hombres entre 50 y 72 años
                    $densidadCorporal = 1.1715 - (0.0779 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }
            } else if($paciente->sexo == 'Femenino'){
                //Mujeres entre 17 y 19 años
                if($paciente->edad >= 17 && $paciente->edad <= 19){
                    $densidadCorporal = 1.1549 - (0.0678 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }
                //Mujeres entre 20 y 29 años
                if($paciente->edad >= 20 && $paciente->edad <= 29){
                    $densidadCorporal = 1.1599 - (0.0717 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 30 && $paciente->edad <= 39){
                    //Mujeres entre 30 y 39 años
                    $densidadCorporal = 1.1423 - (0.0632 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 40 && $paciente->edad <= 49){
                    //Mujeres entre 40 y 49 años
                    $densidadCorporal = 1.1333 - (0.0612 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }else if($paciente->edad >= 50 && $paciente->edad <= 68){
                    //Mujeres entre 50 y 68 años
                    $densidadCorporal = 1.1339 - (0.0645 * log10($sumatoriaPliegues));
                    //Ecuación de Siri
                    $masaGrasa = (495/$densidadCorporal) - 450; // % de masa grasa
                    // Redondeamos la masa grasa a 2 decimales
                    $masaGrasa = number_format($masaGrasa, 2, '.', ''); // Formato decimal(5,2)
                }
            }
        }

        //Calculamos masa residual
        $masaResidual = 0;
        if(in_array('masa_residual', $calculosSeleccionados)){
            if($paciente->sexo == 'Masculino'){
                $masaResidual = 0.241 * $pesoActual; //en Kg
                // Redondeamos la masa residual a 2 decimales
                $masaResidual = number_format($masaResidual, 2, '.', ''); // Formato decimal(5,2)
            }else if($paciente->sexo == 'Femenino'){
                $masaResidual = 0.209 * $pesoActual; //en Kg
                // Redondeamos la masa residual a 2 decimales
                $masaResidual = number_format($masaResidual, 2, '.', ''); // Formato decimal(5,2)
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
            $masaOsea = 0.00006*$alturaActual*($sumatoriaDiametros*$sumatoriaDiametros);

            // Redondeamos la masa ósea a 2 decimales
            $masaOsea = number_format($masaOsea, 2, '.', ''); // Formato decimal(5,2)
        }

        //Calculamos masa muscular
        //Ecuación de De Rose y Guimaraes

        if(in_array('masa_muscular', $calculosSeleccionados)){
            $sumatoriaMasas = ($masaGrasa + $masaOsea + $masaResidual);

            //Masa muscular Kg
            $masaMuscular = abs($pesoActual - $sumatoriaMasas);

            // Redondeamos la masa muscular a 2 decimales
            $masaMuscular = number_format($masaMuscular, 2, '.', ''); // Formato decimal(5,2)
        }

        //Seguimos generando el diagnóstico según los cálculos realizados.
        if (in_array('masa_grasa', $calculosSeleccionados)) {
            if ($masaGrasa < 10) {
                $diagnostico .= 'Porcentaje de grasa extremadamente bajo (Preocupante). ';
            } elseif ($masaGrasa >= 10 && $masaGrasa <= 20) {
                $diagnostico .= 'Porcentaje de grasa bajo (Saludable). ';
            } elseif ($masaGrasa > 20 && $masaGrasa <= 30) {
                $diagnostico .= 'Porcentaje de grasa moderado, se recomienda un seguimiento. ';
            } elseif ($masaGrasa > 30) {
                $diagnostico .= 'Porcentaje de grasa elevado (podría requerir atención). ';
            }
        }

        if (in_array('masa_osea', $calculosSeleccionados)) {
            if ($masaOsea < 2) {
                $diagnostico .= 'Masa ósea baja (riesgo de osteoporosis). ';
            } elseif ($masaOsea >= 2 && $masaOsea <= 2.5) {
                $diagnostico .= 'Masa ósea normal. ';
            } elseif ($masaOsea > 2.5) {
                $diagnostico .= 'Masa ósea alta (positivo). ';
            }
        }

        if (in_array('masa_residual', $calculosSeleccionados)) {
            if ($masaResidual < 5) {
                $diagnostico .= 'Masa residual baja (investigar posible causa). ';
            } elseif ($masaResidual >= 5 && $masaResidual <= 10) {
                $diagnostico .= 'Masa residual normal. ';
            } elseif ($masaResidual > 10) {
                $diagnostico .= 'Masa residual alta (retención de líquidos u otros problemas). ';
            }
        }

        if (in_array('masa_muscular', $calculosSeleccionados)) {
            if ($masaMuscular < 20) {
                $diagnostico .= 'Masa muscular extremadamente baja. ';
            } elseif ($masaMuscular >= 20 && $masaMuscular <= 30) {
                $diagnostico .= 'Masa muscular baja. ';
            } elseif ($masaMuscular > 30 && $masaMuscular <= 40) {
                $diagnostico .= 'Masa muscular moderada. ';
            } elseif ($masaMuscular > 40) {
                $diagnostico .= 'Masa muscular elevada. ';
            }
        }

        // Quita la coma y el espacio extra al final del diagnóstico
        $diagnostico = rtrim($diagnostico, ', ');

        return response()->json([
            'diagnostico' => $diagnostico,
            'masaGrasa' => $masaGrasa,
            'masaOsea' => $masaOsea,
            'masaResidual' => $masaResidual,
            'masaMuscular' => $masaMuscular,
        ]);

    }

}
