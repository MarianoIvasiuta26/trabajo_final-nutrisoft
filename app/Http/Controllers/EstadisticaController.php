<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\AlimentoPorTipoDeDieta;
use App\Models\AlimentosRecomendadosPorDieta;
use App\Models\DetallePlanAlimentaciones;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\PlanAlimentaciones;
use App\Models\Tag;
use App\Models\TagsDiagnostico;
use App\Models\TipoConsulta;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
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

        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $historiasClinicas = HistoriaClinica::all();
        $tipoConsultas = TipoConsulta::all();

        $todosTags = Tag::all();
        $tagsPorDiagnostico = TagsDiagnostico::all();

        // Obtener las etiquetas y la cantidad de veces que se usan
        $etiquetasYCantidad = $this->obtenerEtiquetasYCantidad();

        // Usar los resultados en tu vista
        $labels2 = $etiquetasYCantidad['tagsUsadas'];
        $cantidadTags = $etiquetasYCantidad['cantidadTags'];

        // Obtener el porcentaje de cada tag desde la base de datos en la tabla TagsDiagnosticos
        $porcentajeTags = Tag::join('tags_diagnosticos', 'tags.id', '=', 'tags_diagnosticos.tag_id')
            ->groupBy('tags_diagnosticos.tag_id', 'tags.name')
            ->selectRaw('tags.name, count(*) * 100 / (select count(*) from tags_diagnosticos) as porcentaje')
            ->pluck('porcentaje', 'name');


        // Obtener las etiquetas y datos para el gráfico
        $data2 = $porcentajeTags->values(); // Porcentaje de cada tag

        //---------------------3er Gráfico - Alimentos Recomendados---------------------//

        $alimentos = Alimento::all();
        $detallesPlanAlimentación = DetallePlanAlimentaciones::all();

        $alimentosYCantidad = $this->obtenerAlimentosYCantidad();

        // Usar los resultados en tu vista
        $labels3 = $alimentosYCantidad['alimentosUsados'];
        $data3 = $alimentosYCantidad['cantidadAlimentos'];

        return view('admin.estadisticas.index', compact(
                'labels', 'data', 'fechaInicio', 'fechaFin', 'labels2', 'data2', 'todosTratamientos', 'tratamientosPorPaciente',
                'turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas', 'todosTags', 'tagsPorDiagnostico', 'cantidadTags',
                'labels3', 'data3', 'alimentos', 'detallesPlanAlimentación'
            )
        );
    }

    private function obtenerEtiquetasYCantidad($fechaInicio = null, $fechaFin = null)
    {
        // Lógica para obtener las etiquetas usadas
        $tagsUsadas = Tag::join('tags_diagnosticos', 'tags.id', '=', 'tags_diagnosticos.tag_id')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween(DB::raw('DATE(tags_diagnosticos.created_at)'), [$fechaInicio, $fechaFin]);
            })
            ->distinct()
            ->pluck('tags.name');

        // Lógica para obtener la cantidad de veces que se usó cada etiqueta
        $cantidadTags = Tag::join('tags_diagnosticos', 'tags.id', '=', 'tags_diagnosticos.tag_id')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween(DB::raw('DATE(tags_diagnosticos.created_at)'), [$fechaInicio, $fechaFin]);
            })
            ->groupBy('tags_diagnosticos.tag_id', 'tags.name')
            ->selectRaw('tags.name, count(*) as porcentaje')
            ->distinct()
            ->pluck('porcentaje', 'name');

        return compact('tagsUsadas', 'cantidadTags');
    }

    private function obtenerAlimentosYCantidad($fechaInicio = null, $fechaFin = null)
    {
        // Lógica para obtener los alimentos recomendados
        $alimentosUsados = Alimento::join('detalle_plan_alimentaciones', 'alimentos.id', '=', 'detalle_plan_alimentaciones.alimento_id')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween(DB::raw('DATE(detalle_plan_alimentaciones.created_at)'), [$fechaInicio, $fechaFin]);
            })
            ->distinct()
            ->pluck('alimentos.alimento');

        // Lógica para obtener la cantidad de veces que se usó cada alimento
        $cantidadAlimentos = Alimento::join('detalle_plan_alimentaciones', 'alimentos.id', '=', 'detalle_plan_alimentaciones.alimento_id')
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween(DB::raw('DATE(detalle_plan_alimentaciones.created_at)'), [$fechaInicio, $fechaFin]);
            })
            ->groupBy('detalle_plan_alimentaciones.alimento_id', 'alimentos.alimento')
            ->selectRaw('alimentos.alimento, count(*) as porcentaje')
            ->distinct()
            ->pluck('porcentaje', 'alimento');

        return compact('alimentosUsados', 'cantidadAlimentos');
    }

    public function filtrosTratamiento(Request $request)
    {
        // Obtener todas los tratamientos
        $todosTratamientos = Tratamiento::all();

        // Obtener las fechas de inicio y fin desde la solicitud
        /*
        $tratamientoFilters = session('tratamientoFilters', []);
        $fechaInicio = $tratamientoFilters['fecha_inicio'] ?? null;
        $fechaFin = $tratamientoFilters['fecha_fin'] ?? null;
        */

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

        // Almacena los filtros en variables de sesión
        session(['tratamientoFilters' => $request->all()]);

        /*

        return view('admin.estadisticas.index', compact(
                'labels', 'data','todosTratamientos', 'tratamientosPorPaciente',
                'turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas', 'todosTags', 'tagsPorDiagnostico',
                'labels2', 'data2', 'fechaInicio', 'fechaFin'
            )
        )->with(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
        */

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'todosTratamientos' => $todosTratamientos,
            'tratamientosPorPaciente' => $tratamientosPorPaciente
        ]);
    }

    public function filtrosTag(Request $request)
    {
        //---------------------2do Gráfico - Tags de Diagnósticos---------------------//
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $todosTags = Tag::all();

        // Obtener las fechas de inicio y fin desde la solicitud
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Obtener las etiquetas y la cantidad de veces que se usan con filtros
        $etiquetasYCantidad = $this->obtenerEtiquetasYCantidad($fechaInicio, $fechaFin);

        // Usar los resultados en tu vista
        $labels2 = $etiquetasYCantidad['tagsUsadas'];
        $cantidadTags = $etiquetasYCantidad['cantidadTags'];

        $porcentajeTags = Tag::join('tags_diagnosticos', 'tags.id', '=', 'tags_diagnosticos.tag_id')
            ->whereBetween(DB::raw('DATE(tags_diagnosticos.created_at)'), [$fechaInicio, $fechaFin])
            ->groupBy('tags_diagnosticos.tag_id', 'tags.name')
            ->selectRaw('tags.name, count(*) * 100 / (select count(*) from tags_diagnosticos where DATE(created_at) between ? and ?) as porcentaje', [$fechaInicio, $fechaFin])
            ->pluck('porcentaje', 'name');

        $data2 = $porcentajeTags->values(); // Porcentaje de cada tag

        $tagsPorDiagnostico = TagsDiagnostico::whereBetween(DB::raw('DATE(created_at)'), [$fechaInicio, $fechaFin])->get();

        // Almacena los filtros en variables de sesión
        session(['tagsFilters' => $request->all()]);

        /*

        return view('admin.estadisticas.index', compact(
                'turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas', 'labels2', 'data2', 'tagsPorDiagnostico', 'todosTags', 'cantidadTags'

            )
        )->with(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
        */

        return response()->json([
            'labels2' => $labels2,
            'data2' => $data2,
            'tagsPorDiagnostico' => $tagsPorDiagnostico,
            'todosTags' => $todosTags,
            'cantidadTags' => $cantidadTags
        ]);
    }

    public function clearTratamientoFilters()
    {
        session()->forget('tratamientoFilters');
        session()->forget('tratamientoFilters');
        return $this->index();
    }

    public function clearTagsFilters()
    {
        session()->forget('tagsFilters');
        return $this->index();
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
