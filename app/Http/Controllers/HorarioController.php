<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HorariosAtencion;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(){

        $horarios = HorariosAtencion::all();

        return view('nutricionista.atencion.index', compact('horarios'));

    }
}
