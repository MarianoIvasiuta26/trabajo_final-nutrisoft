<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
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
    public function index(Request $request)
    {
        $fechaInicio = null;
        $fechaFin = null;

        //---------------------1er Gráfico - Frecuencia de tratamientos---------------------//

        // Obtener todas los tratamientos
        $todosTratamientos = Tratamiento::all();
        $tratamientosPorPaciente = TratamientoPorPaciente::all();

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

        //---------------------2do Gráfico - Tags de Diagnósticos---------------------//

        $todosTags = Tag::all();

        // Obtener el porcentaje de cada tag desde la base de datos en la tabla TagsDiagnosticos
        $porcentajeTags = Tag::join('tags_diagnosticos', 'tags.id', '=', 'tags_diagnosticos.tag_id')
            ->groupBy('tags_diagnosticos.tag_id', 'tags.name')
            ->selectRaw('tags.name, count(*) * 100 / (select count(*) from tags_diagnosticos) as porcentaje')
            ->pluck('porcentaje', 'name');

        // Completar el porcentaje con tags que no tienen registros
        $porcentajeCompleto = $todosTags->map(function ($tag) use ($porcentajeTags) {
            $nombreTag = $tag->name;
            $porcentaje = $porcentajeTags->get($nombreTag, 0);
            return $porcentaje;
        });

        // Obtener las etiquetas y datos para el gráfico
        $labels2 = $todosTags->pluck('name'); // Nombres de los tags
        $data2 = $porcentajeCompleto->values(); // Porcentaje de cada tag


        return view('estadisticas.index', compact('labels', 'data', 'fechaInicio', 'fechaFin', 'labels2', 'data2', 'todosTratamientos', 'tratamientosPorPaciente'));
    }

    public function filtros(Request $request)
    {
        // Obtener todas los tratamientos
        $todosTratamientos = Tratamiento::all();

        // Obtener las fechas de inicio y fin desde la solicitud
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Lógica para filtrar por fechas en tu consulta
        $frecuenciaTratamientos = TratamientoPorPaciente::join('tratamientos', 'tratamientos.id', '=', 'tratamiento_por_pacientes.tratamiento_id')
            ->whereBetween('tratamiento_por_pacientes.fecha_alta', [$fechaInicio, $fechaFin])
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
        // dd($labels, $data);

        $tratamientosPorPaciente = TratamientoPorPaciente::where('fecha_alta', '>=', $fechaInicio)
            ->where('fecha_alta', '<=', $fechaFin)
            ->get();

        return view('estadisticas.index', compact('labels', 'data','todosTratamientos', 'tratamientosPorPaciente'))->with(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
    }

    public function clearFilters()
    {
        return redirect()->route('gestion-estadisticas.index');
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
