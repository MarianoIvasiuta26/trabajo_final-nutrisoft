<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\DetallePlanAlimentaciones;
use App\Models\DetallesPlanesSeguimiento;
use App\Models\Nutriente;
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

        $fechaHoy = Carbon::now();

        //Alimentos consumidos
        $alimentosConsumidos = RegistroAlimentosConsumidos::where('plan_de_seguimiento_id', $planSeguimientoActivo->id)
            ->where('paciente_id', auth()->user()->paciente->id)
            ->where('fecha_consumida', $fechaHoy)
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

        return view('paciente.mi-seguimiento.index', compact('planAlimentacionActivo', 'planSeguimientoActivo', 'planesAlimentacionPaciente',
            'planesSeguimientoPaciente', 'pesoIdeal', 'diagnostico', 'estadoIMC', 'fechas', 'pesos',
            'alimentosConsumidos', 'kcal', 'alimentos', 'detallesPlanAlimentacionActivo', 'unidades_de_medida')
        );
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
