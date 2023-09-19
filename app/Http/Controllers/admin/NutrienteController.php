<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Nutriente;
use App\Models\TipoNutriente;
use Illuminate\Http\Request;

class NutrienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_nutrientes = TipoNutriente::all();
        $nutrientes = Nutriente::all();

        return view('admin.gestion-alimentos.nutriente.index', compact('tipo_nutrientes', 'nutrientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_nutrientes = TipoNutriente::all();
        return view('admin.gestion-alimentos.nutriente.create', compact('tipo_nutrientes'));
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
            'nombre_nutriente' => ['required', 'string', 'max:50'],
            'tipo_nutriente' => ['required', 'integer'],
        ]);

        $nutriente = $request->input('nombre_nutriente');
        $tipo_nutriente = $request->input('tipo_nutriente');

        //Validamos que no exista ese nutriente
        $nutriente_existente = Nutriente::where('nombre_nutriente', $nutriente)->first();

        if ($nutriente_existente) {
            return redirect()->route('gestion-nutrientes.index')->with('error', 'El nutriente ya existe');
        } else {

            Nutriente::create([
                'nombre_nutriente' => $nutriente,
                'tipo_nutriente_id' => $tipo_nutriente,
            ]);
            return redirect()->route('gestion-nutrientes.index')->with('success', 'Nutriente creado correctamente');
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
        $nutriente = Nutriente::find($id);
        $tipo_nutrientes = TipoNutriente::all();

        return view('admin.gestion-alimentos.nutriente.edit', compact('nutriente', 'tipo_nutrientes'));
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
        $nutriente = Nutriente::find($id);

        $request->validate([
            'nombre_nutriente' => ['required', 'string', 'max:50'],
            'tipo_nutriente' => ['required', 'integer'],
        ]);

        if($nutriente){
            $nutriente->nombre_nutriente = $request->input('nombre_nutriente');
            $nutriente->tipo_nutriente_id = $request->input('tipo_nutriente');
            $nutriente->save();
        }else{
            return redirect()->route('gestion-nutrientes.index')->with('error', 'El nutriente no existe');
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
        $nutriente = Nutriente::find($id);

        if($nutriente){
            $nutriente->delete();
            return redirect()->route('gestion-nutrientes.index')->with('success', 'Nutriente eliminado correctamente');
        }else{
            return redirect()->route('gestion-nutrientes.index')->with('error', 'No se pudo eliminar el nutriente.');
        }
    }
}
