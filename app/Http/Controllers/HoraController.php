<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HorasAtencion;
use Illuminate\Http\Request;

class HoraController extends Controller
{
    public function index(){

        $horas = HorasAtencion::all();

        return view('nutricionista.atencion.index', compact('horas'));

    }
}
