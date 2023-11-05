<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Actividades;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = Actividades::all();
        return view('admin.gestion-actividades.index', compact('actividades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-actividades.create');
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
            'actividad' => ['required', 'string', 'max:80'],
        ]);

        $actividad = $request->input('actividad');

        $creada = Actividades::create([
            'actividad' => $actividad,
        ]);

        if(!$creada){
            return redirect()->back()->with('error', 'Error al crear la actividad');
        }

        return redirect()->route('gestion-actividades.index')->with('success', 'Actividad creada correctamente');

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
        $actividad = Actividades::find($id);

        return view('admin.gestion-actividades.edit', compact('actividad'));
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
        $actividad = Actividades::find($id);

        if(!$actividad){
            return redirect()->back()->with('error', 'Error al actualizar la actividad');
        }

        $actividad->actividad = $request->input('actividad');
        $actividad->save();

        return redirect()->route('gestion-actividades.index')->with('success', 'Actividad actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad = Actividades::find($id);

        if(!$actividad){
            return redirect()->back()->with('error', 'Error al eliminar la actividad');
        }

        $actividad->delete();

        return redirect()->route('gestion-actividades.index')->with('success', 'Actividad eliminada correctamente');

    }
}
