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

        return view('admin.auditoria.index', compact('audits', 'fechaDesde', 'fechaHasta'));
    }

    public function filtros(Request $request)
    {
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

        return view('admin.auditoria.index', compact('audits', 'fechaDesde', 'fechaHasta'));
    }

    public function clearFilters()
    {
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
