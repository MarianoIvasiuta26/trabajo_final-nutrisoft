<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentoPorTipoDeDieta;
use App\Models\AlimentosRecomendadosPorDieta;
use App\Models\Comida;
use App\Models\TiposDeDieta;
use App\Models\UnidadesMedidasPorComida;
use Illuminate\Http\Request;

class AlimentosPorDietasController extends Controller
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
     */
     //@return \Illuminate\Http\Response

    public function create()
    {
        $tiposDietas = TiposDeDieta::all();
        $comidas = Comida::all();
        $unidadesMedidas = UnidadesMedidasPorComida::all();
        $alimentos = Alimento::all();

        $alimentosPorDietas = AlimentoPorTipoDeDieta::all();
        $alimentosRecomendadosPorDietas = AlimentosRecomendadosPorDieta::all();

        return view('nutricionista.gestion-dietas.asociar-alimentos-dietas', compact('tiposDietas', 'comidas', 'unidadesMedidas', 'alimentos', 'alimentosPorDietas', 'alimentosRecomendadosPorDietas'));

    }

    /**
     * Store a newly created resource in storage.
     *
     */
    //@param  \Illuminate\Http\Request  $request
    //@return \Illuminate\Http\Response
    public function store(Request $request)
    {
        $request->validate([
            'alimento_id' => ['required', 'integer'],
            'tipo_de_dieta_id' => ['required', 'integer'],
            'cantidad' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'unidad_medida_id' => ['required', 'integer'],
            'comida_id' => ['required', 'integer']
        ]);

        $alimentoPorDieta = AlimentoPorTipoDeDieta::create([
            'alimento_id' => $request->input('alimento_id'),
            'tipo_de_dieta_id'=> $request->input('tipo_de_dieta_id'),
        ]);

        if(!$alimentoPorDieta){
            return redirect()->back()->with('error', 'Error al crear la asociación del alimento con la dieta.');
        }

        $alimentoRecomendadoDieta = AlimentosRecomendadosPorDieta::create([
            'alimento_por_dieta_id' => $alimentoPorDieta->id,
            'comida_id' => $request->input('comida_id'),
            'cantidad' => $request->input('cantidad'),
            'unidad_medida_id' => $request->input('unidad_medida_id')
        ]);

        if(!$alimentoRecomendadoDieta){
            return redirect()->back()->with('error', 'Error al registrar la asociación del alimento con la dieta.');
        }

        return redirect()->back()->with('success', '¡Alimento asociado con la dieta correctamente!');


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
     */
    //@param  int  $id
     //@return \Illuminate\Http\Response

    public function edit($id)
    {
        $alimentoPorDieta = AlimentoPorTipoDeDieta::find($id);
        $alimentoRecomendadoDieta = AlimentosRecomendadosPorDieta::where('alimento_por_dieta_id', $id)->first();
        $tiposDietas = TiposDeDieta::all();
        $comidas = Comida::all();
        $unidadesMedidas = UnidadesMedidasPorComida::all();
        $alimentos = Alimento::all();

        if(!$alimentoPorDieta){
            return redirect()->back()->with('error', 'Error al encontrar el alimento asociado a la dieta.');
        }

        if(!$alimentoRecomendadoDieta){
            return redirect()->back()->with('error', 'Error al encontrar el alimento recomendado para la dieta.');
        }

        return view('nutricionista.gestion-dietas.edit', compact('alimentoPorDieta', 'alimentoRecomendadoDieta', 'tiposDietas', 'comidas', 'unidadesMedidas', 'alimentos'));

    }

    /**
     * Update the specified resource in storage.
     *
     */
    //@param  \Illuminate\Http\Request  $request
    //@param  int  $id
    //@return \Illuminate\Http\Response
    public function update(Request $request, $id)
    {
        $alimentoPorDieta = AlimentoPorTipoDeDieta::find($id);
        $alimentoRecomendadoDieta = AlimentosRecomendadosPorDieta::where('alimento_por_dieta_id', $id)->first();

        if(!$alimentoPorDieta){
            return redirect()->back()->with('error', 'Error al encontrar el alimento asociado a la dieta.');
        }

        if(!$alimentoRecomendadoDieta){
            return redirect()->back()->with('error', 'Error al encontrar el alimento recomendado para la dieta.');
        }

        $request->validate([
            'alimento_id' => ['required', 'integer'],
            'tipo_de_dieta_id' => ['required', 'integer'],
            'cantidad' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'unidad_medida_id' => ['required', 'integer'],
            'comida_id' => ['required', 'integer']
        ]);

        $alimentoPorDieta->alimento_id = $request->input('alimento_id');
        $alimentoPorDieta->tipo_de_dieta_id = $request->input('tipo_de_dieta_id');
        $alimentoPorDieta->save();

        $alimentoRecomendadoDieta->comida_id = $request->input('comida_id');
        $alimentoRecomendadoDieta->cantidad = $request->input('cantidad');
        $alimentoRecomendadoDieta->unidad_medida_id = $request->input('unidad_medida_id');
        $alimentoRecomendadoDieta->save();

        return redirect()->route('gestion-alimento-por-dietas.create')->with('success', '¡Edición de la asociación entre alimento y dieta exitosa!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alimentoPorDieta = AlimentoPorTipoDeDieta::find($id);
        $alimentoRecomendadoDieta = AlimentosRecomendadosPorDieta::where('alimento_por_dieta_id', $id)->first();
        $alimentoRecomendadoDieta->delete();
        $alimentoPorDieta->delete();

        return redirect()->back()->with('success', '¡Alimento eliminado de la dieta correctamente!');
    }
}
