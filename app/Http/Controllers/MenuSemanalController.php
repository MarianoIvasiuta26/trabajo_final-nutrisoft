<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use App\Models\Receta;
use App\Models\UnidadesDeTiempo;
use App\Models\UnidadesMedidasPorComida;
use Illuminate\Http\Request;

class MenuSemanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recetas = Receta::where('nombre_receta', '!=', 'Sin receta')->get();
        $ingredientes = Ingrediente::all();
        $unidadesMedidas = UnidadesMedidasPorComida::where('nombre_unidad_medida', '!=', 'Sin unidad de medida')->get();
        $unidadesTiempo = UnidadesDeTiempo::where('nombre_unidad_tiempo', '!=', 'Sin unidad de tiempo')->get();

        return view('paciente.menu-semanal.index', compact('recetas', 'ingredientes', 'unidadesMedidas', 'unidadesTiempo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
