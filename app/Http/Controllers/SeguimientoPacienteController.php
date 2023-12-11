<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Consulta;
use App\Models\DetallePlanAlimentaciones;
use App\Models\DetallesPlanesSeguimiento;
use App\Models\Nutriente;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\PlanAlimentaciones;
use App\Models\PlanesDeSeguimiento;
use App\Models\RegistroAlimentosConsumidos;
use App\Models\UnidadesMedidasPorComida;
use App\Models\ValorNutricional;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeguimientoPacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $obtener = $this->obtenerDatos();
        $planAlimentacionActivo = $obtener['planAlimentacionActivo'];
        $planSeguimientoActivo = $obtener['planSeguimientoActivo'];
        $planesAlimentacionPaciente = $obtener['planesAlimentacionPaciente'];
        $planesSeguimientoPaciente = $obtener['planesSeguimientoPaciente'];
        $pesoIdeal = $obtener['pesoIdeal'];
        $diagnostico = $obtener['diagnostico'];
        $estadoIMC = $obtener['estadoIMC'];
        $fechas = $obtener['fechas'];
        $pesos = $obtener['pesos'];
        $alimentosConsumidos = $obtener['alimentosConsumidos'];
        $kcal = $obtener['kcal'];
        $alimentos = $obtener['alimentos'];
        $detallesPlanAlimentacionActivo = $obtener['detallesPlanAlimentacionActivo'];
        $unidades_de_medida = $obtener['unidades_de_medida'];
        $geb = $obtener['geb'];
        $get = $obtener['get'];

        return view('paciente.mi-seguimiento.index', compact(
                'planAlimentacionActivo',
                'planSeguimientoActivo',
                'planesAlimentacionPaciente',
                'planesSeguimientoPaciente',
                'pesoIdeal',
                'diagnostico',
                'estadoIMC',
                'fechas',
                'pesos',
                'alimentosConsumidos',
                'kcal',
                'alimentos',
                'detallesPlanAlimentacionActivo',
                'unidades_de_medida',
                'geb',
                'get',
            )
        );
    }

    private function obtenerDatos()
    {
        $planAlimentacionActivo = PlanAlimentaciones::where('paciente_id', auth()->user()->paciente->id)
        ->where('estado', 1)
        ->first();

        $planSeguimientoActivo = PlanesDeSeguimiento::where('paciente_id', auth()->user()->paciente->id)
        ->where('estado', 1)
        ->first();

        $planesAlimentacionPaciente = PlanAlimentaciones::where('paciente_id', auth()->user()->paciente->id)->get();
        $planesSeguimientoPaciente = PlanesDeSeguimiento::where('paciente_id', auth()->user()->paciente->id)->get();

        $resultado = $this->calcularIMC($planSeguimientoActivo->consulta->peso_actual, $planSeguimientoActivo->consulta->altura_actual);
        $diagnostico = $resultado['diagnosticoIMC'];

        $pesoIdeal = $resultado['pesoIdeal'];
        $estadoIMC = $resultado['estadoIMC'];

        // Inicializar arrays para almacenar las fechas y pesos para el gráfico
        $fechas = [];
        $pesos = [];

        // Recorrer los planes de seguimiento
        foreach ($planesSeguimientoPaciente as $plan) {
            // Obtener la consulta asociada al plan
            $consulta = $plan->consulta;

            // Agregar la fecha y peso a los arrays
            $fechas[] = $consulta->created_at->toDateString(); // Cambiar si necesitas otro formato
            $pesos[] = $consulta->peso_actual;
        }

        $fechaActual = now()->format('Y-m-d');

        //Alimentos consumidos
        $alimentosConsumidos = RegistroAlimentosConsumidos::where('plan_de_seguimiento_id', $planSeguimientoActivo->id)
            ->where('paciente_id', auth()->user()->paciente->id)
            ->where('fecha_consumida', $fechaActual)
            ->get();

        $kcal = 0;
        $nutriente = Nutriente::where('nombre_nutriente', 'Valor energético')->first();

        if($alimentosConsumidos){
            foreach($alimentosConsumidos as $alimentoConsumido){
                $alimento = Alimento::find($alimentoConsumido->alimento_id);
                $valorN = ValorNutricional::where('nutriente_id', $nutriente->id)->where('alimento_id', $alimento->id)->first();
                $kcal = $kcal + ($valorN * $alimentoConsumido->cantidad_consumida);

            }
        }else{
            $kcal = 0;
        }

        $alimentos = Alimento::all();
        $unidades_de_medida = UnidadesMedidasPorComida::all();
        $detallesPlanAlimentacionActivo = DetallePlanAlimentaciones::where('plan_alimentacion_id', $planAlimentacionActivo->id)->get();

        $paciente = Paciente::find(auth()->user()->paciente->id);
        $consulta = Consulta::find($planAlimentacionActivo->consulta_id);
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $alturaMetro = $consulta->altura_actual / 100;

        $resultadoGEB = $this->determinarGEB($paciente->edad, $paciente->sexo, $consulta->peso_Actual, $consulta->altura_actual, $alturaMetro);
        $resultadoGET = $this->determinacionGET($resultadoGEB['geb'], $historiaClinica->estilo_vida);

        $geb = $resultadoGEB['geb'];
        $get = $resultadoGET['get'];

        return [
            'planAlimentacionActivo' => $planAlimentacionActivo,
            'planSeguimientoActivo' => $planSeguimientoActivo,
            'planesAlimentacionPaciente' => $planesAlimentacionPaciente,
            'planesSeguimientoPaciente' => $planesSeguimientoPaciente,
            'pesoIdeal' => $pesoIdeal,
            'diagnostico' => $diagnostico,
            'estadoIMC' => $estadoIMC,
            'fechas' => $fechas,
            'pesos' => $pesos,
            'alimentosConsumidos' => $alimentosConsumidos,
            'kcal' => $kcal,
            'alimentos' => $alimentos,
            'detallesPlanAlimentacionActivo' => $detallesPlanAlimentacionActivo,
            'unidades_de_medida' => $unidades_de_medida,
            'geb' => $geb,
            'get' => $get,
        ];
    }

    public function calcularIMC($peso, $altura)
    {
        // Recopilamos los datos de la solicitud
        $pesoActual = floatval($peso);
        $alturaActual = floatval($altura);

        $imc = 0;
        $pesoIdeal = 0;
        //Generamos diagnóstico
        $diagnostico = '';
        $estadoIMC = '';

         //Calculamos el IMC
        if($pesoActual && $alturaActual){
            //Primero pasamos la altura de cm a m
            $alturaMetro = $alturaActual / 100;
            $imc = $pesoActual / ($alturaMetro * $alturaMetro);

            // Redondeamos el IMC a 2 decimales
            $imc = number_format($imc, 2, '.', ''); // Formato decimal(8,2)

            //Calculamos el peso ideal
            if($imc < 18.5){
                $diagnostico = 'Bajo peso';
                $estadoIMC = 'Bajo';
                $pesoIdeal = 18.5 * ($alturaMetro * $alturaMetro); //Bajo peso
            }else if($imc >= 18.5 && $imc <= 24.99){
                $diagnostico = 'Peso saludable';
                $estadoIMC = 'Normal';
                $pesoIdeal = $pesoActual; //Peso normal
            }else if($imc >= 25){
                $diagnostico = 'Peso alto';
                $estadoIMC = 'Alto';
                $pesoIdeal = 25 * ($alturaMetro * $alturaMetro); //Sobrepeso
            }
        }

        return [
            'estadoIMC' => $estadoIMC,
            'pesoIdeal' => $pesoIdeal,
            'diagnosticoIMC' => $diagnostico,
        ];

    }

    public function registrarConsumo(Request $request)
    {
        //Registro
        $alimentosPlan = $request->input('alimentosPlan');
        $otrosAlimentos = $request->input('alimentos');
        $cantidades = $request->input('cantidades');
        $unidades_de_medida = $request->input('unidades_de_medida');
        $kcal = 0;
        $nutriente = Nutriente::where('nombre_nutriente', 'Valor energético')->first();

        $obtener = $this->obtenerDatos();
        $planSeguimientoActivo = $obtener['planSeguimientoActivo'];

        if (!is_null($alimentosPlan) && count($alimentosPlan) > 0){
            foreach($alimentosPlan as $alimentoPlan){
                $detalle = DetallePlanAlimentaciones::find($alimentoPlan);
                $valorN = ValorNutricional::where('nutriente_id', $nutriente->id)->where('alimento_id', $detalle->alimento_id)->first();
                if($detalle->unidad_medida == 'Kcal'){
                    $kcal = $kcal + $detalle->cantidad;
                }
                $kcal = $kcal + ($valorN * $detalle->cantidad);
                $fechaActual = now()->format('Y-m-d');
                RegistroAlimentosConsumidos::create([
                    'plan_de_seguimiento_id' => $planSeguimientoActivo->id,
                    'paciente_id' => auth()->user()->paciente->id,
                    'alimento_id' => $detalle->alimento_id,
                    'cantidad' => $detalle->cantidad,
                    'kcal' => $kcal,
                    'fecha_consumida' => $fechaActual,
                    'unidad_medida' => $detalle->unidad_medida,
                ]);
            }
        }

        if (!is_null($otrosAlimentos) && count($otrosAlimentos) > 0){
            foreach($otrosAlimentos as $key => $otroAlimento){
                $alimento = Alimento::find($otroAlimento);
                $valorN = ValorNutricional::where('nutriente_id', $nutriente->id)->where('alimento_id', $alimento->id)->first();

                $unidad = UnidadesMedidasPorComida::find($unidades_de_medida[$key]);
                if($unidad->nombre_unidad_medida == 'Kcal'){
                    $kcal = $kcal + $cantidades[$key];
                }
                $kcal = $kcal + ($valorN * $cantidades[$key]);

                RegistroAlimentosConsumidos::create([
                    'plan_de_seguimiento_id' => $planSeguimientoActivo->id,
                    'paciente_id' => auth()->user()->paciente->id,
                    'alimento_id' => $alimento->id,
                    'cantidad' => $cantidades[$key],
                    'kcal' => $kcal,
                    'fecha_consumida' => Carbon::now(),
                    'unidad_medida' => $unidad->nombre_unidad_medida,
                ]);
            }
        }


        $planAlimentacionActivo = $obtener['planAlimentacionActivo'];
        $planesAlimentacionPaciente = $obtener['planesAlimentacionPaciente'];
        $planesSeguimientoPaciente = $obtener['planesSeguimientoPaciente'];
        $pesoIdeal = $obtener['pesoIdeal'];
        $diagnostico = $obtener['diagnostico'];
        $estadoIMC = $obtener['estadoIMC'];
        $fechas = $obtener['fechas'];
        $pesos = $obtener['pesos'];
        $alimentosConsumidos = $obtener['alimentosConsumidos'];
        $kcal = $obtener['kcal'];
        $alimentos = $obtener['alimentos'];
        $detallesPlanAlimentacionActivo = $obtener['detallesPlanAlimentacionActivo'];
        $unidades_de_medida = $obtener['unidades_de_medida'];
        $geb = $obtener['geb'];
        $get = $obtener['get'];

        return redirect()->route('mi-seguimiento.index', compact(
                'planAlimentacionActivo',
                'planSeguimientoActivo',
                'planesAlimentacionPaciente',
                'planesSeguimientoPaciente',
                'pesoIdeal',
                'diagnostico',
                'estadoIMC',
                'fechas',
                'pesos',
                'alimentosConsumidos',
                'kcal',
                'alimentos',
                'detallesPlanAlimentacionActivo',
                'unidades_de_medida',
                'geb',
                'get',
            )
        )->with('success', 'Alimentos consumidos registrados correctamente');
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
}
