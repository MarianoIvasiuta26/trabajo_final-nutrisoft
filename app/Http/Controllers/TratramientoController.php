<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratramientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tratamientos = Tratamiento::all();

        return view('nutricionista.gestion-tratamientos.index', compact('tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nutricionista.gestion-tratamientos.create');
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
            'tratamiento' => ['required', 'string', 'max:50'],
        ]);

        $tratamiento = $request->input('tratamiento');

        $tratamientoCreado = Tratamiento::create([
            'tratamiento' => $tratamiento,
        ]);

        if($tratamientoCreado){
            return redirect()->back()->with('success', 'Tratamiento creado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al crear el tratamiento');
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
        // Buscamos el tratamiento
        $tratamiento = Tratamiento::find($id);

        // Si no existe lanzamos error
        if(!$tratamiento){
            return redirect()->back()->with('error', 'Error al encontrar el tratamiento a editar');
        }

        // Si existe retornamos la vista con el tratamiento
        return view('nutricionista.gestion-tratamientos.edit', compact('tratamiento'));
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
        $tratamiento = Tratamiento::find($id);

        if(!$tratamiento){
            return redirect()->back()->with('error', 'Tratamiento no encontrado');
        }

        $request->validate([
            'tratamiento' => ['required', 'string', 'max:50'],
        ]);

        $tratamiento->tratamiento = $request->input('tratamiento');

        if($tratamiento->save()){
            return redirect()->route('gestion-tratamientos.index')->with('success', 'Tratamiento actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el tratamiento');
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
        $tratamiento = Tratamiento::find($id);

        if(!$tratamiento){
            return redirect()->back()->with('error', 'Tratamiento no encontrado');
        }

        if($tratamiento->delete()){
            return redirect()->back()->with('success', 'Tratamiento eliminado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el tratamiento');
        }
    }
}
