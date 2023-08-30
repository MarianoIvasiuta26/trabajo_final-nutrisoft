<?php

namespace App\Actions\Fortify;

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
            'dni' => ['required', 'string', 'unique:users', 'max:8'], // Agregar validación para DNI
            'apellido' => ['required', 'string', 'max:20'], // Agregar validación para apellido
            'telefono' => ['required', 'string', 'max:10'], // Agregar validación para teléfono
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'dni' => $input['dni'], // Agregar DNI
            'apellido' => $input['apellido'], // Agregar apellido
            'telefono' => $input['telefono'], // Agregar teléfono
            'password' => Hash::make($input['password']),
        ]);
    }
}
