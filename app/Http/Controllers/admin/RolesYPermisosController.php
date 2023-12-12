<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesYPermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::All();
        $permisos = Permission::All();


        return view('admin.gestion-roles-permisos.index', compact('roles','permisos'));
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
        $request->validate([
            'nombre' => ['required', 'string'],
            'permisos' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('nombre'),
            'guard_name' => 'web',
        ]);

        $permisos = Permission::all();

        foreach ($request->input('permisos') as $permisoNuevo) {
            foreach($permisos as $permiso){
                if($permiso->id == $permisoNuevo){
                    $role->givePermissionTo($permiso);
                }
            }
        }

        if(!$role){
            return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'Error al crear el rol.');
        }

        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Rol creado correctamente.');
    }

    public function storePermiso(Request $request){
        $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $permisos = Permission::all();

        foreach ($permisos as $permiso) {
            if($permiso->name == $request->input('nombre')){
                return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'El permiso ya existe.');
            }
        }

        $permiso = Permission::create([
            'name' => $request->input('nombre'),
            'guard_name' => 'web',
        ]);

        if(!$permiso){
            return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'Error al crear el permiso.');
        }

        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Permiso creado correctamente.');

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

        $request->validate([
            'nombre' => ['required', 'string'],
            'permisosEvaluar' => ['array'],
        ]);

        $role = Role::find($id);

        if (!$role) {
            return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'Error al actualizar el rol.');
        }

        $role->name = $request->input('nombre');
        $role->guard_name = 'web';
        $role->save();

        $permisosEvaluados = $request->input('permisosEvaluar');
        //dd($permisosEvaluados);
        // Obtener los permisos seleccionados
        if ($permisosEvaluados !== null) {
            $permisosSeleccionados = Permission::whereIn('id', $permisosEvaluados)->get();
             // Asignar los permisos al rol
            foreach ($permisosSeleccionados as $permisoNuevo) {
                if (!$role->hasPermissionTo($permisoNuevo->name)) {
                    $role->givePermissionTo($permisoNuevo);
                }
            }

        }


        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function updatePermiso(Request $request, $id)
    {
        $request->validate([
            'nombre' => ['required', 'string'],
        ]);

        $permiso = Permission::find($id);


        if(!$permiso){
            return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'Error al actualizar el permiso.');
        }

        $permiso->name = $request->input('nombre');
        $permiso->guard_name = 'web';
        $permiso->save();

        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Permiso actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();

        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Rol eliminado correctamente.');
    }

    public function destroyPermiso($id){
        $permiso = Permission::find($id);

        if(!$permiso){
            return redirect()->route('gestion-rolesYPermisos.index')->with('error', 'Error al eliminar el permiso.');
        }

        $permiso->delete();

        return redirect()->route('gestion-rolesYPermisos.index')->with('success', 'Permiso eliminado correctamente.');
    }
}
