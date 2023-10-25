<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TiposDeDieta;
use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratramientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    //@return \Illuminate\Http\Response
    public function index()
    {
        $tratamientos = Tratamiento::all();

        return view('nutricionista.gestion-tratamientos.index', compact('tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    //@return \Illuminate\Http\Response
    public function create()
    {
        $tiposDeDietas = TiposDeDieta::all();
        return view('nutricionista.gestion-tratamientos.create', compact('tiposDeDietas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     *
     */
     //@param  \Illuminate\Http\Request  $request
     //@return \Illuminate\Http\Response
    public function store(Request $request)
    {
        $request->validate([
            'tratamiento' => ['required', 'string', 'max:50'],
            'tipo_de_dieta' => ['required', 'integer'],
        ]);

        $tratamiento = $request->input('tratamiento');
        $tipoDeDieta = $request->input('tipo_de_dieta');

        $tratamientoCreado = Tratamiento::create([
            'tratamiento' => $tratamiento,
            'tipo_de_dieta_id'=> $tipoDeDieta
        ]);

        if($tratamientoCreado){
            return redirect()->route('gestion-tratamientos.index')->with('success', 'Tratamiento creado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al crear el tratamiento');
        }

    }

    /**
     * Display the specified resource.
     **/
     //@param  int  $id
     //@return \Illuminate\Http\Response

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     //@param  int  $id
     //@return \Illuminate\Http\Response

    public function edit($id)
    {
        // Buscamos el tratamiento
        $tratamiento = Tratamiento::find($id);
        $tiposDeDietas = TiposDeDieta::all();

        // Si no existe lanzamos error
        if(!$tratamiento){
            return redirect()->back()->with('error', 'Error al encontrar el tratamiento a editar');
        }

        // Si existe retornamos la vista con el tratamiento
        return view('nutricionista.gestion-tratamientos.edit', compact('tratamiento', 'tiposDeDietas'));
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
            'tipo_de_dieta' => ['required', 'integer'],
        ]);

        $tratamiento->tratamiento = $request->input('tratamiento');
        $tratamiento->tipo_de_dieta_id = $request->input('tipo_de_dieta');

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
