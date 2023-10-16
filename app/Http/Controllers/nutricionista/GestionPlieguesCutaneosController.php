<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\TiposDePliegueCutaneo;
use Illuminate\Http\Request;

class GestionPlieguesCutaneosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pliegues = TiposDePliegueCutaneo::all();
        return view('nutricionista.gestion-pliegues-cutaneos.index', compact('pliegues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nutricionista.gestion-pliegues-cutaneos.create');
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
            'pliegue' => ['required', 'string', 'max:50'],
            'unidad_de_medida' => ['required', 'string', 'max:20'],
            'descripcion' => ['max:255'],
        ]);

        $pliegue = $request->input('pliegue');
        $unidad_de_medida = $request->input('unidad_de_medida');
        $descripcion = $request->input('descripcion');

        if($descripcion == NULL){
            $pliegueNuevo = TiposDePliegueCutaneo::create([
                'nombre_pliegue' => $pliegue,
                'unidad_de_medida' => $unidad_de_medida,
            ]);
            if($pliegueNuevo){
                return redirect()->route('gestion-pliegues-cutaneos.index')->with('success', 'Pliegue cutáneo creado correctamente');
            }else{
                return redirect()->back()->with('error', 'No se pudo crear el pliegue cutáneo');
            }
        }

        $pliegueNuevo = TiposDePliegueCutaneo::create([
            'nombre_pliegue' => $pliegue,
            'unidad_de_medida' => $unidad_de_medida,
            'descripcion' => $descripcion,
        ]);

        if($pliegueNuevo){
            return redirect()->route('gestion-pliegues-cutaneos.index')->with('success', 'Pliegue cutáneo creado correctamente');
        }else{
            return redirect()->back()->with('error', 'No se pudo crear el pliegue cutáneo');
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
        $pliegue = TiposDePliegueCutaneo::find($id);

        return view('nutricionista.gestion-pliegues-cutaneos.edit', compact('pliegue'));

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
                //dd($request->all());
                $request->validate([
                    'pliegue' => ['required', 'string', 'max:50'],
                    'unidad_de_medida' => ['required', 'string', 'max:20'],
                    'descripcion' => ['max:255'],
                ]);

                $pliegue = $request->input('pliegue');
                $unidad_de_medida = $request->input('unidad_de_medida');
                $descripcion = $request->input('descripcion');

                if($descripcion == NULL){
                    $pliegueEditado = TiposDePliegueCutaneo::find($id);
                    $pliegueEditado->nombre_pliegue = $pliegue;
                    $pliegueEditado->unidad_de_medida = $unidad_de_medida;

                    if($pliegueEditado->save()){
                        return redirect()->route('gestion-pliegues-cutaneos.index')->with('success', 'Pliegue cutáneo actualizado correctamente');
                    }else{
                        return redirect()->back()->with('error', 'No se pudo actualizar el pliegue cutáneo');
                    }
                }

                $pliegueEditado = TiposDePliegueCutaneo::find($id);
                $pliegueEditado->nombre_pliegue = $pliegue;
                $pliegueEditado->unidad_de_medida = $unidad_de_medida;
                $pliegueEditado->descripcion = $descripcion;

                if($pliegueEditado->save()){
                    return redirect()->route('gestion-pliegues-cutaneos.index')->with('success', 'Pliegue cutáneo actualizado correctamente');
                }else{
                    return redirect()->back()->with('error', 'No se pudo actualizar el pliegue cutáneo');
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
        $pliegue = TiposDePliegueCutaneo::find($id);

        if($pliegue->delete()){
            return redirect()->route('gestion-pliegues-cutaneos.index')->with('success', 'Pliegue cutáneo eliminado correctamente');
        }else{
            return redirect()->back()->with('error', 'No se pudo eliminar el pliegue cutáneo');
        }
    }
}
