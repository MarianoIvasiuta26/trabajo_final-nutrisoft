<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Paciente\Patologia;
use Illuminate\Http\Request;

class PatologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patologias = Patologia::all();
        return view('admin.gestion-medica.patologias.index', compact('patologias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-medica.patologias.create');
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
            'patologia' => ['required', 'string', 'max:50'],
            'grupo_patologia' => ['required', 'string', 'max:50'],
        ]);

        $patologia = $request->input('patologia');
        $grupo_patologia = $request->input('grupo_patologia');

        //Validamos que no exista esa alergia
        //$alergia_existente = Alergia::where(['alergia', $alergia], ['grupo_alergia', $grupo_alergia])->first();
        $patologia_existente = Patologia::whereIn('patologia', [$patologia])->where('grupo_patologia', $grupo_patologia)->first();

        if ($patologia_existente) {
            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['patologia_id', $patologia_existente->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'patologia_id' => $patologia_existente->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/
            return redirect()->route('gestion-patologias.create')->with('error', 'La patologia ya existe');
        } else {
            $patologia_creada = Patologia::create([
                'patologia' => $patologia,
                'grupo_patologia' => $grupo_patologia,
            ]);

            /*$alimentos_prohibidos = $request->input('alimentos_prohibidos');
            foreach($alimentos_prohibidos as $alimento_prohibido){
                //Validamos que ya no está registrado esta prohibición para la alergia
                $prohibicion_existente = Prohibiciones::where(['patologia_id', $patologia_creada->id], ['alimento_id', $alimento_prohibido->id])->first();
                if(!$prohibicion_existente){
                    Prohibiciones::create([
                        'patologia_id' => $patologia_creada->id,
                        'alimento_id' => $alimento_prohibido,
                    ]);
                }
            }*/

            return redirect()->route('gestion-patologias.index')->with('success', 'Patología creada correctamente');
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
        $patologia = Patologia::find($id);
        return view('admin.gestion-medica.patologias.edit', compact('patologia'));
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
        $patologia = Patologia::find($id);

        $request->validate([
            'patologia' => ['required', 'string', 'max:50'],
            'grupo_patologia' => ['required', 'string', 'max:50'],
        ]);

        if(!$patologia){
            return redirect()->back()->with('error', 'Error al editar la patología, inténtelo de nuevo.');
        }

        $patologia->patologia = $request->input('patologia');
        $patologia->grupo_patologia = $request->input('grupo_patologia');

        $patologia->save();

        return redirect()->route('gestion-patologias.index')->with('success', 'Patología editada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patologia = Patologia::find($id);

        if(!$patologia){
            return redirect()->back()->with('error', 'Error al eliminar la patología, inténtelo de nuevo.');
        }

        $patologia->delete();

        return redirect()->route('gestion-patologias.index')->with('success', 'Patología eliminada correctamente');
    }
}
