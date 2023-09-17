<?php

namespace App\Http\Controllers\paciente;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Paciente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use App\Models\Paciente\ValorAnalisisClinico;
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
        $unidad = $request->input('unidad_tiempo');

        //Patologías
        $patologias = $request->input('patologias');

        //Intolerancias
        $intolerancias = $request->input('intolerancias');

        //Obtenemos id de HC y Paciente
        $paciente = Paciente::where('user_id', auth()->id())->first();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();

        //Verificamos si existe ya la historia clínica para el paciente
        if(!$historiaClinica){
            //Si no existe se crea
            $historiaClinica = HistoriaClinica::create([
                'paciente_id' => $paciente->id,
                'peso' => 0,
                'altura' => 0,
                'circunferencia_munieca' => 0,
                'circunferencia_cadera' => 0,
                'circunferencia_cintura' => 0,
                'circunferencia_pecho' => 0,
                'estilo_vida' => '',
                'objetivo_salud' => '',
            ]);
        }


        //Obtenemos los datos médicos de la historia clínica
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();

        if(!$datosMedicos){
            //Si no existe se crea

            $intoleranciaID = Intolerancia::where('intolerancia', 'Ninguna')->first();
            $patologiaID = Patologia::where('patologia', 'Ninguna')->first();
            $alergiaID = Alergia::where('alergia', 'Ninguna')->first();
            $analisID = ValorAnalisisClinico::where('nombre_valor', 'Ninguno')->first();

            $datosMedicos = DatosMedicos::create([
                'historia_clinica_id' => $historiaClinica->id,
                'alergia_id' =>  $alergiaID->id,
                'patologia_id' => $patologiaID->id,
                'intolerancia_id' => $intoleranciaID->id,
                'valor_analisis_clinico_id' => $analisID->id,
            ]);
        }

        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
        $alimentoID = Alimento::where('alimento', 'Ninguno')->first();

        if(!$anamnesisPaciente){
            //Si no existe se crea
            $anamnesisPaciente = AnamnesisAlimentaria::create([
                'historia_clinica_id' => $historiaClinica->id,
                'alimento_id' => $alimentoID->id,
                'gusta' => false,
            ]);
        }

        // Verificar si se proporcionaron datos en alimentosGustos
        if (!empty($alimentosGustos)) {
            foreach ($alimentosGustos as $alimentoGusto) {
                // Buscar un registro existente
                $anamnesisExistente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
                if ($anamnesisExistente) {
                    // Si existe, actualizarlo
                    $anamnesisExistente->gusta = true;
                    $anamnesisExistente->save();
                } else {
                    // Si no existe, crear un nuevo registro
                    $anamnesisPaciente->alimento_id = $alimentoGusto;
                    $anamnesisPaciente->gusta = true;
                }
            }
        }

        // Verificar si se proporcionaron datos en alimentosNoGustos
        if(!empty($alimentosNoGustos)){
            foreach($alimentosNoGustos as $alimentoNoGusto){
                //Buscamos un registro existente
                $anamnesisExistente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();

                if($anamnesisExistente){
                    //Si existe, actualizarlo
                    $anamnesisExistente->gusta = false;
                    $anamnesisExistente->save();
                }else{
                    //Si no existe, crear un nuevo registro
                    $anamnesisPaciente->alimento_id = $alimentoNoGusto;
                    $anamnesisPaciente->gusta = false;
                }
            }
        }

        if(!empty($alergias)){
            foreach($alergias as $alergia){
                //Buscamos un registro existente
                $alergiasExistente = DatosMedicos::where('alergia_id', $alergia)->first();

                if($alergiasExistente){
                    //Si existe, actualizarlo
                    $alergiasExistente->alergia_id = $alergia;
                    $alergiasExistente->save();
                }else{
                    //Si no existe, crear un nuevo registro
                    $datosMedicos->alergia_id = $alergia;
                }
            }
        }
/*
        $cirugiaPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->first();
        $cirugiaID = Cirugia::where('cirugia', 'Ninguna')->first();

        if(!$cirugiaPaciente){
            //Si no existe se crea
            $cirugiaPaciente = CirugiasPaciente::create([
                'historia_clinica_id' => $historiaClinica->id,
                'cirugia_id' => $cirugiaID->id,
                'tiempo' => 0,
                'unidad_tiempo' => '',
            ]);
        }
*/
/*
        if(!empty($cirugias)){
            //Verificación de cirugias
            foreach ($cirugias as $key => $cirugia) {
                // Verificar si esta entrada de cirugía está vacía
                if ($cirugia !== '') {
                    $tiempoCirugia = $tiempo[$key];
                    $unidadCirugia = $unidad[$key];

                    $cirugiasExistente = CirugiasPaciente::where('cirugia_id', $cirugia)->first();

                    if($cirugiasExistente){
                        //Si existe, actualizarlo
                        $cirugiasExistente->cirugia_id = $cirugia;
                        $cirugiasExistente->save();
                    }else{
                        //Si no existe, crear un nuevo registro
                        $cirugiaPaciente->cirugia_id = $cirugia;
                        $cirugiaPaciente->tiempo = $tiempoCirugia;
                        $cirugiaPaciente->unidad_tiempo = $unidadCirugia;
                    }
                }
            }
        }
*/
        // Recorre los datos y crea registros en cirugias_pacientes
        foreach ($request->input('cirugias') as $key => $cirugiaId) {
            CirugiasPaciente::create([
                'historia_clinica_id' => $historiaClinica->id,
                'cirugia_id' => $cirugiaId,
                'tiempo' => $request->input('tiempos')[$key],
                'unidad_tiempo' => $request->input('unidades_tiempo')[$key],
            ]);
        }

        if(!empty($patologias)){
            //Verificación de patologias
            foreach ($patologias as $patologia) {
                // Verificar si esta entrada de patología está vacía
                if ($patologia !== '') {
                    $patologiasExistente = DatosMedicos::where('patologia_id', $patologia)->first();

                    if($patologiasExistente){
                        //Si existe, actualizarlo
                        $patologiasExistente->patologia_id = $patologia;
                        $patologiasExistente->save();
                    }else{
                        //Si no existe, crear un nuevo registro
                        $datosMedicos->patologia_id = $patologia;
                    }
                }
            }
        }

        if(!empty($intolerancias)){
            //Verificación de intolerancias
            foreach ($intolerancias as $intolerancia) {
                // Verificar si esta entrada de intolerancia está vacía
                if ($intolerancia !== '') {
                    $intoleranciasExistente = DatosMedicos::where('intolerancia_id', $intolerancia)->first();

                    if($intoleranciasExistente){
                        //Si existe, actualizarlo
                        $intoleranciasExistente->intolerancia_id = $intolerancia;
                        $intoleranciasExistente->save();
                    }else{
                        //Si no existe, crear un nuevo registro
                        $datosMedicos->intolerancia_id = $intolerancia;
                    }
                }
            }
        }

        return redirect()->route('historia-clinica.create')->with('success', 'Datos médicos registrados correctamente');

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
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->first();
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
        $patologias = Patologia::all();
        $alergias = Alergia::all();
        $cirugias = Cirugia::all();
        $intolerancias = Intolerancia::all();
        $alimentos = Alimento::all();

        return view ('paciente.historia-clinica.datos-medicos.edit')
            ->with('historiaClinica', $historiaClinica)
            ->with('anamnesisPaciente', $anamnesisPaciente)
            ->with('cirugiasPaciente', $cirugiasPaciente)
            ->with('datosMedicos', $datosMedicos)
            ->with('cirugias', $cirugias)
            ->with('alimentos', $alimentos)
            ->with('patologias', $patologias)
            ->with('alergias', $alergias)
            ->with('intolerancias', $intolerancias);
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
        $historiaClinica = HistoriaClinica::find($id);
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->first();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->first();
        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
        //Alergias
        $alergias = $request->input('alergias');
        //Patologías
        $patologias = $request->input('patologias');
        //Intolerancias
        $intolerancias = $request->input('intolerancias');

        if($datosMedicos){
            if(!empty($alergias)){
                foreach($alergias as $alergia){
                    //Buscamos un registro existente
                    $alergiasExistente = DatosMedicos::where('alergia_id', $alergia)->first();

                    if($alergiasExistente){
                        //Si existe, actualizarlo
                        $alergiasExistente->alergia_id = $alergia;
                        $alergiasExistente->save();
                    }else{
                        //Si no existe, crear un nuevo registro
                        $datosMedicos->alergia_id = $alergia;
                    }
                }
            }

            if(!empty($patologias)){
                //Verificación de patologias
                foreach ($patologias as $patologia) {
                    // Verificar si esta entrada de patología está vacía
                    if ($patologia !== '') {
                        $patologiasExistente = DatosMedicos::where('patologia_id', $patologia)->first();

                        if($patologiasExistente){
                            //Si existe, actualizarlo
                            $patologiasExistente->patologia_id = $patologia;
                            $patologiasExistente->save();
                        }else{
                            //Si no existe, crear un nuevo registro
                            $datosMedicos->patologia_id = $patologia;
                        }
                    }
                }
            }

            if(!empty($intolerancias)){
                //Verificación de intolerancias
                foreach ($intolerancias as $intolerancia) {
                    // Verificar si esta entrada de intolerancia está vacía
                    if ($intolerancia !== '') {
                        $intoleranciasExistente = DatosMedicos::where('intolerancia_id', $intolerancia)->first();

                        if($intoleranciasExistente){
                            //Si existe, actualizarlo
                            $intoleranciasExistente->intolerancia_id = $intolerancia;
                            $intoleranciasExistente->save();
                        }else{
                            //Si no existe, crear un nuevo registro
                            $datosMedicos->intolerancia_id = $intolerancia;
                        }
                    }
                }
            }

            // Guarda los cambios en la base de datos
            $datosMedicos->save();

            if($cirugiasPaciente){

                //Cirugías
                $cirugias = $request->input('cirugias');
                $tiempo = $request->input('tiempo');
                $unidad = $request->input('unidad');
                if(!empty($cirugias)){
                    //Verificación de cirugias
                    foreach ($cirugias as $key => $cirugia) {
                        // Verificar si esta entrada de cirugía está vacía
                        if ($cirugia !== '') {
                            $tiempoCirugia = $tiempo[$key];
                            $unidadCirugia = $unidad[$key];

                            $cirugiasPaciente = CirugiasPaciente::where('cirugia_id', $cirugia)->first();

                            if($cirugiasPaciente){
                                //Si existe, actualizarlo
                                $cirugiasPaciente->cirugia_id = $cirugia;
                                $cirugiasPaciente->tiempo = $tiempoCirugia;
                                $cirugiasPaciente->unidad_tiempo = $unidadCirugia;
                                $cirugiasPaciente->save();
                            }
                        }
                    }
                }

            }

            if($anamnesisPaciente){
                $alimentosGustos = $request->input('alimentos_gustos');
                $alimentosNoGustos = $request->input('alimentos_no_gustos');

                // Verificar si se proporcionaron datos en alimentosGustos
                if (!empty($alimentosGustos)) {
                    foreach ($alimentosGustos as $alimentoGusto) {
                        // Buscar un registro existente
                        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();
                        if ($anamnesisPaciente) {
                            // Si existe, actualizarlo
                            $anamnesisPaciente->gusta = true;
                            $anamnesisPaciente->save();
                        }
                    }
                }

                // Verificar si se proporcionaron datos en alimentosNoGustos
                if(!empty($alimentosNoGustos)){
                    foreach($alimentosNoGustos as $alimentoNoGusto){
                        //Buscamos un registro existente
                        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->first();

                        if($anamnesisPaciente){
                            //Si existe, actualizarlo
                            $anamnesisPaciente->gusta = false;
                            $anamnesisPaciente->save();
                        }
                    }
                }
            }

            return redirect()->route('historia-clinica.index')->with('success', 'Datos médicos actualizados');
        }else{
            return redirect()->route('historia-clinica.index')->with('error', 'Datos Médicos no encontrado');
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
        //
    }
}
