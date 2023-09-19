<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\FuenteAlimento;
use App\Models\GrupoAlimento;
use App\Models\Nutriente;
use App\Models\TipoNutriente;
use App\Models\ValorNutricional;
use Illuminate\Http\Request;

class AlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alimentos = Alimento::all();
        $grupos = GrupoAlimento::all();
        $nutrientes = Nutriente::all();
        return view ('admin.gestion-alimentos.index', compact('alimentos', 'grupos', 'nutrientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = GrupoAlimento::all();
        $fuentes = FuenteAlimento::all();
        $nutrientes = Nutriente::all();
        $tipo_nutrientes = TipoNutriente::all();
        return view ('admin.gestion-alimentos.create', compact('grupos', 'fuentes', 'nutrientes', 'tipo_nutrientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validación y Creación del primer Form 'Datos de Alimento'
        $request->validate([
            'alimento' => ['required', 'string', 'max:30'],
            'grupo_alimento' => ['required', 'integer', 'default:1'],
            'estacional' => ['required', 'boolean', 'default:false'],
            'estacion' => ['required', 'string', 'max:10', 'default:Ninguna'],
        ]);

        $alimento = $request->input('alimento');
        $grupo_alimento = $request->input('grupo_alimento');
        $estacional = $request->input('estacional');
        $estacion = $request->input('estacion');

        //Validamos que no exista ese alimento
        $alimento_existente = Alimento::where('alimento', $alimento)->first();

        if ($alimento_existente) {
            return redirect()->route('gestion-alimentos.create')->with('error', 'El alimento ya existe');
        } else {

            $alimentoNuevo = Alimento::create([
                'alimento' => $alimento,
                'grupo_alimento_id' => $grupo_alimento,
                'estacional' => $estacional,
                'estacion' => $estacion,
            ]);

            return redirect()->route('gestion-alimentos.create')->with('success', 'Alimento creado correctamente');

            //Validación y creación del segundo Form 'Valores nutricionales'.
            $request->validate([
                'fuente' => ['required', 'integer', 'default:1'],
                'nutriente' => ['required', 'integer'],
                'unidad' => ['required', 'string', 'max:10'],
                'valor' => ['required', 'numeric'],
            ]);

            $fuente = $request->input('fuente');
            $nutriente = $request->input('nutriente');
            $unidad = $request->input('unidad');
            $valor = $request->input('valor');

            ValorNutricional::create([
                'alimento_id' => $alimentoNuevo->id,
                'fuente_alimento_id' => $fuente,
                'nutriente_id' => $nutriente,
                'unidad' => $unidad,
                'valor' => $valor,
            ]);

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
