<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\HistoriaClinica;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use Illuminate\Http\Request;

class DatosMedicosController extends Controller
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
    public function store(Request $request)
    {

        //Anamnesis alimentaria
        $alimentosGustos = $request->input('alimentos_gustos');
        $alimentosNoGustos = $request->input('alimentos_no_gustos');

        //Alergias
        $alergias = $request->input('alergias');

        //Cirugías
        $cirugias = $request->input('cirugias');
        $tiempo = $request->input('tiempo');
        $unidad = $request->input('unidad');

        //Patologías
        $patologias = $request->input('patologias');

        //Intolerancias
        $intolerancias = $request->input('intolerancias');

        //Verificamos si ya existen estos datos
        $anamnesisExistente = false;
        $alergiasExistente = false;
        $cirugiasExistente = false;
        $patologiasExistente = false;
        $intoleranciasExistente = false;

        //Obtenemos id de HC y Paciente
        $paciente = Paciente::where('user_id', auth()->id())->first();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Verificamos si existe ya la historia clínica para el paciente
        if(!$historiaClinica){
            //Si no existe se crea
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
            ]);
        }

        //Si no se ingresaron datos en el form, crea las tablas correspondientes con valores vacíos (ya sea si son numéricos o string)
        if(!$alimentosGustos){
            $alimentosGustos = [''];
        }
        if(!$alimentosNoGustos){
            $alimentosNoGustos = [''];
        }
        if(!$alergias){
            $alergias = [''];
        }
        if(!$cirugias){
            $cirugias = [''];
        }
        if(!$tiempo){
            $tiempo = [0];
        }
        if(!$unidad){
            $unidad = [''];
        }
        if(!$patologias){
            $patologias = [''];
        }
        if(!$intolerancias){
            $intolerancias = [''];
        }


        //Verificación de anamnesis
        foreach ($alimentosGustos as $alimentoGusto) {
            foreach($alimentosNoGustos as $alimentoNoGusto){
                $anamnesisExistente = AnamnesisAlimentaria::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                        ['alimentos_que_gustan', $alimentoGusto],
                        ['alimentos_que_no_gustan', $alimentoNoGusto],
                    ]
                )->first();

                if(!$anamnesisExistente){
                    //Si no existe se crea
                    AnamnesisAlimentaria::create([
                        'historia_clinica_id' => $historiaClinica->id,
                        'alimentos_que_gustan' => $alimentoGusto,
                        'alimentos_que_no_gustan' => $alimentoNoGusto,
                    ]);
                }else{
                    break;
                }
            }
        }
        if($anamnesisExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Anamnesis ya registrada');
        }

        //Verificación de alergias
        foreach ($alergias as $alergia) {
            $alergiasExistente = Alergia::where(
                [
                    ['historia_clinica_id', $historiaClinica->id],
                    ['alergia', $alergia],
                ]
            )->first();

            if(!$alergiasExistente){
                //Si no existe se crea
                Alergia::create([
                    'historia_clinica_id' => $historiaClinica->id,
                    'alergia' => $alergia,
                ]);
            }else{
                break;
            }
        }
        if($alergiasExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Alergias ya registradas');
        }

        //Verificación de cirugias
        foreach ($cirugias as $cirugia) {
            foreach($tiempo as $tiempoCirugia){
                foreach($unidad as $unidadCirugia){
                    $cirugiasExistente = Cirugia::where(
                        [
                            ['historia_clinica_id', $historiaClinica->id],
                            ['cirugia', $cirugia],
                            ['tiempo', $tiempoCirugia],
                            ['unidad', $unidadCirugia],
                        ]
                    )->first();

                    if(!$cirugiasExistente){
                        //Si no existe se crea
                        Cirugia::create([
                            'historia_clinica_id' => $historiaClinica->id,
                            'cirugia' => $cirugia,
                            'tiempo' => $tiempoCirugia,
                            'unidad' => $unidadCirugia,
                        ]);
                    }else{
                        break;
                    }
                }
            }
        }

        if($cirugiasExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Cirugías ya registradas');
        }

        //Verificación de patologias
        foreach ($patologias as $patologia) {
            $patologiasExistente = Patologia::where(
                [
                    ['historia_clinica_id', $historiaClinica->id],
                    ['patologia', $patologia],
                ]
            )->first();

            if(!$patologiasExistente){
                //Si no existe se crea
                Patologia::create([
                    'historia_clinica_id' => $historiaClinica->id,
                    'patologia' => $patologia,
                ]);
            }else{
                break;
            }
        }

        if($patologiasExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Patologías ya registradas');
        }

        //Verificación de intolerancias

        foreach ($intolerancias as $intolerancia) {
            $intoleranciasExistente = Intolerancia::where(
                [
                    ['historia_clinica_id', $historiaClinica->id],
                    ['intolerancia', $intolerancia],
                ]
            )->first();

            if(!$intoleranciasExistente){
                //Si no existe se crea
                Intolerancia::create([
                    'historia_clinica_id' => $historiaClinica->id,
                    'intolerancia' => $intolerancia,
                ]);
            }else{
                break;
            }
        }

        if($intoleranciasExistente){
            return redirect()->route('gestion-atencion.index')->with('error', 'Intolerancias ya registradas');
        }

        return redirect()->route('gestion-atencion.index')->with('success', 'Datos médicos registrados correctamente');
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
