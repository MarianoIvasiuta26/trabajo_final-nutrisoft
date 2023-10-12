<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente\Alergia;
use App\Models\Prohibiciones;
use Illuminate\Http\Request;

class AlergiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alergias = Alergia::all();
        //$alimentos_prohibidos = ProhibicionAlergia::all();

        return view('admin.gestion-medica.alergias.index', compact('alergias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-medica.alergias.create');
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
            'alergia' => ['required', 'string', 'max:50'],
            'grupo_alergia' => ['required', 'string', 'max:50'],
        ]);

        $alergia = $request->input('alergia');
        $grupo_alergia = $request->input('grupo_alergia');

        //Validamos que no exista esa alergia
        //$alergia_existente = Alergia::where(['alergia', $alergia], ['grupo_alergia', $grupo_alergia])->first();
        $alergia_existente = Alergia::whereIn('alergia', [$alergia])->where('grupo_alergia', $grupo_alergia)->first();

        if ($alergia_existente) {
            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['alergia_id', $alergia_existente->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'alergia_id' => $alergia_existente->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/
            return redirect()->route('gestion-alergias.create')->with('error', 'La alergia ya existe');
        } else {
            $alergia_creada = Alergia::create([
                'alergia' => $alergia,
                'grupo_alergia' => $grupo_alergia,
            ]);

            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['alergia_id', $alergia_creada->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'alergia_id' => $alergia_creada->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/

            return redirect()->route('gestion-alergias.index')->with('success', 'Alergia creada correctamente');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alergia = Alergia::find($id);
        return view('admin.gestion-medica.alergias.edit')->with('alergia', $alergia);
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
        $alergia = Alergia::find($id);

        $request->validate([
            'alergia' => ['required', 'string', 'max:50'],
            'grupo_alergia' => ['required', 'string', 'max:50'],
        ]);

        $alergia->alergia = $request->input('alergia');

        $alergia->grupo_alergia = $request->input('grupo_alergia');

        $alergia->save();

        return redirect()->route('gestion-alergias.index')->with('success', 'Alergia actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alergia = Alergia::find($id);

        if ($alergia) {
            $alergia->delete();
            return redirect()->route('gestion-alergias.index')->with('success', 'Alergia eliminada correctamente');
        } else {
            return redirect()->route('gestion-alergias.index')->with('error', 'No se pudo eliminar la alergia');
        }
    }
}
