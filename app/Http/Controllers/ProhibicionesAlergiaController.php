<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentosProhibidosAlergia;
use App\Models\Paciente\Alergia;
use Illuminate\Http\Request;

class ProhibicionesAlergiaController extends Controller
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
        $alergias = Alergia::all();
        $prohibiciones = AlimentosProhibidosAlergia::all();
        return view('admin.gestion-medica.alergias.alimentos-prohibidos', compact('alimentos','alergias','prohibiciones'));
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
            'alergias' => ['required', 'array']
        ]);

        $alergias = $request->input('alergias');
        $alimentos = $request->input('alimentos');

        foreach($alergias as $alergia){
            foreach($alimentos as $alimento){
                AlimentosProhibidosAlergia::create([
                    'alimento_id' => $alimento,
                    'alergia_id' => $alergia
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
        $prohibicion = AlimentosProhibidosAlergia::find($id);

        if(!$prohibicion){
            return redirect()->back()->with('error', 'Prohibición no encontrada');
        }

        $prohibicion->delete();
        return redirect()->back()->with('success','Prohibición eliminada correctamente.');

    }
}
