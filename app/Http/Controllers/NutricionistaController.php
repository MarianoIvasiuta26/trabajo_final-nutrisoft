<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiasAtencion;
use App\Models\Nutricionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NutricionistaController extends Controller
{

    public function index()
    {
        $nutricionista = Nutricionista::where('user_id', auth()->id())->first(); // Obtener la nutricionista actualmente autenticada
        return view ('nutricionista.atencion.index', compact('nutricionista'));
    }


    public function consultaForm()
    {
        $nutricionista = auth()->user()->nutricionista; // Obtener la nutricionista actualmente autenticada
        return view('nutricionista.atencion.consulta', compact('nutricionista'));
    }

    public function guardarHorarios(Request $request)
    {

    }


    public function destroy($id)
    {

    }

    public function showRegistrationForm($id){
        return view('nutricionista.completar-registro', ['nutricionistaId' => $id]);
    }

    public function completarRegistro(Request $request){
        $nutricionista = Nutricionista::find($request->nutricionista_id);
        $nutricionista->user->password = Hash::make($request->password);
        $nutricionista->registrado = true;
        $nutricionista->save();
        return redirect()->route('login')->with('success', 'Registro completado. Ahora puedes iniciar sesión.');
    }

}
