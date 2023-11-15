<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use App\Models\ActividadesPorTiposDeActividades;
use App\Models\ActividadesRecomendadasPorTiposDeActividades;
use App\Models\ActividadRecPorTipoActividades;
use App\Models\TiposDeActividades;
use App\Models\UnidadesDeTiempo;
use Illuminate\Http\Request;

class ActividadesPorTipoActividadController extends Controller
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
        $tiposActividades = TiposDeActividades::all();
        $unidadesTiempo = UnidadesDeTiempo::all();
        $actividades = Actividades::all();

        $actividadesPorTipoActividad = ActividadesPorTiposDeActividades::all();
        $actividadesRecomendadas = ActividadRecPorTipoActividades::all();
        return view('nutricionista.gestion-plan-seguimiento.asociar-actividades-plan', compact('tiposActividades', 'unidadesTiempo', 'actividades', 'actividadesPorTipoActividad', 'actividadesRecomendadas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'actividad_id' => ['required', 'integer'],
            'tipo_de_actividad_id' => ['required', 'integer'],
            'duracion_actividad' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'unidad_tiempo_id' => ['required', 'integer'],
        ]);

        //Validamos que ya no exista registro del alimento seleccioando en la dieta
        $actividadPorTipoActividad = ActividadesPorTiposDeActividades::where('actividad_id', $request->input('actividad_id'))
            ->where('tipo_actividad_id', $request->input('tipo_de_actividad_id'))
            ->first();

        if($actividadPorTipoActividad) {
            $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $actividadPorTipoActividad->id)->first();

            if($actividadRecomendada){
                return redirect()->back()->with('error', 'Error al crear la asociación de la actividad. Ya existe un registro de esta actividad.');
            }
        }

        $actividadPorTipoActividad = ActividadesPorTiposDeActividades::create([
            'actividad_id' => $request->input('actividad_id'),
            'tipo_actividad_id'=> $request->input('tipo_de_actividad_id'),
        ]);

        if(!$actividadPorTipoActividad){
            return redirect()->back()->with('error', 'Error al crear la asociación de la actividad.');
        }

        $actividadRecomendada = ActividadRecPorTipoActividades::create([
            'act_tipoAct_id' => $actividadPorTipoActividad->id,
            'duracion_actividad' => $request->input('duracion_actividad'),
            'unidad_tiempo_id' => $request->input('unidad_tiempo_id')
        ]);

        if(!$actividadRecomendada){
            return redirect()->back()->with('error', 'Error al registrar la asociación de la actividad.');
        }

        return redirect()->back()->with('success', 'Actividad asociada con el tipo de actividad correctamente!');
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
        $actividadPorTipo = ActividadesPorTiposDeActividades::find($id);
        $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $id)->first();
        $tiposActividades = TiposDeActividades::all();
        $unidadesTiempo = UnidadesDeTiempo::all();
        $actividades = Actividades::all();

        if(!$actividadPorTipo){
            return redirect()->back()->with('error', 'Error al encontrar la actividad asociada al tipo de actividad.');
        }

        if(!$actividadRecomendada){
            return redirect()->back()->with('error', 'Error al encontrar la actividad asociada al tipo de actividad.');
        }

        return view('nutricionista.gestion-plan-seguimiento.edit', compact('actividadPorTipo', 'actividadRecomendada', 'tiposActividades', 'unidadesTiempo', 'actividades'));
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
        $actividadPorTipo = ActividadesPorTiposDeActividades::find($id);
        $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $id)->first();

        if(!$actividadPorTipo){
            return redirect()->back()->with('error', 'Error al encontrar la actividad asociada al tipo de actividad.');
        }

        if(!$actividadRecomendada){
            return redirect()->back()->with('error', 'Error al encontrar la actividad asociada al tipo de actividad.');
        }

        $request->validate([
            'actividad_id' => ['required', 'integer'],
            'tipo_de_actividad_id' => ['required', 'integer'],
            'duracion_actividad' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'unidad_tiempo_id' => ['required', 'integer'],
        ]);

        $actividadPorTipo->actividad_id = $request->input('actividad_id');
        $actividadPorTipo->tipo_actividad_id = $request->input('tipo_de_actividad_id');
        $actividadPorTipo->save();

        $actividadRecomendada->duracion_actividad = $request->input('duracion_actividad');
        $actividadRecomendada->unidad_tiempo_id = $request->input('unidad_tiempo_id');
        $actividadRecomendada->save();

        return redirect()->route('gestion-actividad-por-tipo-actividad.create')->with('success', '¡Edición de la asociación entre actividad y tipo de actividad exitosa!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividadPorTipo = ActividadesPorTiposDeActividades::find($id);
        $actividadRecomendada = ActividadRecPorTipoActividades::where('act_tipoAct_id', $id)->first();
        $actividadRecomendada->delete();
        $actividadPorTipo->delete();

        return redirect()->back()->with('success', 'Actividad eliminada del tipo de dieta correctamente!');
    }
}
