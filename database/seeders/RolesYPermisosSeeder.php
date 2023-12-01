<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    /* Creación de roles
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Nutricionista']);
        $role3 = Role::create(['name' => 'Paciente']);
    */

        //Obtenemos roles
        $role1 = Role::where('name', '=', 'Admin')->first();
        $role2 = Role::where('name', '=', 'Nutricionista')->first();
        $role3 = Role::where('name', '=', 'Paciente')->first();

        //Obtenemos per

        $permission1 = Permission::create(['name' => 'gestion-usuarios.index'])->assignRole($role1);
        $permission2 = Permission::create(['name' => 'gestion-usuarios.create'])->assignRole($role1);
        $permission3 = Permission::create(['name' => 'gestion-usuarios.edit'])->assignRole($role1);
        $permission4 = Permission::create(['name' => 'gestion-usuarios.destroy'])->assignRole($role1);
    }
}
