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
    /*
        $permission1 = Permission::create(['name' => 'gestion-usuarios.index'])->assignRole($role1);
        $permission2 = Permission::create(['name' => 'gestion-usuarios.create'])->assignRole($role1);
        $permission3 = Permission::create(['name' => 'gestion-usuarios.edit'])->assignRole($role1);
        $permission4 = Permission::create(['name' => 'gestion-usuarios.destroy'])->assignRole($role1);


        Permission::create(['name'=>'gestion-rolesYPermisos.index'])->assignRole($role1);
        Permission::create(['name'=>'gestion-rolesYPermisos.create'])->assignRole($role1);
        Permission::create(['name'=>'gestion-rolesYPermisos.edit'])->assignRole($role1);
        Permission::create(['name'=>'gestion-rolesYPermisos.destroy'])->assignRole($role1);

        Permission::create(['name'=>'auditoria.index'])->assignRole($role1);

        Permission::create(['name'=>'gestion-alergias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alergias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alergias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alergias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-alergias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-alergias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-alergias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-alergias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-intolerancias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-intolerancias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-intolerancias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-intolerancias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-intolerancias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-intolerancias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-intolerancias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-intolerancias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-patologias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-patologias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-patologias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-patologias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-patologias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-patologias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-patologias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-patologias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-patologias.actividades.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-patologias.actividades.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-patologias.actividades.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-cirugias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-cirugias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-cirugias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-cirugias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-cirugias.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-cirugias.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-cirugias.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-cirugias.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'prohibiciones-cirugias.actividades.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-cirugias.actividades.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'prohibiciones-cirugias.actividades.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-alimentos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alimentos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alimentos.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-alimentos.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-grupos-alimento.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-grupos-alimento.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-grupos-alimento.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-grupos-alimento.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-fuentes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-fuentes.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-fuentes.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-fuentes.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-nutrientes.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-nutrientes.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-nutrientes.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-nutrientes.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-actividades.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-actividades.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-actividades.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-actividades.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-medica.index'])->syncRoles([$role1, $role2]);

        Permission::create(['name'=>'gestion-alimentos'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'gestion-actividades'])->syncRoles([$role1, $role2]);
        Permission::create(['name'=>'planes-a-confirmar'])->syncRoles([$role1, $role2]);


        Permission::create(['name' => 'gestion-atencion.index'])->assignRole($role2);
        Permission::create(['name' => 'gestion-atencion.destroy'])->assignRole($role2);
        Permission::create(['name' => 'gestion-atencion.edit'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-atencion.consultaForm'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-turnos-nutricionista.index'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-turnos-nutricionista.showHistorialTurnos'])->syncRoles([$role1,$role2]);
        Permission::Create(['name'=> 'gestion-turnos-nutricionista.iniciarConsulta'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-turnos-nutricionista.filtros'])->syncRoles([$role1,$role2]);
        Permission::Create(['name'=> 'gestion-turnos-nutricionista.clearFilters'])->syncRoles([$role1,$role2]);

        Permission::Create(['name'=> 'gestion-tratamientos.index'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-tratamientos.create'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-tratamientos.edit'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-tratamientos.destroy'])->assignRole($role2);

        Permission::Create(['name'=> 'gestion-tratamientos.filtros'])->syncRoles([$role1,$role2]);
        Permission::Create(['name'=> 'gestion-tratamientos.clearFilters'])->syncRoles([$role1,$role2]);

        Permission::Create(['name'=> 'gestion-pliegues-cutaneos.index'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-pliegues-cutaneos.create'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-pliegues-cutaneos.edit'])->assignRole($role2);
        Permission::Create(['name'=> 'gestion-pliegues-cutaneos.destroy'])->assignRole($role2);

        Permission::Create(['name'=> 'gestion-estadisticas.index'])->assignRole($role1);

        Permission::Create(['name'=> 'gestion-estadisticas.filtros'])->assignRole($role1);
        Permission::Create(['name'=> 'gestion-estadisticas.clearFilters'])->assignRole($role1);

        Permission::create(['name'=> 'mis-planes'])->assignRole($role3);
        Permission::Create(['name'=> 'plan-alimentacion.index'])->assignRole($role3);
        Permission::Create(['name'=> 'plan-seguimiento.index'])->assignRole($role3);

        Permission::Create(['name'=> 'historia-clinica.index'])->assignRole($role3);
        Permission::Create(['name'=> 'turnos'])->assignRole($role3);
    */





    }
}
