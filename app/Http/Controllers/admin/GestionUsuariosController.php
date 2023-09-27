<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\RegistroNutricionista;
use App\Models\Administrador;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class GestionUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::All();
        return view('admin.gestion-usuarios.index')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gestion-usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'apellido' => ['required', 'string', 'max:50'],
            'tipo_usuario' => ['required', 'string', 'max:15'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $passwordTemporal = Str::random(8); //Se genera una contraseña aleatoria de 8 caracteres

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'apellido' => $request['apellido'],
            'password' => Hash::make($passwordTemporal),
            'tipo_usuario' => $request['tipo_usuario'],
        ]);

        if ($request['tipo_usuario'] === 'Paciente') {
            Paciente::create(['user_id' => $user->id]);
        } elseif ($request['tipo_usuario'] === 'Administrador') {
            Administrador::create(['user_id' => $user->id]);
        } elseif ($request['tipo_usuario'] === 'Nutricionista') {
            $nutricionista = Nutricionista::create(['user_id' => $user->id, 'registrado' => false]);

            if ($nutricionista) {
                // Se envía el correo de completar registro solo si $nutricionista no es null
                Mail::to($nutricionista->user->email)->send(new RegistroNutricionista($nutricionista));
            } else {
                return redirect()->route('gestion-usuarios.index')->with('error', 'Error al crear el usuario');
            }
        }

        return redirect()->route('gestion-usuarios.index')->with('success', 'Usuario guardado correctamente');
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
        $usuario = User::find($id);
        return view('admin.gestion-usuarios.edit')->with('usuario', $usuario);
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
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id], // Asegura que el email sea único, excluyendo el usuario actual.
            'apellido' => ['required', 'string', 'max:20'],
            'tipo_usuario' => ['required', 'string', 'max:15'],
        ])->validate();

        // Encuentra el usuario que deseas actualizar
        $user = User::find($id);

        if ($user) {
            // Actualiza los campos del usuario
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->apellido = $request->input('apellido');
            $user->tipo_usuario = $request->input('tipo_usuario');

            // Guarda los cambios en la base de datos
            $user->save();

            return redirect()->route('gestion-usuarios.index')->with('success', 'Usuario actualizado correctamente');
        } else {
            return redirect()->route('gestion-usuarios.index')->with('error', 'Usuario no encontrado');
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
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect()->route('gestion-usuarios.index')->with('error', 'Usuario no encontrado');
        }

        // Realiza la eliminación del usuario
        $usuario->delete();

        // Redirecciona de nuevo a la lista de usuarios con un mensaje de éxito
        return redirect()->route('gestion-usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
