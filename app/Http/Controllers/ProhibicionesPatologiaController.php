<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentosProhibidosPatologia;
use App\Models\Paciente\Patologia;
use Illuminate\Http\Request;

class ProhibicionesPatologiaController extends Controller
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
        $patologias = Patologia::all();
        $prohibiciones = AlimentosProhibidosPatologia::all();
        return view('admin.gestion-medica.patologias.alimentos-prohibidos', compact('alimentos','patologias', 'prohibiciones'));
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
            'patologias' => ['required', 'array']
        ]);

        $patologias = $request->input('patologias');
        $alimentos = $request->input('alimentos');

        foreach($patologias as $patologia){
            foreach($alimentos as $alimento){
                AlimentosProhibidosPatologia::create([
                    'alimento_id' => $alimento,
                    'patologia_id' => $patologia
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
        $prohibicion = AlimentosProhibidosPatologia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');
    }
}
