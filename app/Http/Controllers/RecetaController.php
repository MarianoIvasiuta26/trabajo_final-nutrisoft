<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Ingrediente;
use App\Models\Receta;
use App\Models\UnidadesDeTiempo;
use App\Models\UnidadesMedidasPorComida;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recetas = Receta::where('nombre_receta', '!=', 'Sin receta')->get();
        $alimentos = Alimento::all();
        $ingredientes = Ingrediente::all();
        $unidades_de_tiempo = UnidadesDeTiempo::where('nombre_unidad_tiempo', '!=', 'Sin unidad de tiempo')->get();
        $unidades_de_medida = UnidadesMedidasPorComida::where('nombre_unidad_medida', '!=', 'Sin unidad de medida')->get();
        return view ('admin.gestion-recetas.index', compact('recetas', 'alimentos', 'ingredientes','unidades_de_tiempo', 'unidades_de_medida'));
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
        $request->validate([
            'nombre_receta' => ['required', 'string'],
            'porciones' => ['required','numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'tiempo_preparacion' => ['required', 'integer'],
            'unidad_de_tiempo' => ['required', 'integer'],
            'preparacion' => ['required', 'string'],
            'ingredientes_seleccionados' => ['array', 'sometimes'],
            'alimentos' => ['sometimes', 'array'],
            'cantidades' => ['sometimes', 'array'],
            'unidades_de_medida' => ['sometimes', 'array'],
        ]);

        $nombre_receta = $request->input('nombre_receta');
        $porciones = $request->input('porciones');
        $tiempo_preparacion = $request->input('tiempo_preparacion');
        $unidad_de_tiempo = $request->input('unidad_de_tiempo');
        $recursos_externos = $request->input('recursos_externos');
        $preparacion = $request->input('preparacion');
        $ingredientes_seleccionados = $request->input('ingredientes_seleccionados');
        $alimentos = $request->input('alimentos');
        $cantidades = $request->input('cantidades');
        $unidades_de_medida = $request->input('unidades_de_medida');

        $receta = Receta::create([
            'nombre_receta' => $nombre_receta,
            'porciones' => $porciones,
            'tiempo_preparacion' => $tiempo_preparacion,
            'unidad_de_tiempo_id' => $unidad_de_tiempo,
            'recursos_externos' => $recursos_externos,
            'preparacion' => $preparacion,
        ]);

        if (!is_null($ingredientes_seleccionados) && count($ingredientes_seleccionados) > 0) {
            foreach($ingredientes_seleccionados as $ingredienteSeleccionado){
                $ingrediente = Ingrediente::find($ingredienteSeleccionado);
                $ingredienteCreado = Ingrediente::create([
                    'receta_id' => $receta->id,
                    'alimento_id' => $ingrediente->alimento_id,
                    'cantidad' => $ingrediente->cantidad,
                    'unidad_medida_por_comida_id' => $ingrediente->unidad_medida_por_comida_id,
                ]);

                if(!$ingredienteCreado){
                    return redirect()->route('gestion-recetas.index')->with('error', 'Error al registrar el ingrediente.');
                }
            }
        }

        if (!is_null($alimentos) && !is_null($cantidades) && !is_null($unidades_de_medida) &&
            count($alimentos) > 0 && count($cantidades) > 0 && count($unidades_de_medida) > 0) {
                for($i = 0; $i < count($alimentos); $i++){
                    $ingredienteCreado = Ingrediente::create([
                        'receta_id' => $receta->id,
                        'alimento_id' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'unidad_medida_por_comida_id' => $unidades_de_medida[$i],
                    ]);
                    if(!$ingredienteCreado){
                        return redirect()->route('gestion-recetas.index')->with('error', 'Error al registrar el ingrediente.');
                    }
                }
        }

        if(!$receta){
            return redirect()->route('gestion-recetas.index')->with('error', 'Error al crear la receta');
        }

        return redirect()->route('gestion-recetas.index')->with('success', 'Receta creada exitosamente');

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
        $receta = Receta::find($id);

         // Almacenar los ingredientes seleccionados antes de la actualización
        $ingredientes_seleccionados_anteriores = $receta->ingredientes->pluck('id')->toArray();
        session(['ingredientes_seleccionados_anteriores' => $ingredientes_seleccionados_anteriores]);

        $request->validate([
            'nombre_receta' => ['required', 'string'],
            'porciones' => ['required','numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'tiempo_preparacion' => ['required', 'integer'],
            'unidad_de_tiempo' => ['required', 'integer'],
            'preparacion' => ['required', 'string'],
            'ingredientes_seleccionados' => ['array', 'sometimes'],
            'alimentos' => ['sometimes', 'array'],
            'cantidades' => ['sometimes', 'array'],
            'unidades_de_medida' => ['sometimes', 'array'],
        ]);

        $nombre_receta = $request->input('nombre_receta');
        $porciones = $request->input('porciones');
        $tiempo_preparacion = $request->input('tiempo_preparacion');
        $unidad_de_tiempo = $request->input('unidad_de_tiempo');
        $recursos_externos = $request->input('recursos_externos');
        $preparacion = $request->input('preparacion');
        $ingredientes_seleccionados = $request->input('ingredientes_seleccionados');
        $alimentos = $request->input('alimentos');
        $cantidades = $request->input('cantidades');
        $unidades_de_medida = $request->input('unidades_de_medida');

        $receta->nombre_receta = $nombre_receta;
        $receta->porciones = $porciones;
        $receta->tiempo_preparacion = $tiempo_preparacion;
        $receta->unidad_de_tiempo_id = $unidad_de_tiempo;
        $receta->recursos_externos = $recursos_externos;
        $receta->preparacion = $preparacion;
        $receta->save();

        if(!$receta){
            return redirect()->route('gestion-recetas.index')->with('error', 'Error al crear la receta');
        }

        // Comparar con los ingredientes después de la actualización
        $ingredientes_seleccionados_anteriores = session('ingredientes_seleccionados_anteriores', []);
        $ingredientes_seleccionados_nuevos = $request->input('ingredientes_seleccionados', []);

        // Eliminar ingredientes desmarcados si es necesario
        if (!empty($ingredientes_seleccionados_anteriores)) {
            $ingredientes_desmarcados = array_diff($ingredientes_seleccionados_anteriores, $ingredientes_seleccionados_nuevos);

            if (!empty($ingredientes_desmarcados)) {
                Ingrediente::whereIn('id', $ingredientes_desmarcados)->delete();
            }
        }


        // Crear ingredientes nuevos si es necesario
        if (!is_null($ingredientes_seleccionados_nuevos)) {
            foreach($ingredientes_seleccionados_nuevos as $ingredienteSeleccionado){
                $ingrediente = Ingrediente::find($ingredienteSeleccionado);
                $ingredienteCreado = Ingrediente::create([
                    'receta_id' => $receta->id,
                    'alimento_id' => $ingrediente->alimento_id,
                    'cantidad' => $ingrediente->cantidad,
                    'unidad_medida_por_comida_id' => $ingrediente->unidad_medida_por_comida_id,
                ]);

                if(!$ingredienteCreado){
                    return redirect()->route('gestion-recetas.index')->with('error', 'Error al registrar el ingrediente.');
                }
            }
        }

        if (!is_null($alimentos) && !is_null($cantidades) && !is_null($unidades_de_medida) &&
            count($alimentos) > 0 && count($cantidades) > 0 && count($unidades_de_medida) > 0) {
                for($i = 0; $i < count($alimentos); $i++){
                    $ingredienteCreado = Ingrediente::create([
                        'receta_id' => $receta->id,
                        'alimento_id' => $alimentos[$i],
                        'cantidad' => $cantidades[$i],
                        'unidad_medida_por_comida_id' => $unidades_de_medida[$i],
                    ]);
                    if(!$ingredienteCreado){
                        return redirect()->route('gestion-recetas.index')->with('error', 'Error al registrar el ingrediente.');
                    }
                }
        }


        return redirect()->route('gestion-recetas.index')->with('success', 'Receta actualizada exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receta = Receta::find($id);
        $receta->delete();
        return redirect()->route('gestion-recetas.index')->with('success', 'Receta eliminada exitosamente');
    }
}
