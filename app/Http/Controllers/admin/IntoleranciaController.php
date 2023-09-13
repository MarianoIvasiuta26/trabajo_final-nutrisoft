<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente\Intolerancia;
use Illuminate\Http\Request;

class IntoleranciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intolerancias = Intolerancia::all();
        return view('admin.gestion-medica.intolerancias.index', compact('intolerancias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-medica.intolerancias.create');
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
            'intolerancia' => ['required', 'string', 'max:50'],
        ]);

        $intolerancia = $request->input('intolerancia');

        //Validamos que no exista esa alergia
        //$alergia_existente = Alergia::where(['alergia', $alergia], ['grupo_alergia', $grupo_alergia])->first();
        $intolerancia_existente = Intolerancia::whereIn('intolerancia', [$intolerancia])->first();

        if ($intolerancia_existente) {
            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['intolerancia_id', $intolerancia_existente->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'intolerancia_id' => $intolerancia_existente->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/
            return redirect()->route('gestion-intolerancias.create')->with('error', 'La intolerancia ya existe');
        } else {
            $intolerancia_creada = Intolerancia::create([
                'intolerancia' => $intolerancia,
            ]);

            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la intolerancia
                $prohibicion_existente = Prohibiciones::where(['intolerancia_id', $intolerancia_creada->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'intolerancia_id' => $intolerancia_creada->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/

            return redirect()->route('gestion-intolerancias.index')->with('success', 'Intolerancia creada correctamente');
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
