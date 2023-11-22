<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesProhibidasPatologia;
use App\Models\Alimento;
use App\Models\AlimentosProhibidosPatologia;
use App\Models\Paciente\Patologia;
use Illuminate\Http\Request;

class ProhibicionesPatologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    //@return \Illuminate\Http\Response
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */

    //@return \Illuminate\Http\Response
    public function create()
    {
        $alimentos = Alimento::all();
        $patologias = Patologia::all();
        $prohibiciones = AlimentosProhibidosPatologia::all();
        return view('admin.gestion-medica.patologias.alimentos-prohibidos', compact('alimentos','patologias', 'prohibiciones'));
    }

    public function create_actividades()
    {
        $actividades = Actividades::all();
        $patologias = Patologia::all();
        $prohibiciones = ActividadesProhibidasPatologia::all();

        return view('admin.gestion-medica.patologias.actividades-prohibidas', compact('actividades','patologias', 'prohibiciones'));

    }

    /**
     * Store a newly created resource in storage.
     *

     */
    // * @param  \Illuminate\Http\Request  $request
    //* @return \Illuminate\Http\Response
    public function store(Request $request)
    {
        $request->validate([
            'alimentos' => ['required', 'array'],
            'patologias' => ['required', 'array']
        ]);

        $patologias = $request->input('patologias');
        $alimentos = $request->input('alimentos');

        foreach($patologias as $patologia){
            foreach($alimentos as $alimento){
                AlimentosProhibidosPatologia::create([
                    'alimento_id' => $alimento,
                    'patologia_id' => $patologia
                ]);
            }
        }

        return redirect()->back()->with('success', '¡Alimento prohibido correctamente!');
    }

    public function store_actividades(Request $request){
        $request->validate([
            'actividades' => ['required', 'array'],
            'patologias' => ['required', 'array']
        ]);

        $patologias = $request->input('patologias');
        $actividades = $request->input('actividades');

        foreach($patologias as $patologia){
            foreach($actividades as $actividad){
                ActividadesProhibidasPatologia::create([
                    'actividad_id' => $actividad,
                    'patologia_id' => $patologia
                ]);
            }
        }

        return redirect()->back()->with('success', '¡Actividad prohibida correctamente!');
    }

    /**
     * Display the specified resource.
     *
    */
    /*
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
    */

    /*
        * @param  int  $id
        * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $prohibicion = AlimentosProhibidosPatologia::find($id);

        $patologias = Patologia::all();
        $alimentos = Alimento::all();
        $patologiaSeleccionada = Patologia::where('id',$prohibicion->patologia_id)->first();
        $alimentoSeleccionado = Alimento::Where('id', $prohibicion->alimento_id)->first();

        return view('admin.gestion-medica.patologias.edit-prohibiciones', compact('prohibicion','alimentos','patologias', 'patologiaSeleccionada', 'alimentoSeleccionado'));
    }

    public function edit_actividades($id)
    {
        $prohibicion = ActividadesProhibidasPatologia::find($id);

        $patologias = Patologia::all();
        $actividades = Actividades::all();
        $patologiaSeleccionada = Patologia::where('id',$prohibicion->patologia_id)->first();
        $actividadSeleccionada = Actividades::Where('id', $prohibicion->actividad_id)->first();

        return view('admin.gestion-medica.patologias.edit-prohibiciones-actividades', compact('prohibicion','actividades','patologias', 'patologiaSeleccionada', 'actividadSeleccionada'));
    }

    /**
     * Update the specified resource in storage.
     *
    */

    /*
    * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $prohibicion = AlimentosProhibidosPatologia::find($id);

        if($prohibicion){
            $request->validate([
                'alimentos' => ['required'],
                'patologias' => ['required']
            ]);

            $patologia = $request->input('patologias');
            $alimento = $request->input('alimentos');

            $prohibicion->update([
                'alimento_id' => $alimento,
                'patologia_id' => $patologia
            ]);

            return redirect()->route('prohibiciones-patologias.create')->with('success','¡Prohibición editada correctamente!');

        }else{
            return redirect()->back()->with('error', 'No se puedo editar la prohibición');
        }
    }

    public function update_actividades(Request $request, $id){
        $prohibicion = ActividadesProhibidasPatologia::find($id);

        if($prohibicion){
            $request->validate([
                'actividades' => ['required'],
                'patologias' => ['required']
            ]);

            $patologia = $request->input('patologias');
            $actividad = $request->input('actividades');

            $prohibicion->update([
                'actividad_id' => $actividad,
                'patologia_id' => $patologia
            ]);

            return redirect()->route('prohibiciones-patologias.actividades.create')->with('success','¡Prohibición editada correctamente!');

        }else{
            return redirect()->back()->with('error', 'No se puedo editar la prohibición');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
    */

    /*
    * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $prohibicion = AlimentosProhibidosPatologia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');
    }

    public function destroy_actividades($id)
    {
        $prohibicion = ActividadesProhibidasPatologia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');
    }
}
