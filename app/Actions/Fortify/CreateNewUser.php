<?php

namespace App\Actions\Fortify;

use App\Models\Administrador;
use App\Models\Nutricionista;
use App\Models\Paciente;
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
            'tipo_usuario' => ['required', 'string', 'max:15'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'apellido' => $input['apellido'],
            'password' => Hash::make($input['password']),
            'tipo_usuario' => $input['tipo_usuario'],
        ]);

        if ($input['tipo_usuario'] === 'Paciente') {
            Paciente::create(['user_id' => $user->id]);
        } elseif ($input['tipo_usuario'] === 'Administrador') {
            Administrador::create(['user_id' => $user->id]);
        } elseif ($input['tipo_usuario'] === 'Nutricionista') {
            Nutricionista::create(['user_id' => $user->id]);
        }

        return $user;
    }
}
