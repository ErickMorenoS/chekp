<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'nombreUsuario' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'telefono' => ['required', 'string', 'max:255'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'nombreUsuario' => $input['nombreUsuario'],
            'email' => $input['email'],
            'telefono' =>$input['telefono'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
