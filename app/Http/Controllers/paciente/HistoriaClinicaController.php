<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\Paciente;
use App\Models\Paciente\AdelantamientoTurno;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\HistoriaClinica;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoriaClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paciente.historia-clinica.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dias = DiasAtencion::all();
        $horarios = HorariosAtencion::all();
        $patologias = Patologia::all();
        $alergias = Alergia::all();
        $cirugias = Cirugia::all();
        $intolerancias = Intolerancia::all();
        $alimentos = Alimento::all();
        return view('paciente.historia-clinica.create', compact('dias', 'horarios', 'patologias', 'alergias', 'cirugias', 'intolerancias', 'alimentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //Datos físicos
        $request->validate([
            'peso' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'altura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_munieca' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cadera' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cintura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_pecho' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'estilo_vida' => ['string', 'max:25'],
            'objetivo_salud' => ['string', 'max:25'],
        ]);

        $peso = $request->input('peso');
        $altura = $request->input('altura');
        $circunferencia_munieca = $request->input('circunferencia_munieca');
        $circunferencia_cadera = $request->input('circunferencia_cadera');
        $circunferencia_cintura = $request->input('circunferencia_cintura');
        $circunferencia_pecho = $request->input('circunferencia_pecho');
        $estilo_vida = $request->input('estilo_vida');
        $objetivo_salud = $request->input('objetivo_salud');

        // Obtenemos el paciente autenticado
        $paciente = Paciente::where('user_id', auth()->id())->first();

        //Verificamos si el paciente ya tiene la historia clínica completa
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        if(!$historiaClinica){
            HistoriaClinica::create([
                'paciente_id' => $paciente->id,
            ]);
        }

        //Validamos si existen estos ya registrados
        $datosFisicos = HistoriaClinica::where([
            ['paciente_id', $paciente->id],
            ['peso', $peso],
            ['altura', $altura],
            ['circunferencia_munieca', $circunferencia_munieca],
            ['circunferencia_cadera', $circunferencia_cadera],
            ['circunferencia_cintura', $circunferencia_cintura],
            ['circunferencia_pecho', $circunferencia_pecho],
            ['estilo_vida', $estilo_vida],
            ['objetivo_salud', $objetivo_salud],
        ])->first();

        if(!$datosFisicos){
            HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => $peso,
                'altura' => $altura,
                'circunferencia_munieca' => $circunferencia_munieca,
                'circunferencia_cadera' => $circunferencia_cadera,
                'circunferencia_cintura' => $circunferencia_cintura,
                'circunferencia_pecho' => $circunferencia_pecho,
                'estilo_vida' => $estilo_vida,
                'objetivo_salud' => $objetivo_salud,
            ]);

            return redirect()->route('historia-clinica.create')->with('success', 'Datos personales registrados');
        } else {
            return redirect()->route('historia-clinica.create')->with('error', 'Ya existe la historia clínica para este paciente');
        }


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
