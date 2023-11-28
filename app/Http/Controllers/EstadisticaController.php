<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */

     //@return \Illuminate\Http\Response
    public function index()
    {

       // Obtener todas los tratamientos
       $todosTratamientos = Tratamiento::all();

       // Obtener la frecuencia de cada tratamiento desde la base de datos
       $frecuenciaTratamientos = TratamientoPorPaciente::join('tratamientos', 'tratamientos.id', '=', 'tratamiento_por_pacientes.tratamiento_id')
           ->groupBy('tratamiento_por_pacientes.tratamiento_id', 'tratamientos.tratamiento')
           ->selectRaw('tratamientos.tratamiento, count(*) as total')
           ->pluck('total', 'tratamiento');

       // Completar la frecuencia con tratamientos que no tienen registros
       $frecuenciaCompleta = $todosTratamientos->map(function ($tratamiento) use ($frecuenciaTratamientos) {
           $nombreTratamiento = $tratamiento->tratamiento;
           $frecuencia = $frecuenciaTratamientos->get($nombreTratamiento, 0);
           return $frecuencia;
       });

       // Obtener las etiquetas y datos para el gráfico
       $labels = $todosTratamientos->pluck('tratamiento'); // Nombres de los tratamientos
       $data = $frecuenciaCompleta->values(); // Frecuencia de cada tratamiento

       // Agrega un dd para verificar los datos
       //dd($labels, $data);

       return view('estadisticas.index', compact('labels', 'data'));
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
        //
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
