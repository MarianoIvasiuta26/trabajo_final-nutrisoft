<?php

namespace App\Http\Controllers\nutricionista;

use App\Http\Controllers\Controller;
use App\Models\Alimento;
use App\Models\Consulta;
use App\Models\DetallePlanAlimentaciones;
use App\Models\Diagnostico;
use App\Models\MedicionesDePlieguesCutaneos;
use App\Models\Paciente;
use App\Models\Paciente\Alergia;
use App\Models\Paciente\AnamnesisAlimentaria;
use App\Models\Paciente\Cirugia;
use App\Models\Paciente\CirugiasPaciente;
use App\Models\Paciente\DatosMedicos;
use App\Models\Paciente\HistoriaClinica;
use App\Models\Paciente\Intolerancia;
use App\Models\Paciente\Patologia;
use App\Models\PlanAlimentaciones;
use App\Models\Tag;
use App\Models\TagsDiagnostico;
use App\Models\TipoConsulta;
use App\Models\TiposDePliegueCutaneo;
use App\Models\Tratamiento;
use App\Models\TratamientoPorPaciente;
use App\Models\Turno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestionTurnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnos = Turno::all();
        $pacientes = Paciente::all();

        $fechaActual = Carbon::now()->format('Y-m-d');

        return view ('nutricionista.gestion-turnos.index', compact('turnos', 'pacientes', 'fechaActual'));
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

    public function showHistorialTurnos() {
        $fechaInicio = null; //Fecha necesarias para las estadísticas
        $fechaFin = null; //Fecha necesarias para las estadísticas

        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $historiasClinicas = HistoriaClinica::all();
        $tipoConsultas = TipoConsulta::all();

        //---------------------2do Gráfico - Tags de Diagnósticos---------------------//

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

        return view('nutricionista.gestion-turnos.showHistorialTurno', compact('turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas', 'fechaInicio', 'fechaFin', 'data2', 'labels2', 'todosTags', 'tagsPorDiagnostico', 'cantidadTags'));
    }


    public function filtros(Request $request)
    {
        $todosTags = Tag::all();

        $turnos = Turno::all();
        $pacientes = Paciente::all();
        $historiasClinicas = HistoriaClinica::all();
        $tipoConsultas = TipoConsulta::all();

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

        return view('nutricionista.gestion-turnos.showHistorialTurno', compact('turnos', 'pacientes', 'historiasClinicas', 'tipoConsultas', 'labels2', 'data2', 'tagsPorDiagnostico', 'todosTags', 'cantidadTags'))->with(['fechaInicio' => $fechaInicio, 'fechaFin' => $fechaFin]);
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


    public function clearFilters()
    {
        return redirect()->route('gestion-turnos-nutricionista.showHistorialTurnos');
    }


    public function iniciarConsulta($id){
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'No se encontró el turno');
        }

        $paciente = Paciente::where('id', $turno->paciente_id)->first();

        if(!$paciente){
            return redirect()->back()->with('error', 'No se encontró el paciente');
        }

        $tipoConsultas = TipoConsulta::all();
        $historiaClinica = HistoriaClinica::where('paciente_id', $paciente->id)->first();
        $datosMedicos = DatosMedicos::where('historia_clinica_id', $historiaClinica->id)->get();
        $alergias = Alergia::all();
        $patologias = Patologia::all();
        $intolerancias = Intolerancia::all();

        $cirugias = Cirugia::all();
        $cirugiasPaciente = CirugiasPaciente::where('historia_clinica_id', $historiaClinica->id)->get();

        $tratamientos = Tratamiento::all();
        $plieguesCutaneos = TiposDePliegueCutaneo::all();

        $turnosPaciente = Turno::where('paciente_id', $paciente->id)->where('estado', 'Realizado')->get();
        $consultasPaciente = Consulta::all();
        $tratamientosPaciente = TratamientoPorPaciente::where('paciente_id', $paciente->id)->get();

        $diagnosticos = Diagnostico::all();
        $tags = Tag::all();
        $tagsDiagnosticos = TagsDiagnostico::all();

        $planesAlimentacionPaciente = PlanAlimentaciones::where('paciente_id', $paciente->id)->get();
        $planesAlimentacionPaciente = $planesAlimentacionPaciente->sortByDesc(function ($plan) {
            return Carbon::parse($plan->consulta->turno->fecha);
        });
        $detallesPlanesPlanes = DetallePlanAlimentaciones::all();
        $alimentos = Alimento::all();

        $anamnesisPaciente = AnamnesisAlimentaria::where('historia_clinica_id', $historiaClinica->id)->get();

        $turnoAnteriorPaciente = Turno::where('paciente_id', $paciente->id)->where('estado', 'Realizado')->orderBy('id', 'desc')->first();
        if($turnoAnteriorPaciente){
            $consultaAnteriorPaciente = Consulta::where('turno_id', $turnoAnteriorPaciente->id)->first();
            $diagnosticoAnteriorPaciente = Diagnostico::where('consulta_id', $consultaAnteriorPaciente->id)->first();
            $medidaPliegueTricep = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 1)->orderBy('id', 'desc')->first();
            $medidaPliegueBicep = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 3)->orderBy('id', 'desc')->first();
            $medidaPliegueSubescapular = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 4)->orderBy('id', 'desc')->first();
            $medidaPliegueSuprailiaco = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 5)->orderBy('id', 'desc')->first();
            $medidaDiametroHumero = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 6)->orderBy('id', 'desc')->first();
            $medidaDiametroMunieca = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 7)->orderBy('id', 'desc')->first();
            $medidaDiametroFemur = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 8)->orderBy('id', 'desc')->first();
            $medidaDiametroTobillo = MedicionesDePlieguesCutaneos::where('consulta_id', $consultaAnteriorPaciente->id)->where('tipos_de_pliegue_cutaneo_id', 9)->orderBy('id', 'desc')->first();

            $ultimoPlanAlimentacionPaciente = PlanAlimentaciones::where('paciente_id', $paciente->id)->where('estado', 1)->orderBy('id', 'desc')->first();


            return view('nutricionista.gestion-turnos.gestion-consultas.registrarConsulta', compact('paciente', 'turno', 'tipoConsultas', 'historiaClinica', 'datosMedicos', 'alergias', 'intolerancias', 'patologias', 'cirugias', 'cirugiasPaciente', 'tratamientos', 'plieguesCutaneos', 'turnosPaciente', 'tratamientosPaciente', 'turnoAnteriorPaciente', 'consultaAnteriorPaciente', 'medidaPliegueTricep', 'medidaPliegueBicep', 'medidaPliegueSubescapular', 'medidaPliegueSuprailiaco', 'medidaDiametroHumero', 'medidaDiametroMunieca', 'medidaDiametroFemur', 'medidaDiametroTobillo', 'tags', 'ultimoPlanAlimentacionPaciente', 'planesAlimentacionPaciente', 'detallesPlanesPlanes', 'diagnosticos', 'tagsDiagnosticos', 'diagnosticoAnteriorPaciente', 'consultasPaciente', 'alimentos', 'anamnesisPaciente'));

        }



        if(!$historiaClinica){
            return redirect()->back()->with('error', 'No se encontró la historia clínica');
        }

        return view('nutricionista.gestion-turnos.gestion-consultas.registrarConsulta', compact('paciente', 'turno', 'tipoConsultas', 'historiaClinica', 'datosMedicos', 'alergias', 'intolerancias', 'patologias', 'cirugias', 'cirugiasPaciente',   'tratamientos', 'plieguesCutaneos', 'turnosPaciente', 'tratamientosPaciente', 'tags', 'planesAlimentacionPaciente', 'detallesPlanesPlanes', 'diagnosticos', 'tagsDiagnosticos', 'consultasPaciente', 'alimentos', 'anamnesisPaciente'));
    }

    public function confirmarInasistencia($id){
        $turno = Turno::find($id);

        if(!$turno){
            return redirect()->back()->with('error', 'No se encontró el turno');
        }

        $turno->estado = 'Inasistencia';
        $turno->save();

        return redirect()->back()->with('success', 'Se confirmó la inasistencia del paciente');

    }
}
