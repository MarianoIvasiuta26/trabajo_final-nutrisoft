<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\GrupoAlimento;
use Illuminate\Http\Request;

class GrupoAlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = GrupoAlimento::all();
        return view('admin.gestion-alimentos.grupo.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-alimentos.grupo.create');
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
            'grupo' => ['required', 'string', 'max:80'],
        ]);

        $grupo = $request->input('grupo');

        //Validamos que no exista ese grupo
        $grupo_existente = GrupoAlimento::where('grupo', $grupo)->first();

        if ($grupo_existente) {
            return redirect()->route('gestion-grupos-alimento.index')->with('error', 'El grupo de alimento ya existe');
        } else {

            GrupoAlimento::create([
                'grupo' => $grupo,
            ]);
            return redirect()->route('gestion-grupos-alimento.index')->with('success', 'Grupo de alimento creado correctamente');
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
        $grupo = GrupoAlimento::find($id);
        return view('admin.gestion-alimentos.grupo.edit', compact('grupo'));
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
        $grupo = GrupoAlimento::find($id);
        $request->validate([
            'grupo' => ['required', 'string', 'max:80'],
        ]);

        if($grupo){
            $grupo->grupo = $request->input('grupo');

            $grupo->save();

            return redirect()->route('gestion-grupos-alimento.index')->with('success', 'Grupo de alimento actualizado correctamente');
        }else{
            return redirect()->route('gestion-grupos-alimento.index')->with('error', 'No se pudo actualizar el grupo de alimento');
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
        $grupo = GrupoAlimento::find($id);

        if($grupo){
            $grupo->delete();
            return redirect()->route('gestion-grupos-alimento.index')->with('success', 'Grupo de alimento eliminado correctamente');
        }else{
            return redirect()->route('gestion-grupos-alimento.index')->with('error', 'No se pudo eliminar el grupo de alimento');
        }
    }
}
