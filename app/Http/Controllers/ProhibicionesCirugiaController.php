<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesProhibidasCirugia;
use App\Models\Paciente\Cirugia;
use Illuminate\Http\Request;

class ProhibicionesCirugiaController extends Controller
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
     *
     */
    //@return \Illuminate\Http\Response
    public function create()
    {
        //
    }

    public function create_actividades(){
        $actividades = Actividades::all();
        $cirugias = Cirugia::all();
        $prohibiciones = ActividadesProhibidasCirugia::all();

        return view('admin.gestion-medica.cirugias.actividades-prohibidas', compact('actividades','cirugias', 'prohibiciones'));

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

    public function store_actividades(Request $request){
        $request->validate([
            'actividades' => ['required', 'array'],
            'cirugias' => ['required', 'array']
        ]);

        $cirugias = $request->input('cirugias');
        $actividades = $request->input('actividades');

        foreach($cirugias as $cirugia){
            foreach($actividades as $actividad){
                ActividadesProhibidasCirugia::create([
                    'actividad_id' => $actividad,
                    'cirugia_id' => $cirugia
                ]);
            }
        }

        return redirect()->back()->with('success', '¡Actividad prohibida correctamente!');
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

    public function edit_actividades($id)
    {
        $prohibicion = ActividadesProhibidasCirugia::find($id);

        $cirugias = Cirugia::all();
        $actividades = Actividades::all();
        $cirugiaSeleccionada = Cirugia::where('id',$prohibicion->cirugia_id)->first();
        $actividadSeleccionada = Actividades::Where('id', $prohibicion->actividad_id)->first();

        return view('admin.gestion-medica.cirugias.edit-prohibiciones-actividades', compact('prohibicion','actividades','cirugias', 'cirugiaSeleccionada', 'actividadSeleccionada'));
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

    public function update_actividades(Request $request, $id){
        $prohibicion = ActividadesProhibidasCirugia::find($id);

        if($prohibicion){
            $request->validate([
                'actividades' => ['required'],
                'cirugias' => ['required']
            ]);

            $cirugia = $request->input('cirugias');
            $actividad = $request->input('actividades');

            $prohibicion->update([
                'actividad_id' => $actividad,
                'cirugia_id' => $cirugia
            ]);

            return redirect()->route('prohibiciones-cirugias.actividades.create')->with('success','¡Prohibición editada correctamente!');

        }else{
            return redirect()->back()->with('error', 'No se puedo editar la prohibición');
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

    public function destroy_actividades($id)
    {
        $prohibicion = ActividadesProhibidasCirugia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');
    }
}
