<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\HorariosAtencion;
use Illuminate\Http\Request;

class DiaController extends Controller
{
    public function index(){

            $dias = DiasAtencion::all();

            return view('nutricionista.atencion.index', compact('dias'));
    }
}
