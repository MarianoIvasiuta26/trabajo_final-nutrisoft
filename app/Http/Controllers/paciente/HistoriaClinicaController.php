<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\Paciente;
use App\Models\Paciente\AdelantamientoTurno;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
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
        $paciente = Paciente::where('user_id', auth()->id())->first();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        if(!$historiaClinica){
            return view('paciente.historia-clinica.index')->with('info', 'No se ha registrado la historia clínica');
        }
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();
        $alergias = Alergia::where('id', $datosMedicos->alergia_id)->get();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();
        $cirugias = Cirugia::all();
        $intolerancias = Intolerancia::where('id', $datosMedicos->intolerancia_id)->get();
        $patologias = Patologia::where('id', $datosMedicos->patologia_id)->get();
        $adelantamientos = AdelantamientoTurno::where('paciente_id', $paciente->id)->get();
        $anamnesisAlimentaria = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->get();
        $alimentos = Alimento::all();
        return view('paciente.historia-clinica.index', compact('paciente', 'historiaClinica', 'datosMedicos', 'adelantamientos', 'anamnesisAlimentaria', 'alimentos', 'alergias', 'cirugiasPaciente', 'cirugias', 'intolerancias', 'patologias'));
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

        // Datos físicos
        $request->validate([
            'peso' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'altura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_munieca' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cadera' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cintura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_pecho' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'estilo_vida' => ['required', 'string', 'max:25'],
            'objetivo_salud' => ['required', 'string', 'max:25'],
        ]);

        $paciente = Paciente::where('user_id', auth()->id())->first();

        // Verificamos si el paciente ya tiene la historia clínica completa
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        if (!$historiaClinica) {
            // Si no existe un registro, crear uno nuevo con los datos proporcionados o valores predeterminados
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => $request->input('peso', 0),
                'altura' => $request->input('altura', 0),
                'circunferencia_munieca' => $request->input('circunferencia_munieca', 0),
                'circunferencia_cadera' => $request->input('circunferencia_cadera', 0),
                'circunferencia_cintura' => $request->input('circunferencia_cintura', 0),
                'circunferencia_pecho' => $request->input('circunferencia_pecho', 0),
                'estilo_vida' => $request->input('estilo_vida', ''),
                'objetivo_salud' => $request->input('objetivo_salud', ''),
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
        // Actualizamos o creamos los datos físicos con los valores proporcionados o valores predeterminados
        $historiaClinica->update([
            'peso' => $request->input('peso', 0),
            'altura' => $request->input('altura', 0),
            'circunferencia_munieca' => $request->input('circunferencia_munieca', 0),
            'circunferencia_cadera' => $request->input('circunferencia_cadera', 0),
            'circunferencia_cintura' => $request->input('circunferencia_cintura', 0),
            'circunferencia_pecho' => $request->input('circunferencia_pecho', 0),
            'estilo_vida' => $request->input('estilo_vida', ''),
            'objetivo_salud' => $request->input('objetivo_salud', ''),
        ]);

        return redirect()->route('historia-clinica.create')->with('success', 'Datos personales registrados');
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
        $historiaClinica = HistoriaClinica::find($id);
        return view('paciente.historia-clinica.edit')->with('historiaClinica', $historiaClinica);
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
            'peso' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'altura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_munieca' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cadera' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_cintura' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'circunferencia_pecho' => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'estilo_vida' => ['required', 'string', 'max:25'],
            'objetivo_salud' => ['required', 'string', 'max:25'],
        ]);

        $historiaClinica = HistoriaClinica::find($id);

        if($historiaClinica){
            $historiaClinica->peso = $request->input('peso');
            $historiaClinica->altura = $request->input('altura');
            $historiaClinica->circunferencia_munieca = $request->input('circunferencia_munieca');
            $historiaClinica->circunferencia_cadera = $request->input('circunferencia_cadera');
            $historiaClinica->circunferencia_cintura = $request->input('circunferencia_cintura');
            $historiaClinica->circunferencia_pecho = $request->input('circunferencia_pecho');
            $historiaClinica->estilo_vida = $request->input('estilo_vida');
            $historiaClinica->objetivo_salud = $request->input('objetivo_salud');

            $historiaClinica->save();

            return redirect()->route('historia-clinica.index')->with('success', 'Datos personales actualizados');
        }else{
            return redirect()->route('historia-clinica.index')->with('error', 'No se ha encontrado la historia clínica');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
