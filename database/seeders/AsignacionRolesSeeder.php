<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignacionRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('tipo_usuario', '=', 'Administrador')->first();
        $admin->assignRole('Admin');

        $pacientes = User::where('tipo_usuario', '=', 'Paciente')->get();
        foreach($pacientes as $paciente){
            $paciente->assignRole('Paciente');
        }

        $nutricionistas = User::where('tipo_usuario', '=', 'Nutricionista')->get();
        foreach($nutricionistas as $nutricionista){
            $nutricionista->assignRole('Nutricionista');
        }
    }
}
