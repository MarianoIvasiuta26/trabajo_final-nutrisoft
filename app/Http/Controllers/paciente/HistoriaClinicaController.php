<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Consulta;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use App\Models\Nutricionista;
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
use App\Models\TipoConsulta;
use App\Models\Turno;
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
        $adelantamientos = AdelantamientoTurno::where('paciente_id', $paciente->id)->get();
        $alimentos = Alimento::all();
        $turnos = Turno::all();
        $consultas = Consulta::all();
        $tipo_consultas = TipoConsulta::all();
        $profesionales = Nutricionista::all();
        $horarios = HorariosAtencion::all();
        $cirugias = Cirugia::all();

        if($historiaClinica && $datosMedicos){
            $alergias = Alergia::where('id', $datosMedicos->alergia_id)->get();
            $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();

            $intolerancias = Intolerancia::where('id', $datosMedicos->intolerancia_id)->get();
            $patologias = Patologia::where('id', $datosMedicos->patologia_id)->get();
            $anamnesisAlimentaria = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->get();

            return view('paciente.historia-clinica.index', compact('paciente', 'historiaClinica', 'datosMedicos', 'adelantamientos', 'anamnesisAlimentaria', 'alimentos', 'alergias', 'cirugiasPaciente', 'cirugias', 'intolerancias', 'patologias', 'turnos', 'consultas', 'tipo_consultas', 'profesionales', 'horarios'));
        }

        return view('paciente.historia-clinica.index', compact('paciente', 'historiaClinica', 'adelantamientos','alimentos', 'cirugias', 'turnos', 'consultas', 'tipo_consultas', 'profesionales', 'horarios'));
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
        $profesionales = Nutricionista::all();
        //Obtener paciente autenticado
        $paciente = Paciente::where('user_id', auth()->user()->id)->first();
        // Verificar si el formulario se ha completado
        $formularioCompletado = false;
        if (session('dni') && session('telefono') && session('sexo') && session('fecha_nacimiento')) {
            $formularioCompletado = true;
        }

        $hc = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        if($hc){
            $datosMedicos = DatosMedicos::where('historia_clinica_id', $paciente->historiaClinica->id)->get();
            $anamnesis = AnamnesisAlimentaria::where('historia_clinica_id', $paciente->historiaClinica->id)->get();
            $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $paciente->historiaClinica->id)->get();
            $adelantamientoTurnos = AdelantamientoTurno::where('paciente_id', $paciente->id)->get();

            return view('paciente.historia-clinica.create', compact('dias', 'horarios', 'patologias', 'alergias', 'cirugias', 'intolerancias', 'alimentos', 'profesionales', 'formularioCompletado', 'paciente', 'datosMedicos', 'anamnesis', 'cirugiasPaciente', 'adelantamientoTurnos'));
        }


        return view('paciente.historia-clinica.create', compact('dias', 'horarios', 'patologias', 'alergias', 'cirugias', 'intolerancias', 'alimentos', 'profesionales', 'formularioCompletado', 'paciente'));
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

        //Obtenemos los input
        $peso = $request->input('peso');
        $altura = $request->input('altura');
        $circ_munieca = $request->input('circ_munieca') ?? 0.00;
        $circ_cadera = $request->input('circ_cadera') ?? 0.00;
        $circ_cintura = $request->input('circ_cintura') ?? 0.00;
        $circ_pecho = $request->input('circ_pecho') ?? 0.00;

        if (!$historiaClinica) {
            // Si no existe un registro, crear uno nuevo con los datos proporcionados o valores predeterminados
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => $peso,
                'altura' => $altura,
                'circunferencia_munieca' =>  $circ_munieca,
                'circunferencia_cadera' => $circ_cadera,
                'circunferencia_cintura' => $circ_cintura,
                'circunferencia_pecho' => $circ_pecho,
                'estilo_vida' => $request->input('estilo_vida'),
                'objetivo_salud' => $request->input('objetivo_salud'),
            ]);
        }else{
            $historiaClinica->update([
                'paciente_id' => $paciente->id,
                'peso' => $request->input('peso', 0),
                'altura' => $request->input('altura', 0),
                'circunferencia_munieca' => $circ_munieca,
                'circunferencia_cadera' => $circ_cadera,
                'circunferencia_cintura' => $circ_cintura,
                'circunferencia_pecho' => $circ_pecho,
                'estilo_vida' => $request->input('estilo_vida'),
                'objetivo_salud' => $request->input('objetivo_salud'),
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

        session()->put('datos_fisicos', true);

        //return redirect()->route('historia-clinica.create')->with('success', 'Datos físicos registrados');
        return response()
        ->json(array('success' => true, 'datos_corporales' => true, 'message' => 'Datos corporales registrados'));
    }

    public function completarHistoriaClinica()
    {
        $paciente = Paciente::where('user_id', auth()->id())->first();

        // Verificamos si el paciente ya tiene la historia clínica completa
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        if(!$historiaClinica){
            return redirect()->back()->with('error', 'Error al completar su historia clínica. Inténtelo de nuevo.');
        }

        //Obtenemos los datos médicos de la historia clínica
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();

        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->first();

        if(!$datosMedicos || !$anamnesisPaciente || !$cirugiasPaciente){
            return redirect()->back()->with('error', 'Error al completar su historia clínica. Inténtelo de nuevo.');
        }

        $historiaClinica->completado = 1;
        $historiaClinica->save();

        return redirect()->route('historia-clinica.index')->with('success', 'Historia clínica completada. Ya puede acceder a las funcionalidades del sistema.');
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
