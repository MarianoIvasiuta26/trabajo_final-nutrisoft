<?php

namespace App\Actions\Fortify;

use App\Models\Administrador;
use App\Models\Nutricionista;
use App\Models\Paciente;
use App\Models\Paciente\HistoriaClinica;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'apellido' => ['required', 'string', 'max:20'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $tipoUsuario = $input['tipo_usuario'] ?? 'Paciente';

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'apellido' => $input['apellido'],
            'password' => Hash::make($input['password']),
            'tipo_usuario' => $tipoUsuario,
        ]);

        if ($tipoUsuario === 'Paciente') {
            Paciente::create(['user_id' => $user->id]);
            //HistoriaClinica::create(['paciente_id' => $paciente->id]);
        } elseif ($tipoUsuario === 'Administrador') {
            Administrador::create(['user_id' => $user->id]);
        } elseif ($tipoUsuario === 'Nutricionista') {
            Nutricionista::create(['user_id' => $user->id]);
        }

        return $user;
    }
}
