<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fechaDesde = null;
        $fechaHasta = null;
        $audits = Audit::orderBy('created_at', 'desc')->get();

        // Personaliza la presentación de los valores nuevo y antiguo
        foreach ($audits as $auditoria) {
            $newValuesFormatted = $this->formatValues($auditoria->new_values);
            $oldValuesFormatted = $this->formatValues($auditoria->old_values);

            $auditoria->new_value = $newValuesFormatted;
            $auditoria->old_value = $oldValuesFormatted;
        }

        $fechaInicio =null;
        $fechaFin = null;

        return view('admin.auditoria.index', compact('audits', 'fechaDesde', 'fechaHasta', 'fechaInicio', 'fechaFin'));
    }

    private function formatValues($values)
    {
        // Personaliza la lógica de formato según tus necesidades
        return implode("\n", array_map(function ($key, $value) {
            return "$key: $value";
        }, array_keys($values), $values));
    }

    public function filtros(Request $request)
    {

        $request->validate([
            'fecha_desde' => 'required',
            'fecha_hasta' => 'required',
        ]);

        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');

        // Ajusta el formato de las fechas si es necesario
        $fechaDesde = Carbon::parse($fechaDesde)->startOfDay()->format('Y-m-d H:i:s');
        $fechaHasta = Carbon::parse($fechaHasta)->endOfDay()->format('Y-m-d H:i:s');

        // Aplica el filtro en la consulta
        $audits = Audit::query();

        if ($fechaDesde && $fechaHasta) {
            $audits->whereBetween('created_at', [$fechaDesde, $fechaHasta]);
        }

        $audits = $audits->orderBy('created_at', 'desc')->get();

        // Personaliza la presentación de los valores nuevo y antiguo
        foreach ($audits as $auditoria) {
            $newValuesFormatted = $this->formatValues($auditoria->new_values);
            $oldValuesFormatted = $this->formatValues($auditoria->old_values);

            $auditoria->new_value = $newValuesFormatted;
            $auditoria->old_value = $oldValuesFormatted;
        }

        $fechaInicio = Carbon::parse($fechaDesde)->startOfDay();
        $fechaFin = Carbon::parse($fechaHasta)->endOfDay();

        return view('admin.auditoria.index', compact('audits', 'fechaDesde', 'fechaHasta', 'fechaInicio', 'fechaFin'));
    }

    public function clearFilters()
    {
        return redirect()->route('auditoria.index');
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
