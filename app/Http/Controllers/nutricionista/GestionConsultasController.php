<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentoPorTipoDeDieta;
use App\Models\AlimentosProhibidosAlergia;
use App\Models\AlimentosProhibidosIntolerancia;
use App\Models\AlimentosProhibidosPatologia;
use App\Models\AlimentosRecomendadosPorDieta;
use App\Models\Comida;
use App\Models\Consulta;
use App\Models\DetallePlanAlimentaciones;
use App\Models\Diagnostico;
use App\Models\MedicionesDePlieguesCutaneos;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use App\Models\TipoConsulta;
use App\Models\TiposDeDieta;
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
use App\Models\TagsDiagnostico;
use App\Models\Tratamiento;
use App\Models\UnidadesMedidasPorComida;
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
            'diagnostico' => ['required', 'string', 'max:255'],
            'imc_actual' => ['required', 'numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_grasa_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'] ,
            'masa_osea_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_residual_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'masa_muscular_actual' => ['numeric', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
        ]);

        if($request->has('nuevas_mediciones-circunferencias')){
            $request->validate([
                'circ_munieca_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
                'circ_cintura_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
                'circ_cadera_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
                'circ_pecho_actual' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            ]);
            $circMuniecaActual = $request->input('circ_munieca_actual');
            $circCinturaActual = $request->input('circ_cintura_actual');
            $circCaderaActual = $request->input('circ_cadera_actual');
            $circPechoActual = $request->input('circ_pecho_actual');
        }else{
            $circMuniecaActual = 0.00;
            $circCinturaActual = 0.00;
            $circCaderaActual = 0.00;
            $circPechoActual = 0.00;
        }

        //Obtenemos los datos del formulario
        $tratamientoPaciente = $request->input('tratamiento_paciente');
        $observacion = $request->input('observacion');
        $pesoActual = $request->input('peso_actual');
        $alturaActual = $request->input('altura_actual');

        $descripcionDiagnostico = $request->input('diagnostico');

        //dd($descripcionDiagnostico);

        $tagsSeleccionadas = $request->input('tags_diagnostico');

        //dd($descripcionDiagnostico, $tagsSeleccionadas);

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
        ]);

        $diagnostico = Diagnostico::create([
            'consulta_id' => $consulta->id,
            'descripcion_diagnostico' => $descripcionDiagnostico
        ]);

        if($diagnostico){
            if(!empty($tagsSeleccionadas)){
                foreach($tagsSeleccionadas as $tagId){
                    TagsDiagnostico::create([
                        'diagnostico_id' => $diagnostico->id,
                        'tag_id' => $tagId
                    ]);
                }
            }
        }

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

        $tratamientoPaciente= TratamientoPorPaciente::create([
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
            $planGenerado = $this->generarPlanesAlimentacion($paciente->id, $turno->id, $tratamientoPaciente->id);
        }

        if($planGenerado){
            return redirect()->route('gestion-turnos-nutricionista.index')
            ->with('successConPlanGenerado', 'Consulta realizada con éxito. Se generó el plan de alimentación')
            ->with('pacienteId', $pacienteId)
            ->with('turnoId', $turno->id)
            ->with('nutricionistaId', $nutricionista->id);

        }else{
            return redirect()->back()->with('errorPlanNoGenerado', 'No se pudo generar el plan');
        }

        if(!$planGenerado){
            return redirect()->route('gestion-turnos-nutricionista.index')->with('successSinPlanGenerado', 'Consulta realizada con éxito.');
        }

    }


    //Función para el 2do proceso automatizado: Generación automática de Plan de alimentación
    public function generarPlanesAlimentacion($id, $turnoId, $tratamientoPacienteId){
        //Buscamos el paciente
        $paciente = Paciente::find($id);

        //Tratamiento
        $tratamientoPaciente = TratamientoPorPaciente::find($tratamientoPacienteId);

        //dd($tratamientoPaciente);

        if( $tratamientoPaciente ){
            $tratamiento = Tratamiento::where('id', $tratamientoPaciente->tratamiento_id)->first();
            $tipoDieta = TiposDeDieta::where('id', $tratamiento->tipo_de_dieta_id)->first();
        }

        //Buscamos historia clínica del paciente
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        //dd($paciente, $historiaClinica, $tratamiento, $tipoDieta);

        //Obtenemos el tratamiento activo del paciente
        //$tratamientoActivo = TratamientoPorPaciente::where('paciente_id', $paciente->id)->where('estado', 'Activo')->first();

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

        //Llamamos a la función para calcular el GEB del paciente
        $resultadoGEB = $this->determinarGEB($paciente->edad, $paciente->sexo, $consulta->peso_Actual, $consulta->altura_actual, $alturaMetro);
        $gastoEnergeticoBasal = $resultadoGEB['geb'];

        //Comenzamos a realizar la descripción del plan de alimentación
        $descripcionPlan = '';
        //Si el IMC es menor a 18.5, el paciente está bajo de peso
        //Dieta HIPERCALÓRICA
        if($imc < 18.50){
            //Bajo peso
            $descripcionPlan = 'Bajo Peso. Dieta Hipercalórica. ';
            if($imc < 16){
                //Delgadez severa
                $descripcionPlan = 'Bajo Peso. Dieta Hipercalórica. Delgadez severa. ';
            }else if($imc >= 16 && $imc <= 16.99){
                //Delgadez moderada
                $descripcionPlan = 'Bajo Peso. Dieta Hipercalórica. Delgadez moderada. ';
            }else if($imc >= 17 && $imc <= 18.49){
                //Delgadez aceptable
                $descripcionPlan = 'Bajo Peso. Dieta Hipercalórica. Delgadez aceptable. ';
            }
        }

        //Si el IMC está entre 18.5 y 24.99, el paciente está normal
        //IMC normal -> Dieta NORMOCALÓRICA
        if($imc >= 18.5 && $imc <= 24.99){
            //Normal
            $descripcionPlan = 'Peso Normal. Dieta Normocalórica. ';
        }

        //Si el IMC es mayor a 25, el paciente tiene sobrepeso
        //Dieta HIPOCALÓRICA
        if($imc >= 25){
            //Sobrepeso
            if($imc >= 25 && $imc <= 29.99){
                //Preobesidad
                $descripcionPlan = 'Sobrepeso. Dieta Hipocalórica. Preobesidad. ';
            }else if($imc >= 30 && $imc <= 34.99){
                //Obesidad grado 1
                $descripcionPlan = 'Sobrepeso. Dieta Hipocalórica. Obesidad grado 1. ';
            }else if($imc >= 35 && $imc <= 39.99){
                //Obesidad grado 2
                $descripcionPlan = 'Sobrepeso. Dieta Hipocalórica. Obesidad grado 2. ';
            }else if($imc >= 40){
                //Obesidad grado 3 o mórbida
                $descripcionPlan = 'Sobrepeso. Dieta Hipocalórica. Obesidad grado 3 o mórbida. ';
            }
        }

        //Calculamos el gasto energético total
        $resultadoGET = $this->determinacionGET($gastoEnergeticoBasal, $historiaClinica->estilo_vida);

        $gastoEnergeticoTotal = $resultadoGET['get'];

        //Verificamos cual es el objetivo de salud del paciente
        if($historiaClinica->objetivo_salud == 'Adelgazar'){
            $gastoEnergeticoTotal -= 500;
        }

        if ($historiaClinica->objetivo_salud == 'Ganar masa muscular'){
            $gastoEnergeticoTotal += 500;
        }

        //Agregamos esto a la descripción del plan.
        $descripcionPlan .= 'Gasto energético total: ' . $gastoEnergeticoTotal ;

        //Determinación de gramos de proteínas, carbohidratos y lípidos (Adultos)
        $resultadoNutriente = $this->determinacionNutrientes($gastoEnergeticoTotal, $paciente->edad);

        $carbohidratosRecomendados = round($resultadoNutriente['carbohidratos'], 3);
        $lipidosRecomendados = round($resultadoNutriente['lipidos'], 3);
        $proteinasRecomendadas = round($resultadoNutriente['proteinas'], 3);

        //Agregamos esto a la descripción del plan.
        $descripcionPlan .= '. Carbohidratos Diarios: ' . $carbohidratosRecomendados . ' g. Lípidos diarios: ' . $lipidosRecomendados . ' g. Proteínas diarias: ' . $proteinasRecomendadas.' g.';
        $descripcionPlan = substr($descripcionPlan, 0, 255);

        //Evaluamos el porcentaje necesario por grupo de alimentos (Según Guia Argentina)
        $resultadoEleccionAlimentos = $this->porcentajeAlimentos($gastoEnergeticoTotal);

        $porcentajeFrutasVerduras = $resultadoEleccionAlimentos['porcentajeFrutasVerduras'];
        $porcentajeLegumbresCereales = $resultadoEleccionAlimentos['porcentajeLegumbresCereales'];
        $porcentajeLecheYogurQueso = $resultadoEleccionAlimentos['porcentajeLecheYogurQueso'];
        $porcentajeCarnesHuevo = $resultadoEleccionAlimentos['porcentajeCarnesHuevo'];
        $porcentajeAceitesFrutasSecasSemillas = $resultadoEleccionAlimentos['porcentajeAceitesFrutasSecasSemillas'];
        $porcentajeAzucarDulcesGolosinas = $resultadoEleccionAlimentos['porcentajeAzucarDulcesGolosinas'];

        //Selección de alimentos
        $alimentosPaciente = $this->eleccionAlimentos($historiaClinica->id, $tipoDieta->id, $porcentajeFrutasVerduras, $porcentajeLegumbresCereales, $porcentajeLecheYogurQueso, $porcentajeCarnesHuevo, $porcentajeAceitesFrutasSecasSemillas, $porcentajeAzucarDulcesGolosinas, $carbohidratosRecomendados, $lipidosRecomendados, $proteinasRecomendadas);

        //Obtenemos los alimentos recomendados
        $alimentosRecomendadosFrutas = $alimentosPaciente['frutasRecomendadas'];
        $alimentosRecomendadosVerduras = $alimentosPaciente['verdurasRecomendadas'];

        //Crea un array con todos estos alimentos
        $alimentosRecomendados = array_merge(
            $alimentosRecomendadosFrutas,
            $alimentosRecomendadosVerduras,
        );

        //Obtenemos el plan generado en consultas anteriores para el paciente y lo volvemos inactivo.
        $ultimoPlanAlimentacionPaciente = PlanAlimentaciones::where('paciente_id', $paciente->id)->where('estado', 1)->orderBy('id', 'desc')->first();

        if($ultimoPlanAlimentacionPaciente){
            $ultimoPlanAlimentacionPaciente->estado = 0;
            $ultimoPlanAlimentacionPaciente->save();
        }

        // Crea un nuevo plan de alimentación
        $planAlimentacion = PlanAlimentaciones::create([
            'consulta_id' => $consulta->id, // Asocia el plan a la consulta
            'paciente_id' => $paciente->id, // Asocia el plan al paciente
            'descripcion' => $descripcionPlan,
            'estado' => 2, //Estado esperando confirmación del profesional
        ]);

        $planAlimentacion->save(); // Guarda el nuevo plan de alimentación

        $alimentosPorDieta = AlimentoPorTipoDeDieta::where('tipo_de_dieta_id', $tipoDieta->id)->get();
        $alimentosrecomendadosPorDieta = AlimentosRecomendadosPorDieta::all();

        $valoresNutricionales = ValorNutricional::all();
        $nutrientes = Nutriente::all();
        $unidadesMedidas = UnidadesMedidasPorComida::all();

        $carbohidratos = [];
        $lipidos = [];
        $proteinas = [];

        foreach ($alimentosRecomendados as $alimentoRecomendado) {
            foreach($alimentosPorDieta as $alimentoDieta){
                foreach ($alimentosrecomendadosPorDieta as $alimRecomendadoDieta) {
                    if ($alimentoDieta->id == $alimentoRecomendado && $alimentoDieta->id == $alimRecomendadoDieta->alimento_por_dieta_id) {
                        foreach ($valoresNutricionales as $valorN) {
                            foreach ($nutrientes as $nutriente) {
                                foreach ($unidadesMedidas as $unidad) {
                                    if ($alimRecomendadoDieta->unidad_medida_id == $unidad->id) {
                                        $valor = $valorN->valor;

                                        if ($unidad->nombre_unidad_medida == 'Gramos') {
                                            $cantidad = $alimRecomendadoDieta->cantidad; //Gramos
                                        } elseif ($unidad->nombre_unidad_medida == 'Kcal') {
                                            if ($nutriente->nombre_nutriente === 'Carbohidratos totales') {
                                                $cantidad = $alimRecomendadoDieta->cantidad / 4; //kcal a gramos
                                            } elseif ($nutriente->nombre_nutriente === 'Proteínas') {
                                                $cantidad = $alimRecomendadoDieta->cantidad / 4; //kcal a gramos
                                            } elseif ($nutriente->nombre_nutriente === 'Lípidos totales') {
                                                $cantidad = $alimRecomendadoDieta->cantidad / 9; //kcal a gramos
                                            }
                                        }

                                        if($nutriente->nombre_nutriente == 'Carbohidratos totales' && $valorN->nutriente_id == $nutriente->id){
                                            $total = ($valor * $cantidad) / 100; //Gramos
                                            $carbohidratos[] = $total*4; //Kcal
                                        } elseif ($nutriente->nombre_nutriente == 'Lípidos totales' && $valorN->nutriente_id == $nutriente->id){
                                            $total = ($valor * $cantidad) / 100; //Gramos
                                            $lipidos[] = $total*9;//Kcal
                                        } elseif ($nutriente->nombre_nutriente == 'Proteínas' && $valorN->nutriente_id == $nutriente->id){
                                            $total = ($valor * $cantidad) / 100; //Gramos
                                            $proteinas[] = $total*4;//Kcal
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $i = 0;
        // Asocia los detalles del plan de alimentación al plan recién creado
        foreach ($alimentosRecomendados as $alimentoRecomendado) {
            $observacion = '';
            foreach($alimentosPorDieta as $alimentoDieta){
                foreach ($alimentosrecomendadosPorDieta as $alimRecomendadoDieta) {
                    $comida = Comida::where('id', $alimRecomendadoDieta->comida_id)->first();
                    $unidadMedida = UnidadesMedidasPorComida::where('id', $alimRecomendadoDieta->unidad_medida_id)->first();
                    $observacion = 'Carbohidratos: ' . $carbohidratos[$i] . ' kcal. Proteínas: ' . $proteinas[$i] . ' kcal. Lípidos: ' . $lipidos[$i] . ' kcal.';
                    if ($alimentoDieta->id == $alimentoRecomendado && $alimentoDieta->id == $alimRecomendadoDieta->alimento_por_dieta_id) {
                        $detallePlan = DetallePlanAlimentaciones::create([
                            'plan_alimentacion_id' => $planAlimentacion->id, // Asocia el plan al detalle del plan
                            'alimento_id' => $alimentoDieta->alimento_id, // Asocia el alimento al detalle del plan
                            'horario_consumicion' => $comida->nombre_comida, // Establece el horario según tus necesidades
                            'cantidad' => $alimRecomendadoDieta->cantidad, // Establece la cantidad según tus necesidades
                            'unidad_medida' => $unidadMedida->nombre_unidad_medida, // Establece la unidad de medida según tus necesidades
                            'observacion' => $observacion,
                        ]);

                        $detallePlan->save(); // Guarda el detalle del plan
                    }
                }
            }
            $i++;
        }

        return [
            'paciente' => $paciente,
            'historiaClinica' => $historiaClinica,
            'tratamientoPaciente' => $tratamiento->tratamiento,
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
        ];
    }

    public function determinarGEB($edad, $sexo, $peso, $alturaCM, $alturaMetro){

        $gastoEnergeticoBasal = 0;

        //Usamos la fórmula de Mifflin St. Jeor (No recomendable en pacientes menores de 18 años) para calcular el gasto energético basal

        if($edad > 18){
            if($sexo == 'Masculino'){
                $gastoEnergeticoBasal = (10 * $peso) + (6.25 * $alturaCM) - (5 * $edad) + 5;
            }

            if($sexo == 'Femenino'){
                $gastoEnergeticoBasal = (10 * $peso) + (6.25 * $alturaCM) - (5 * $edad) - 161;
            }
        }

        //Usamos fórmula de Schofield
        if($edad < 18){
            if($edad < 3){
                if($sexo == 'Masculino'){
                    $gastoEnergeticoBasalMj = (0.0007 * $peso) + (6.349 * $alturaMetro) - 2.584; //en Mj

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                }

                if ($sexo == 'Femenino'){
                    $gastoEnergeticoBasalMj = (0.068 * $peso) + (4.281 * $alturaMetro) - 1.730;

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //en Kcal
                }
            }else if($edad >= 3 && $edad < 10){
                //Usamos fórmula de Schofield

                if($sexo == 'Masculino'){
                    $gastoEnergeticoBasalMj = (0.082 * $peso) + (0.545 * $alturaMetro) - 1.736;

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                }

                if($sexo == 'Femenino'){
                    $gastoEnergeticoBasalMj = (0.071 * $peso) + (0.677 * $alturaMetro) - 1.553;

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal
                }
            }else if($edad >= 11 && $edad <18){
                //Usamos fórmula de Schofield

                if($sexo == 'Masculino'){
                    $gastoEnergeticoBasalMj = (0.068 * $peso) + (0.574 * $alturaMetro) - 2.157;

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal

                }

                if($sexo == 'Femenino'){
                    $gastoEnergeticoBasalMj= (0.035 * $peso) + (1.9484 * $alturaMetro) - 0.837;

                    //Pasamos de Mj a kj
                    $gatoEnergeticoBasalKj = $gastoEnergeticoBasalMj * 1000; //Kj

                    //Pasamos de kj a kcal
                    $gastoEnergeticoBasal = $gatoEnergeticoBasalKj * (1 / 4.184); //rn Kcal
                }
            }
        }

        return [
            'geb' => $gastoEnergeticoBasal,
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

    public function eleccionAlimentos($historiaClinicaId, $tipoDietaId, $porcentajeFrutasVerduras, $porcentajeLegumbresCereales, $porcentajeLecheYogurQueso, $porcentajeCarnesHuevo, $porcentajeAceitesFrutasSecasSemillas, $porcentajeAzucarDulcesGolosinas,  $carbohidratosRecomendados, $lipidosRecomendados, $proteinasRecomendadas){

        //Buscamos la historia Clinica
        $historiaClinica = HistoriaClinica::find($historiaClinicaId);
        $paciente = Paciente::where('id', $historiaClinica->paciente_id)->first();

        //Tipo de dieta
        $tipoDieta = TiposDeDieta::find($tipoDietaId);

        //$cantidadComidasPorAlimento = $this->obtenerCantidadComidasPorAlimento($tipoDieta->id);

        //Alimentos por dieta
        $alimentosPorDieta = AlimentoPorTipoDeDieta::where('tipo_de_dieta_id', $tipoDieta->id)->get();
        //$alimentosrecomendadosPorDieta = AlimentosRecomendadosPorDieta::all();

        $comidas = Comida::all();
        $unidadesMedidas = UnidadesMedidasPorComida::all();

        //ValoresNutricionales y nutrientes
        $nutrientesKcal = Nutriente::where('nombre_nutriente', 'Valor energético')->first();
        $ValoresNutricionales = ValorNutricional::all();
        $nutrientes = Nutriente::all();

        //Obtenemos los alimentos que debe consumir el paciente según su porcentaje
        //Tenemos en cuenta los datos médicos (Si tiene o no patologías, alergias etc.). Si tiene, se le recomienda alimentos que no le hagan mal.
        //También comprobamos la anamnesis alimentatia para saber sus preferencias alimenticias. Si no le gusta un alimento, se le recomienda otro.

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


        //COMIENZO DE SELECCIÓN DE ALIMENTOS

        //Llamamos a la función para obtener la cantidad de comidas recomendadas de cada tipo de alimento
        $cantComidas = $this->obtenerCantidadComidasPorAlimento($tipoDietaId);

        //Frutas y verduras -> 50%
        $frutasRecomendadas = [];
        $caloriasTotalesFrutas = $porcentajeFrutasVerduras / 2; //en kcal
        $caloriasTotalesVerduras = $porcentajeFrutasVerduras / 2; //kcal

        $cantComidasFrutas = $cantComidas['comidasFrutas'] ?? 0; //Si no existe comidasFrutas en el arreglo se asigna automáticamente 0
        $comidaDesayuno = Comida::where('nombre_comida', 'Desayuno')->first();
        $comidaMediaManiana = Comida::where('nombre_comida', 'Media maniana')->first();
        $comidaAlmuerzo = Comida::where('nombre_comida', 'Almuerzo')->first();
        $comidaMerienda = Comida::where('nombre_comida', 'Merienda')->first();
        $comidaCena = Comida::where('nombre_comida', 'Cena')->first();

        if($cantComidasFrutas > 0){

            $alimentosDesayunoRecomendadosFruta = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $frutasDesayuno = [];

            if($alimentosDesayunoRecomendadosFruta > 0){
                //Frutas por comida y por macronutriente
                $carbohidratoFrutasDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en desayuno
                $lipidoFrutasDesayuno = (($lipidosDesayuno * 9) * ($caloriasTotalesFrutas/$cantComidasFrutas))/9; //Gramos totales de frutas en desayuno
                $proteinaFrutasDesayuno = (($proteinasDesayuno * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoFruta, $carbohidratoFrutasDesayuno, $lipidoFrutasDesayuno, $proteinaFrutasDesayuno);

                $frutasDesayuno = array_merge($frutasDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosFruta = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $frutasMediaManiana = [];

            if($alimentosMediaManianaRecomendadosFruta > 0){
                $carbohidratoFrutasMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana
                $lipidoFrutasMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasTotalesFrutas/$cantComidasFrutas))/9; //Gramos totales de frutas en media mañana
                $proteinaFrutasMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoFruta, $carbohidratoFrutasMediaManiana, $lipidoFrutasMediaManiana, $proteinaFrutasMediaManiana);

                $frutasMediaManiana = array_merge($frutasMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosFruta = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $frutasAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosFruta > 0){
                $carbohidratoFrutasAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana
                $lipidoFrutasAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasTotalesFrutas/$cantComidasFrutas))/9; //Gramos totales de frutas en media mañana
                $proteinaFrutasAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoFruta, $carbohidratoFrutasAlmuerzo, $lipidoFrutasAlmuerzo, $proteinaFrutasAlmuerzo);

                $frutasAlmuerzo = array_merge($frutasAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosFruta = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $frutasMerienda = [];

            if($alimentosMeriendaRecomendadosFruta > 0){
                $carbohidratoFrutasMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana
                $lipidoFrutasMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasTotalesFrutas/$cantComidasFrutas))/9; //Gramos totales de frutas en media mañana
                $proteinaFrutasMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoFruta, $carbohidratoFrutasMediaTarde, $lipidoFrutasMediaTarde, $proteinaFrutasMediaTarde);

                $frutasMerienda = array_merge($frutasMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosFruta = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $frutasCena = [];

            if($alimentosCenaRecomendadosFruta > 0){
                $carbohidratoFrutasCena = (($carbohidratosCena * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana
                $lipidoFrutasCena = (($lipidosCena * 9) * ($caloriasTotalesFrutas/$cantComidasFrutas))/9; //Gramos totales de frutas en media mañana
                $proteinaFrutasCena = (($proteinasCena * 4) * ($caloriasTotalesFrutas/$cantComidasFrutas))/4; //Gramos totales de frutas en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoFruta, $carbohidratoFrutasCena, $lipidoFrutasCena, $proteinaFrutasCena);

                $frutasCena = array_merge($frutasCena, $resultados['alimentosRecomendados']);
            }

            $frutasRecomendadas = array_merge(
                $frutasDesayuno,
                $frutasMediaManiana,
                $frutasAlmuerzo,
                $frutasMerienda,
                $frutasCena,
            );

        }

        //VERDURAS
        $verdurasRecomendadas = [];
        $cantComidasVerduras = $cantComidas['comidasVerduras'] ?? 0; //Si no existe comidasVerduras en el arreglo se asigna automáticamente 0

        //dd($caloriasTotalesVerduras, $cantComidasFrutas, $cantComidasVerduras);

        if($cantComidasVerduras > 0){

            $alimentosDesayunoRecomendadosVerdura = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $verdurasDesayuno = [];

            if($alimentosDesayunoRecomendadosVerdura > 0){
                //Verduras por comida y por macronutriente
                $carbohidratoVerdurasDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en desayuno
                $lipidoVerdurasDesayuno = (($lipidosDesayuno * 9) * ($caloriasTotalesVerduras/$cantComidasVerduras))/9; //Gramos totales de verduras en desayuno
                $proteinaVerdurasDesayuno = (($proteinasDesayuno * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoVerdura, $carbohidratoVerdurasDesayuno, $lipidoVerdurasDesayuno, $proteinaVerdurasDesayuno);

                $verdurasDesayuno = array_merge($verdurasDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosVerdura = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $verdurasMediaManiana = [];

            if($alimentosMediaManianaRecomendadosVerdura > 0){
                $carbohidratoVerdurasMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana
                $lipidoVerdurasMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasTotalesVerduras/$cantComidasVerduras))/9; //Gramos totales de verduras en media mañana
                $proteinaVerdurasMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoVerdura, $carbohidratoVerdurasMediaManiana, $lipidoVerdurasMediaManiana, $proteinaVerdurasMediaManiana);

                $verdurasMediaManiana = array_merge($verdurasMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosVerdura = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $verdurasAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosVerdura > 0){
                $carbohidratoVerdurasAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana
                $lipidoVerdurasAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasTotalesVerduras/$cantComidasVerduras))/9; //Gramos totales de verduras en media mañana
                $proteinaVerdurasAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoVerdura, $carbohidratoVerdurasAlmuerzo, $lipidoVerdurasAlmuerzo, $proteinaVerdurasAlmuerzo);

                $verdurasAlmuerzo = array_merge($verdurasAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosVerdura = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $verdurasMerienda = [];

            if($alimentosMeriendaRecomendadosVerdura > 0){
                $carbohidratoVerdurasMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana
                $lipidoVerdurasMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasTotalesVerduras/$cantComidasVerduras))/9; //Gramos totales de verduras en media mañana
                $proteinaVerdurasMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoVerdura, $carbohidratoVerdurasMediaTarde, $lipidoVerdurasMediaTarde, $proteinaVerdurasMediaTarde);

                $verdurasMerienda = array_merge($verdurasMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosVerdura = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $verdurasCena = [];

            if($alimentosCenaRecomendadosVerdura > 0){
                $carbohidratoVerdurasCena = (($carbohidratosCena * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana
                $lipidoVerdurasCena = (($lipidosCena * 9) * ($caloriasTotalesVerduras/$cantComidasVerduras))/9; //Gramos totales de verduras en media mañana
                $proteinaVerdurasCena = (($proteinasCena * 4) * ($caloriasTotalesVerduras/$cantComidasVerduras))/4; //Gramos totales de verduras en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoVerdura, $carbohidratoVerdurasCena, $lipidoVerdurasCena, $proteinaVerdurasCena);

                $verdurasCena = array_merge($verdurasCena, $resultados['alimentosRecomendados']);
            }

            $verdurasRecomendadas = array_merge(
                $verdurasDesayuno,
                $verdurasMediaManiana,
                $verdurasAlmuerzo,
                $verdurasMerienda,
                $verdurasCena,
            );
        }

        //Legumbres y cereales -> 25%
        $legumbresRecomendadas = [];
        $caloriasTotalesLegumbres = $porcentajeLegumbresCereales; //en kcal

        $cantComidasLegumbres = $cantComidas['comidasLegumbrescerealespapachoclobatatapanypastas'] ?? 0;

        if($cantComidasLegumbres > 0){

            $alimentosDesayunoRecomendadosLegumbres = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $legumbresDesayuno = [];

            if($alimentosDesayunoRecomendadosLegumbres > 0){
                //Legumbres por comida y por macronutriente
                $carbohidratoLegumbresDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en desayuno
                $lipidoLegumbresDesayuno = (($lipidosDesayuno * 9) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/9; //Gramos totales de legumbres en desayuno
                $proteinaLegumbresDesayuno = (($proteinasDesayuno * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoLegumbres, $carbohidratoLegumbresDesayuno, $lipidoLegumbresDesayuno, $proteinaLegumbresDesayuno);

                $legumbresDesayuno = array_merge($legumbresDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosLegumbres = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $legumbresMediaManiana = [];

            if($alimentosMediaManianaRecomendadosLegumbres > 0){
                $carbohidratoLegumbresMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana
                $lipidoLegumbresMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/9; //Gramos totales de legumbres en media mañana
                $proteinaLegumbresMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoLegumbres, $carbohidratoLegumbresMediaManiana, $lipidoLegumbresMediaManiana, $proteinaLegumbresMediaManiana);

                $legumbresMediaManiana = array_merge($legumbresMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosLegumbres = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $legumbresAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosLegumbres > 0){
                $carbohidratoLegumbresAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana
                $lipidoLegumbresAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/9; //Gramos totales de legumbres en media mañana
                $proteinaLegumbresAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoLegumbres, $carbohidratoLegumbresAlmuerzo, $lipidoLegumbresAlmuerzo, $proteinaLegumbresAlmuerzo);

                $legumbresAlmuerzo = array_merge($legumbresAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosLegumbres = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $legumbresMerienda = [];

            if($alimentosMeriendaRecomendadosLegumbres > 0){
                $carbohidratoLegumbresMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana
                $lipidoLegumbresMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/9; //Gramos totales de legumbres en media mañana
                $proteinaLegumbresMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoLegumbres, $carbohidratoLegumbresMediaTarde, $lipidoLegumbresMediaTarde, $proteinaLegumbresMediaTarde);

                $legumbresMerienda = array_merge($legumbresMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosLegumbres = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $legumbresCena = [];

            if($alimentosCenaRecomendadosLegumbres > 0){
                $carbohidratoLegumbresCena = (($carbohidratosCena * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana
                $lipidoLegumbresCena = (($lipidosCena * 9) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/9; //Gramos totales de legumbres en media mañana
                $proteinaLegumbresCena = (($proteinasCena * 4) * ($caloriasTotalesLegumbres/$cantComidasLegumbres))/4; //Gramos totales de legumbres en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoLegumbres, $carbohidratoLegumbresCena, $lipidoLegumbresCena, $proteinaLegumbresCena);

                $legumbresCena = array_merge($legumbresCena, $resultados['alimentosRecomendados']);
            }

            $legumbresRecomendadas = array_merge(
                $legumbresDesayuno,
                $legumbresMediaManiana,
                $legumbresAlmuerzo,
                $legumbresMerienda,
                $legumbresCena,
            );

        }

        //Leches, Yogures y quesos -> 10%
        //Leches.

        $lecheRecomendadas = [];
        $caloriasLecheTotal = $porcentajeLecheYogurQueso / 3;

        $cantComidasLeche = $cantComidas['comidasLecheypostresdeleche'] ?? 0; //Si no existe comidasLeche en el arreglo se asigna automáticamente 0

        if($cantComidasLeche > 0){

            $alimentosDesayunoRecomendadosLeche = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $lecheDesayuno = [];

            if($alimentosDesayunoRecomendadosLeche > 0){
                //Leche por comida y por macronutriente
                $carbohidratoLecheDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en desayuno
                $lipidoLecheDesayuno = (($lipidosDesayuno * 9) * ($caloriasLecheTotal/$cantComidasLeche))/9; //Gramos totales de leche en desayuno
                $proteinaLecheDesayuno = (($proteinasDesayuno * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoLeche, $carbohidratoLecheDesayuno, $lipidoLecheDesayuno, $proteinaLecheDesayuno);

                $lecheDesayuno = array_merge($lecheDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosLeche = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $lecheMediaManiana = [];

            if($alimentosMediaManianaRecomendadosLeche > 0){
                $carbohidratoLecheMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana
                $lipidoLecheMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasLecheTotal/$cantComidasLeche))/9; //Gramos totales de leche en media mañana
                $proteinaLecheMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoLeche, $carbohidratoLecheMediaManiana, $lipidoLecheMediaManiana, $proteinaLecheMediaManiana);

                $lecheMediaManiana = array_merge($lecheMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosLeche = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $lecheAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosLeche > 0){
                $carbohidratoLecheAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana
                $lipidoLecheAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasLecheTotal/$cantComidasLeche))/9; //Gramos totales de leche en media mañana
                $proteinaLecheAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoLeche, $carbohidratoLecheAlmuerzo, $lipidoLecheAlmuerzo, $proteinaLecheAlmuerzo);

                $lecheAlmuerzo = array_merge($lecheAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosLeche = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $lecheMerienda = [];

            if($alimentosMeriendaRecomendadosLeche > 0){
                $carbohidratoLecheMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana
                $lipidoLecheMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasLecheTotal/$cantComidasLeche))/9; //Gramos totales de leche en media mañana
                $proteinaLecheMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoLeche, $carbohidratoLecheMediaTarde, $lipidoLecheMediaTarde, $proteinaLecheMediaTarde);

                $lecheMerienda = array_merge($lecheMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosLeche = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $lecheCena = [];

            if($alimentosCenaRecomendadosLeche > 0){
                $carbohidratoLecheCena = (($carbohidratosCena * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana
                $lipidoLecheCena = (($lipidosCena * 9) * ($caloriasLecheTotal/$cantComidasLeche))/9; //Gramos totales de leche en media mañana
                $proteinaLecheCena = (($proteinasCena * 4) * ($caloriasLecheTotal/$cantComidasLeche))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoLeche, $carbohidratoLecheCena, $lipidoLecheCena, $proteinaLecheCena);

                $lecheCena = array_merge($lecheCena, $resultados['alimentosRecomendados']);
            }

            $lecheRecomendadas = array_merge(
                $lecheDesayuno,
                $lecheMediaManiana,
                $lecheAlmuerzo,
                $lecheMerienda,
                $lecheCena,
            );

        }

        //Yogur
        $yogurRecomendadas = [];
        $caloriasYogurTotal = $porcentajeLecheYogurQueso / 3;

        $cantComidasYogur = $cantComidas['comidasYogures'] ?? 0; //Si no existe comidasYogur en el arreglo se asigna automáticamente 0

        if($cantComidasYogur > 0){

            $alimentosDesayunoRecomendadosYogur = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $yogurDesayuno = [];

            if($alimentosDesayunoRecomendadosYogur > 0){
                //Yogur por comida y por macronutriente
                $carbohidratoYogurDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en desayuno
                $lipidoYogurDesayuno = (($lipidosDesayuno * 9) * ($caloriasYogurTotal/$cantComidasYogur))/9; //Gramos totales de yogur en desayuno
                $proteinaYogurDesayuno = (($proteinasDesayuno * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoYogur, $carbohidratoYogurDesayuno, $lipidoYogurDesayuno, $proteinaYogurDesayuno);

                $yogurDesayuno = array_merge($yogurDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosYogur = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $yogurMediaManiana = [];

            if($alimentosMediaManianaRecomendadosYogur > 0){
                $carbohidratoYogurMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en media mañana
                $lipidoYogurMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasYogurTotal/$cantComidasYogur))/9; //Gramos totales de yogur en media mañana
                $proteinaYogurMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoYogur, $carbohidratoYogurMediaManiana, $lipidoYogurMediaManiana, $proteinaYogurMediaManiana);

                $yogurMediaManiana = array_merge($yogurMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosYogur = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $yogurAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosYogur > 0){
                $carbohidratoYogurAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de leche en media mañana
                $lipidoYogurAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasYogurTotal/$cantComidasYogur))/9; //Gramos totales de leche en media mañana
                $proteinaYogurAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoYogur, $carbohidratoYogurAlmuerzo, $lipidoYogurAlmuerzo, $proteinaYogurAlmuerzo);

                $yogurAlmuerzo = array_merge($yogurAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosYogur = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $yogurMerienda = [];

            if($alimentosMeriendaRecomendadosYogur > 0){
                $carbohidratoYogurMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en media mañana
                $lipidoYogurMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasYogurTotal/$cantComidasYogur))/9; //Gramos totales de yogur en media mañana
                $proteinaYogurMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de yogur en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoYogur, $carbohidratoYogurMediaTarde, $lipidoYogurMediaTarde, $proteinaYogurMediaTarde);

                $yogurMerienda = array_merge($yogurMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosYogur = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $yogurCena = [];

            if($alimentosCenaRecomendadosYogur > 0){
                $carbohidratoYogurCena = (($carbohidratosCena * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de leche en media mañana
                $lipidoYogurCena = (($lipidosCena * 9) * ($caloriasYogurTotal/$cantComidasYogur))/9; //Gramos totales de leche en media mañana
                $proteinaYogurCena = (($proteinasCena * 4) * ($caloriasYogurTotal/$cantComidasYogur))/4; //Gramos totales de leche en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoYogur, $carbohidratoYogurCena, $lipidoYogurCena, $proteinaYogurCena);

                $yogurCena = array_merge($yogurCena, $resultados['alimentosRecomendados']);
            }

            $yogurRecomendadas = array_merge(
                $yogurDesayuno,
                $yogurMediaManiana,
                $yogurAlmuerzo,
                $yogurMerienda,
                $yogurCena,
            );
        }

        //Quesos
        $quesoRecomendadas = [];
        $caloriasQuesoTotal= $porcentajeLecheYogurQueso /3;

        $cantComidasQueso = $cantComidas['comidasQuesos'] ?? 0; //Si no existe comidasQueso en el arreglo se asigna automáticamente 0

        if($cantComidasQueso > 0){

            $alimentosDesayunoRecomendadosQueso = AlimentosRecomendadosPorDieta::where('comida_id', $comidaDesayuno->id)->count();
            $quesoDesayuno = [];

            if($alimentosDesayunoRecomendadosQueso > 0){
                //Queso por comida y por macronutriente
                $carbohidratoQuesoDesayuno = (($carbohidratosDesayuno * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en desayuno
                $lipidoQuesoDesayuno = (($lipidosDesayuno * 9) * ($caloriasQuesoTotal/$cantComidasQueso))/9; //Gramos totales de queso en desayuno
                $proteinaQuesoDesayuno = (($proteinasDesayuno * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en desayuno

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaDesayuno, $grupoAlimentoQueso, $carbohidratoQuesoDesayuno, $lipidoQuesoDesayuno, $proteinaQuesoDesayuno);

                $quesoDesayuno = array_merge($quesoDesayuno, $resultados['alimentosRecomendados']);

            }

            $alimentosMediaManianaRecomendadosQueso = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMediaManiana->id)->count();
            $quesoMediaManiana = [];

            if($alimentosMediaManianaRecomendadosQueso > 0){
                $carbohidratoQuesoMediaManiana = (($carbohidratosMediaManiana * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana
                $lipidoQuesoMediaManiana = (($lipidosMediaManiana * 9) * ($caloriasQuesoTotal/$cantComidasQueso))/9; //Gramos totales de queso en media mañana
                $proteinaQuesoMediaManiana = (($proteinasMediaManiana * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMediaManiana, $grupoAlimentoQueso, $carbohidratoQuesoMediaManiana, $lipidoQuesoMediaManiana, $proteinaQuesoMediaManiana);

                $quesoMediaManiana = array_merge($quesoMediaManiana, $resultados['alimentosRecomendados']);

            }

            $alimentosAlmuerzoRecomendadosQueso = AlimentosRecomendadosPorDieta::where('comida_id', $comidaAlmuerzo->id)->count();
            $quesoAlmuerzo = [];

            if($alimentosAlmuerzoRecomendadosQueso > 0){
                $carbohidratoQuesoAlmuerzo = (($carbohidratosAlmuerzo * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana
                $lipidoQuesoAlmuerzo = (($lipidosAlmuerzo * 9) * ($caloriasQuesoTotal/$cantComidasQueso))/9; //Gramos totales de queso en media mañana
                $proteinaQuesoAlmuerzo = (($proteinasAlmuerzo * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaAlmuerzo, $grupoAlimentoQueso, $carbohidratoQuesoAlmuerzo, $lipidoQuesoAlmuerzo, $proteinaQuesoAlmuerzo);

                $quesoAlmuerzo = array_merge($quesoAlmuerzo, $resultados['alimentosRecomendados']);

            }

            $alimentosMeriendaRecomendadosQueso = AlimentosRecomendadosPorDieta::where('comida_id', $comidaMerienda->id)->count();
            $quesoMerienda = [];

            if($alimentosMeriendaRecomendadosQueso > 0){
                $carbohidratoQuesoMediaTarde = (($carbohidratosMediaTarde * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana
                $lipidoQuesoMediaTarde = (($lipidosMediaTarde * 9) * ($caloriasQuesoTotal/$cantComidasQueso))/9; //Gramos totales de queso en media mañana
                $proteinaQuesoMediaTarde = (($proteinasMediaTarde * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaMerienda, $grupoAlimentoQueso, $carbohidratoQuesoMediaTarde, $lipidoQuesoMediaTarde, $proteinaQuesoMediaTarde);

                $quesoMerienda = array_merge($quesoMerienda, $resultados['alimentosRecomendados']);
            }

            $alimentosCenaRecomendadosQueso = AlimentosRecomendadosPorDieta::where('comida_id', $comidaCena->id)->count();
            $quesoCena = [];

            if($alimentosCenaRecomendadosQueso > 0){
                $carbohidratoQuesoCena = (($carbohidratosCena * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana
                $lipidoQuesoCena = (($lipidosCena * 9) * ($caloriasQuesoTotal/$cantComidasQueso))/9; //Gramos totales de queso en media mañana
                $proteinaQuesoCena = (($proteinasCena * 4) * ($caloriasQuesoTotal/$cantComidasQueso))/4; //Gramos totales de queso en media mañana

                $resultados = $this->obtenerAlimentosRecomendadosPorComida($historiaClinica->id, $tipoDieta->id, $comidaCena, $grupoAlimentoQueso, $carbohidratoQuesoCena, $lipidoQuesoCena, $proteinaQuesoCena);

                $quesoCena = array_merge($quesoCena, $resultados['alimentosRecomendados']);
            }

            $quesoRecomendadas = array_merge(
                $quesoDesayuno,
                $quesoMediaManiana,
                $quesoAlmuerzo,
                $quesoMerienda,
                $quesoCena,
            );

        }




        return [
            'frutasRecomendadas' => $frutasRecomendadas,
            'verdurasRecomendadas' => $verdurasRecomendadas,
            'legumbresRecomendadas' => $legumbresRecomendadas,
            'lecheRecomendadas' => $lecheRecomendadas,
            'yogurRecomendadas' => $yogurRecomendadas,
            'quesoRecomendadas' => $quesoRecomendadas,
        ];
    }

    public function obtenerCantidadComidasPorAlimento($tipoDietaId)
    {
        $tipoDieta = TiposDeDieta::find($tipoDietaId);

        if ($tipoDieta) {
            $alimentosPorDieta = AlimentoPorTipoDeDieta::where('tipo_de_dieta_id', $tipoDieta->id)->get();
            $alimentosrecomendadosPorDieta = AlimentosRecomendadosPorDieta::all();

            $gruposAlimentos = [
                'Frutas', 'Verduras', 'Legumbres, cereales, papa, choclo, batata, pan y pastas',
                'Leche y postres de leche', 'Yogures', 'Quesos', 'Carnes', 'Huevos', 'Pescados y mariscos',
                'Aceites', 'Frutas secas y semillas', 'Azúcares, mermeladas y dulces', 'Golosinas y chocolates'
            ];

            $resultados = [];

            foreach ($gruposAlimentos as $grupo) {
                $grupoAlimento = GrupoAlimento::where('grupo', $grupo)->first();

                $claveGrupo = str_replace([' ', ',', 'ñ'], ['', '', 'n'], $grupo);

                $alimentosRecomendados = Alimento::where('grupo_alimento_id', $grupoAlimento->id)
                    ->whereIn('id', $alimentosPorDieta->pluck('alimento_id'))
                    ->get();

                $cantComidas = $this->contarComidasRecomendadas($alimentosPorDieta, $alimentosrecomendadosPorDieta, $alimentosRecomendados);

                $resultados["comidas$claveGrupo"] = $cantComidas;
            }

            return $resultados;
        }
    }


    private function contarComidasRecomendadas($alimentosPorDieta, $alimentosrecomendadosPorDieta, $alimentosRecomendados)
    {
        $cantComidas = 0;
        $comidasContadas = collect([]);

        foreach ($alimentosrecomendadosPorDieta as $alimentoRecomendado) {
            foreach($alimentosPorDieta as $alimentoDieta){
                foreach ($alimentosRecomendados as $alimento) {
                    if ($alimentoRecomendado->alimento_por_dieta_id === $alimentoDieta->id && $alimentoDieta->alimento_id === $alimento->id) {
                        $comidaId = $alimentoRecomendado->comida_id;
                        if (!$comidasContadas->contains($comidaId)) {
                            $comidasContadas->push($comidaId);
                            $cantComidas++;
                            break; // Salir del bucle si una comida se cuenta
                        }
                    }
                }
            }

        }

        return $cantComidas;
    }

    public function obtenerAlimentosRecomendadosPorComida($historiaClinicaId, $tipoDietaId, $comida, $grupoAlimento, $carbohidratosTotales, $lipidosTotales, $proteinasTotales) {

        $historiaClinica = HistoriaClinica::find($historiaClinicaId);
        //Obtenemos datos necesarios
        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();
        $cirugias = Cirugia::all();

        $alimentosProhibidosAlergias = AlimentosProhibidosAlergia::all();
        $alimentosProhibidosPatologias = AlimentosProhibidosPatologia::all();
        $alimentosProhibidosIntolerancias = AlimentosProhibidosIntolerancia::all();

        //Buscamos datos médicos del paciente
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();
        //Cirugías del paciente
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();
        //Anamnesis alimentaria del paciente
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->get();

        $tipoDieta = TiposDeDieta::find($tipoDietaId);
        $alimentosPorDieta = AlimentoPorTipoDeDieta::where('tipo_de_dieta_id', $tipoDieta->id)->get();
        $valoresNutricionales = ValorNutricional::all();
        $nutrientes = Nutriente::all();
        $unidadesMedidas = UnidadesMedidasPorComida::all();
        $alimentosBuscados = Alimento::where('grupo_alimento_id', $grupoAlimento->id)->get();

        $alimentosProhibidos = [];

         foreach($datosMedicos as $datoMedico){
            foreach($alergias as $alergia){
                foreach($alimentosProhibidosAlergias as $prohibido){
                    if($datoMedico->alergia_id == $alergia->id && $alergia->id == $prohibido->alergia_id){
                        $alimentosProhibidos[] = $prohibido->alimento_id;
                    }
                }
            }

            foreach($patologias as $patologia){
                foreach($alimentosProhibidosPatologias as $prohibido){
                    if($datoMedico->patologia_id == $patologia->id && $patologia->id == $prohibido->patologia_id){
                        $alimentosProhibidos[] = $prohibido->alimento_id;
                    }
                }
            }
             foreach($intolerancias as $intolerancia){
                foreach($alimentosProhibidosIntolerancias as $prohibido){
                    if($datoMedico->intolerancia_id == $intolerancia->id && $intolerancia->id == $prohibido->intolerancia_id){
                        $alimentosProhibidos[] = $prohibido->alimento_id;
                    }
                }
            }
        }

        $alimentosRecomendadosComida = [];
        $alimentosRecomendadosPorDieta = AlimentosRecomendadosPorDieta::where('comida_id', $comida->id)->get();

        foreach ($alimentosRecomendadosPorDieta as $alimentoRecomendado) {
            foreach ($alimentosPorDieta as $alimentoDieta) {
                if ($alimentoDieta->id == $alimentoRecomendado->alimento_por_dieta_id) {
                    foreach ($alimentosBuscados as $alimento) {
                        if ($alimento->id == $alimentoDieta->alimento_id) {
                            foreach($alimentosProhibidos as $prohibido){
                                if($prohibido != $alimentoDieta->alimento_id){
                                    foreach ($valoresNutricionales as $valorN) {
                                        foreach ($nutrientes as $nutriente) {
                                            foreach ($unidadesMedidas as $unidad) {
                                                if ($alimentoRecomendado->unidad_medida_id == $unidad->id) {
                                                    $valor = $valorN->valor;

                                                    if ($unidad->nombre_unidad_medida == 'Gramos') {
                                                        $cantidad = $alimentoRecomendado->cantidad;
                                                    } elseif ($unidad->nombre_unidad_medida == 'Kcal') {
                                                        if ($nutriente->nombre_nutriente === 'Carbohidratos totales') {
                                                            $cantidad = $alimentoRecomendado->cantidad / 4;
                                                        } elseif ($nutriente->nombre_nutriente === 'Proteínas') {
                                                            $cantidad = $alimentoRecomendado->cantidad / 4;
                                                        } elseif ($nutriente->nombre_nutriente === 'Lípidos totales') {
                                                            $cantidad = $alimentoRecomendado->cantidad / 9;
                                                            //$valor = $valor / 100;
                                                        }
                                                    }

                                                    if($nutriente->nombre_nutriente == 'Carbohidratos totales' && $valorN->nutriente_id == $nutriente->id){
                                                        $total = ($valor * $cantidad) / 100;
                                                        if ($total < $carbohidratosTotales && $carbohidratosTotales > 0){
                                                            if (!in_array($alimentoDieta->id, $alimentosRecomendadosComida, true)) {
                                                                $alimentosRecomendadosComida[] = $alimentoDieta->id;
                                                            }
                                                            $carbohidratosTotales -= $total;
                                                        }
                                                    } elseif ($nutriente->nombre_nutriente == 'Lípidos totales' && $valorN->nutriente_id == $nutriente->id){
                                                        $total = ($valor * $cantidad) / 100;
                                                        if ($total < $lipidosTotales && $lipidosTotales > 0){
                                                            if (!in_array($alimentoDieta->id, $alimentosRecomendadosComida, true)) {
                                                                $alimentosRecomendadosComida[] = $alimentoDieta->id;
                                                            }
                                                            $lipidosTotales -= $total;
                                                        }
                                                    } elseif ($nutriente->nombre_nutriente == 'Proteínas' && $valorN->nutriente_id == $nutriente->id){
                                                        $total = ($valor * $cantidad) / 100;
                                                        if ($total < $proteinasTotales && $proteinasTotales > 0){
                                                            if (!in_array($alimentoDieta->id, $alimentosRecomendadosComida, true)) {
                                                                $alimentosRecomendadosComida[] = $alimentoDieta->id;
                                                            }
                                                            $proteinasTotales -= $total;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }

        return [
            'alimentosRecomendados' => $alimentosRecomendadosComida,
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
                $diagnostico .= 'Bajo peso. ';
                $pesoIdeal = 18.5 * ($alturaMetro * $alturaMetro); //Bajo peso
            }else if($imc >= 18.5 && $imc <= 24.99){
                $diagnostico .= 'Peso saludable. ';
                $pesoIdeal = $pesoActual; //Peso normal
            }else if($imc >= 25 && $imc <= 29.99){
                $diagnostico .= 'Sobrepeso. ';
                $pesoIdeal = 25 * ($alturaMetro * $alturaMetro); //Sobrepeso
            }else if($imc >= 30 && $imc <= 34.99){
                $diagnostico .= 'Obesidad de grado 1. ';
                $pesoIdeal = 30 * ($alturaMetro * $alturaMetro); //Obesidad grado 1
            }else if($imc >= 35 && $imc <= 39.99){
                $diagnostico .= 'Obesidad de grado 2. ';
                $pesoIdeal = 35 * ($alturaMetro * $alturaMetro); //Obesidad grado 2
            }else if($imc >= 40){
                $diagnostico .= 'Obesidad mórbida. ';
                $pesoIdeal = 40 * ($alturaMetro * $alturaMetro); //Obesidad grado 3 o mórbida
            }
        }

        return [
            'imc' => $imc,
            'pesoIdeal' => $pesoIdeal,
            'diagnosticoIMC' => $diagnostico,
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
                $diagnostico .= 'Porcentaje de grasa moderado (requiere seguimiento). ';
            } elseif ($masaGrasa > 30) {
                $diagnostico .= 'Porcentaje de grasa elevado (requiere atención). ';
            }
        }

        if (in_array('masa_osea', $calculosSeleccionados)) {
            if ($masaOsea < 2) {
                $diagnostico .= 'Masa ósea baja (riesgo osteoporosis). ';
            } elseif ($masaOsea >= 2 && $masaOsea <= 2.5) {
                $diagnostico .= 'Masa ósea normal. ';
            } elseif ($masaOsea > 2.5) {
                $diagnostico .= 'Masa ósea alta (positivo). ';
            }
        }

        if (in_array('masa_residual', $calculosSeleccionados)) {
            if ($masaResidual < 5) {
                $diagnostico .= 'Masa residual baja (ver posible causa). ';
            } elseif ($masaResidual >= 5 && $masaResidual <= 10) {
                $diagnostico .= 'Masa residual normal. ';
            } elseif ($masaResidual > 10) {
                $diagnostico .= 'Masa residual alta (posible retención de líquidos). ';
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
