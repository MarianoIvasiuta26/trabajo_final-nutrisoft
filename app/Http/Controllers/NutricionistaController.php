<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\Nutricionista;
use Illuminate\Http\Request;

class NutricionistaController extends Controller
{

    public function index()
    {
        $nutricionista = auth()->user()->nutricionista; // Obtener la nutricionista actualmente autenticada
        $dias = $nutricionista->diasAtencion; // Obtener los días de atención de la nutricionista

        return view ('nutricionista.atencion.index', compact('nutricionista', 'dias'));
    }


    public function consultaForm()
    {
        $nutricionista = auth()->user()->nutricionista; // Obtener la nutricionista actualmente autenticada
        return view('nutricionista.atencion.consulta', compact('nutricionista'));
    }

    public function guardarHorarios(Request $request)
    {
        $request->validate([
            'hora_inicio_maniana' => 'required|date_format:H:i',
            'hora_fin_maniana' => 'required|date_format:H:i',
            'hora_inicio_tarde' => 'required|date_format:H:i',
            'hora_fin_tarde' => 'required|date_format:H:i',
        ]);

        $nutricionista = auth()->user()->nutricionista; // Obtener la nutricionista actualmente autenticada

        // Actualizar los campos de hora
        $nutricionista->update($request->only([
            'hora_inicio_maniana',
            'hora_fin_maniana',
            'hora_inicio_tarde',
            'hora_fin_tarde',
        ]));

        // Obtener los días seleccionados
        $diasAtencion = $request->input('dias_atencion');

        // Eliminar los registros existentes de días de atención para esta nutricionista
        $nutricionista->diasAtencion()->delete();

        // Crear nuevos registros solo si se han seleccionado días
        if (!empty($diasAtencion)) {
            $dias = [];
            foreach ($diasAtencion as $dia) {
                $dias[] = ['dia' => $dia];
            }
            $nutricionista->diasAtencion()->createMany($dias);
        }

        return redirect()->route('gestion-atencion.index')->with('success', 'Horarios de consulta y días de atención actualizados correctamente');
    }


    public function destroy($id)
    {
        $nutricionista = Nutricionista::find($id);

        if (!$nutricionista) {
            return redirect()->route('gestion-atencion.index')->with('error', 'Nutricionista no encontrado');
        }

        // Elimina los registros de días de atención asociados a este nutricionista
        $nutricionista->diasAtencion()->delete();

        // Luego, elimina los campos de horas
        $nutricionista->hora_inicio_maniana = null;
        $nutricionista->hora_fin_maniana = null;
        $nutricionista->hora_inicio_tarde = null;
        $nutricionista->hora_fin_tarde = null;
        $nutricionista->save();

        return redirect()->route('gestion-atencion.index')->with('success', 'Días de atención y horarios eliminados correctamente');
    }



}
