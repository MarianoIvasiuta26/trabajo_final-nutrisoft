<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentosProhibidosIntolerancia;
use App\Models\Paciente\Intolerancia;
use Illuminate\Http\Request;

class ProhibicionesIntoleranciaController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alimentos = Alimento::all();
        $intolerancias = Intolerancia::all();
        $prohibiciones = AlimentosProhibidosIntolerancia::all();
        return view('admin.gestion-medica.intolerancias.alimentos-prohibidos', compact('alimentos','intolerancias','prohibiciones'));
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
            'alimentos' => ['required', 'array'],
            'intolerancias' => ['required', 'array']
        ]);

        $intolerancias = $request->input('intolerancias');
        $alimentos = $request->input('alimentos');

        foreach($intolerancias as $intolerancia){
            foreach($alimentos as $alimento){
                AlimentosProhibidosIntolerancia::create([
                    'alimento_id' => $alimento,
                    'intolerancia_id' => $intolerancia
                ]);
            }
        }

        return redirect()->back()->with('success', '¡Alimento prohibido correctamente!');
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
        $prohibicion = AlimentosProhibidosIntolerancia::find($id);
        $alimentos = Alimento::all();
        $intolerancias = Intolerancia::all();
        $intoleranciaSeleccionada = Intolerancia::where('id',$prohibicion->intolerancia_id)->first();
        $alimentoSeleccionado = Alimento::Where('id', $prohibicion->alimento_id)->first();

        return view('admin.gestion-medica.intolerancias.edit-prohibiciones', compact('prohibicion','alimentos','intolerancias', 'intoleranciaSeleccionada', 'alimentoSeleccionado'));
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
        $prohibicion = AlimentosProhibidosIntolerancia::find($id);

        if($prohibicion){
            $request->validate([
                'alimentos' => ['required'],
                'intolerancias' => ['required']
            ]);

            $intolerancia = $request->input('intolerancias');
            $alimento = $request->input('alimentos');

            $prohibicion->update([
                'alimento_id' => $alimento,
                'intolerancia_id' => $intolerancia
            ]);

            return redirect()->route('prohibiciones-intolerancias.create')->with('success','¡Prohibición editada correctamente!');

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
        $prohibicion = AlimentosProhibidosIntolerancia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');
    }
}
