<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TiposActividadesPorTratamientos;
use App\Models\TiposDeActividades;
use App\Models\TiposDeDieta;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use Illuminate\Http\Request;

class TratramientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    //@return \Illuminate\Http\Response
    public function index()
    {
        $tratamientos = Tratamiento::all();

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

        return view('nutricionista.gestion-tratamientos.index', compact('tratamientos', 'labels', 'data', 'fechaInicio', 'fechaFin', 'todosTratamientos', 'tratamientosPorPaciente'));
    }

    public function filtros(Request $request)
    {

        $tratamientos = Tratamiento::all();

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

        return view('nutricionista.gestion-tratamientos.index', compact('tratamientos','labels', 'data','todosTratamientos', 'tratamientosPorPaciente'))->with(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
    }

    public function clearFilters()
    {
        return $this->index();
    }

    /**
     * Show the form for creating a new resource.
     *
     *
     */
    //@return \Illuminate\Http\Response
    public function create()
    {
        $tiposDeDietas = TiposDeDieta::all();
        $tiposActividades = TiposDeActividades::all();
        return view('nutricionista.gestion-tratamientos.create', compact('tiposDeDietas','tiposActividades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     *
     */
     //@param  \Illuminate\Http\Request  $request
     //@return \Illuminate\Http\Response
    public function store(Request $request)
    {
        $request->validate([
            'tratamiento' => ['required', 'string', 'max:50'],
            'tipo_de_dieta' => ['required', 'integer'],
            'actividades' => ['array', 'required']
        ]);

        $tratamiento = $request->input('tratamiento');
        $tipoDeDieta = $request->input('tipo_de_dieta');

        $tiposActividades = $request->input('actividades');

        $tratamientoCreado = Tratamiento::create([
            'tratamiento' => $tratamiento,
            'tipo_de_dieta_id'=> $tipoDeDieta
        ]);

        if($tratamientoCreado){
            foreach($tiposActividades as $tipoActividad){
                TiposActividadesPorTratamientos::create([
                    'tratamiento_id' => $tratamientoCreado->id,
                    'tipo_actividad_id' => $tipoActividad
                ]);
            }

            return redirect()->route('gestion-tratamientos.index')->with('success', 'Tratamiento creado correctamente');

        } else {
            return redirect()->back()->with('error', 'Error al crear el tratamiento');
        }

    }

    /**
     * Display the specified resource.
     **/
     //@param  int  $id
     //@return \Illuminate\Http\Response

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     //@param  int  $id
     //@return \Illuminate\Http\Response

    public function edit($id)
    {
        // Buscamos el tratamiento
        $tratamiento = Tratamiento::find($id);
        $tiposDeDietas = TiposDeDieta::all();
        $tiposActividades = TiposDeActividades::all();
        $tiposActividadesSeleccionadas = TiposActividadesPorTratamientos::where('tratamiento_id', $tratamiento->id)->get();

        // Si no existe lanzamos error
        if(!$tratamiento){
            return redirect()->back()->with('error', 'Error al encontrar el tratamiento a editar');
        }

        // Si existe retornamos la vista con el tratamiento
        return view('nutricionista.gestion-tratamientos.edit', compact('tratamiento', 'tiposDeDietas', 'tiposActividades','tiposActividadesSeleccionadas'));
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
        $tratamiento = Tratamiento::find($id);

        if(!$tratamiento){
            return redirect()->back()->with('error', 'Tratamiento no encontrado');
        }

        $request->validate([
            'tratamiento' => ['required', 'string', 'max:50'],
            'tipo_de_dieta' => ['required', 'integer'],
            'actividades' => ['array', 'required']
        ]);

        $tratamiento->tratamiento = $request->input('tratamiento');
        $tratamiento->tipo_de_dieta_id = $request->input('tipo_de_dieta');

        $tiposActividadesPorTratamiento = TiposActividadesPorTratamientos::where('tratamiento_id',$tratamiento->id)->pluck('tipo_actividad_id');

        // Actividades a agregar
        $actividadesNuevas = collect($request->input('actividades'))
            ->diff($tiposActividadesPorTratamiento)
            ->toArray();

        // Actividades a eliminar
        $actividadesEliminar = $tiposActividadesPorTratamiento
            ->diff($request->input('actividades'))
            ->toArray();

        // Agregar nuevas actividades
        foreach ($actividadesNuevas as $actividadNueva) {
            TiposActividadesPorTratamientos::create([
                'tratamiento_id' => $tratamiento->id,
                'tipo_actividad_id' => $actividadNueva,
            ]);
        }

        // Eliminar actividades que ya no están en la solicitud actual
        TiposActividadesPorTratamientos::where('tratamiento_id', $tratamiento->id)
            ->whereIn('tipo_actividad_id', $actividadesEliminar)
            ->delete();


        if($tratamiento->save()){
            return redirect()->route('gestion-tratamientos.index')->with('success', 'Tratamiento actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el tratamiento');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tratamiento = Tratamiento::find($id);

        if(!$tratamiento){
            return redirect()->back()->with('error', 'Tratamiento no encontrado');
        }

        if($tratamiento->delete()){
            return redirect()->back()->with('success', 'Tratamiento eliminado correctamente');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el tratamiento');
        }
    }
}
