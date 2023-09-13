<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\DatosMedicos;
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

    public function store(Request $request){
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

        //Obtenemos los datos médicos de la historia clínica
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();

        if(!$datosMedicos){
            //Si no existe se crea
            $datosMedicos = DatosMedicos::create([
                'historia_clinica_id' => $historiaClinica->id,
                'alergia_id' => 0,
                'patologia_id' => 0,
                'cirugia_id' => 0,
                'intolerancia_id' => 0,
                'valor_analisis_clinico_id' => 0,
            ]);
        }

        //Si no se ingresaron datos en el form, crea las tablas correspondientes con valores vacíos (ya sea si son numéricos o string)
        if(!$alimentosGustos){
            $alimentosGustos = [0];
        }else{
            //Verificación de anamnesis
            foreach ($alimentosGustos as $alimentoGusto){
                $anamnesisExistente = AnamnesisAlimentaria::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                    ]
                )->first();

                if(!$anamnesisExistente){
                    //Si no existe se crea
                    AnamnesisAlimentaria::create([
                        'historia_clinica_id' => $historiaClinica->id,
                        'alimento_id' => $alimentoGusto,
                        'gusta' => true,
                    ]);

                }else{
                    break;
                }
            }
        }


        if(!$alimentosNoGustos){
            $alimentosNoGustos = [0];
        }else{
            foreach($alimentosNoGustos as $alimentoNoGusto){
                $anamnesisExistente = AnamnesisAlimentaria::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                    ]
                )->first();

                if(!$anamnesisExistente){
                    //Si no existe se crea
                    AnamnesisAlimentaria::create([
                        'historia_clinica_id' => $historiaClinica->id,
                        'alimento_id' => $alimentoNoGusto,
                        'gusta' => false,
                    ]);

                }else{
                    break;
                }
            }
        }

        if(!$alergias){
            $alergias = [''];
        }else{
            //Verificación de alergias
            foreach ($alergias as $alergia) {
                $alergiasExistente = DatosMedicos::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                        ['alergia_id', $alergia],
                    ]
                )->first();

                if(!$alergiasExistente){
                    //Si no existe se crea
                    $datosMedicos->alergia_id = $alergia;
                }else{
                    break;
                }
            }
        }

        if(!$cirugias){
            $cirugias = [0];
            $tiempo = [0];
            $unidad = [''];
        }else{
            //Verificación de cirugias
            foreach ($cirugias as $key => $cirugia) {
                // Verificar si esta entrada de cirugía está vacía
                if ($cirugia !== '') {
                    $tiempoCirugia = $tiempo[$key];
                    $unidadCirugia = $unidad[$key];

                    $cirugiasExistente = DatosMedicos::where(
                        [
                            ['historia_clinica_id', $historiaClinica->id],
                            ['cirugia_id', $cirugia],
                        ]
                    )->first();

                    if(!$cirugiasExistente){
                        //Si no existe se crea
                        $datosMedicos->cirugia_id = $cirugia;
                    }else{
                        break;
                    }

                }
            }
        }

        if(!$patologias){
            $patologias = [''];
        }else{
            //Verificación de patologias
            foreach ($patologias as $patologia) {
                $patologiasExistente = DatosMedicos::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                        ['patologia_id', $patologia],
                    ]
                )->first();

                if(!$patologiasExistente){
                    //Si no existe se crea
                    $datosMedicos->patologia_id = $patologia;
                }else{
                    break;
                }
            }
        }

        if(!$intolerancias){
            $intolerancias = [''];
        } else {
            //Verificación de intolerancias
            foreach ($intolerancias as $intolerancia) {
                $intoleranciasExistente = DatosMedicos::where(
                    [
                        ['historia_clinica_id', $historiaClinica->id],
                        ['intolerancia_id', $intolerancia],
                    ]
                )->first();

                if(!$intoleranciasExistente){
                    //Si no existe se crea
                    $datosMedicos->intolerancia_id = $intolerancia;
                }else{
                    break;
                }
            }
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
