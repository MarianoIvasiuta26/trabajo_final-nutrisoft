<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente\Cirugia;
use Illuminate\Http\Request;

class CirugiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cirugias = Cirugia::all();
        return view('admin.gestion-medica.cirugias.index', compact('cirugias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-medica.cirugias.create');
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
            'cirugia' => ['required', 'string', 'max:50'],
            'grupo_cirugia' => ['required', 'string', 'max:50'],
        ]);

        $cirugia = $request->input('cirugia');
        $grupo_cirugia = $request->input('grupo_cirugia');

        //Validamos que no exista esa alergia
        //$alergia_existente = Alergia::where(['alergia', $alergia], ['grupo_alergia', $grupo_alergia])->first();
        $cirugia_existente = Cirugia::whereIn('cirugia', [$cirugia])->where('grupo_cirugia', $grupo_cirugia)->first();

        if ($cirugia_existente) {
            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['cirugia_id', $cirugia_existente->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'cirugia_id' => $cirugia_existente->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/
            return redirect()->route('gestion-cirugias.create')->with('error', 'La cirugía ya existe');
        } else {
            $cirugia_creada = Cirugia::create([
                'cirugia' => $cirugia,
                'grupo_cirugia' => $grupo_cirugia,
            ]);

            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['alergia_id', $alergia_creada->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'cirugia_id' => $cirugia_creada->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/

            return redirect()->route('gestion-cirugias.index')->with('success', 'Cirugía creada correctamente');
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
