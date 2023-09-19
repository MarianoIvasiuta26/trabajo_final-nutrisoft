<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\FuenteAlimento;
use Illuminate\Http\Request;

class FuenteAlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fuentes = FuenteAlimento::all();
        return view('admin.gestion-alimentos.fuente.index', compact('fuentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-alimentos.fuente.create');
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
            'fuente' => ['required', 'string', 'max:80'],
        ]);

        $fuente = $request->input('fuente');

        //Validamos que no exista esa fuente
        $fuente_existente = FuenteAlimento::where('fuente', $fuente)->first();

        if ($fuente_existente) {
            return redirect()->route('gestion-alimentos.create')->with('error', 'La fuente de alimento ya existe');
        } else {

            FuenteAlimento::create([
                'fuente' => $fuente,
            ]);
            return redirect()->route('gestion-alimentos.create')->with('success', 'Fuente de alimento creada correctamente');
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
        //
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
