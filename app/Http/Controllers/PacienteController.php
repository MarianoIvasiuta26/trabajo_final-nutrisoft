<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paciente\HistoriaClinica;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    function hasCompletedHistory() {
        // Obtén el ID del paciente autenticado.
        $pacienteId = auth()->user()->paciente->id;

        // Verifica si existe un registro en la tabla 'historias_clinicas' para el paciente.
        $history = HistoriaClinica::where('paciente_id', $pacienteId)->first();

        // Si se encuentra un registro, el paciente ha completado la Historia Clínica.
        return $history !== null;
    }
}
