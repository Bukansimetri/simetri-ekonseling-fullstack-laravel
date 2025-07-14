<?php

namespace App\Actions\Fortify;

use App\Models\Counselor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:student,counselor'],
        ])->validate();

        // Insert to users table
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
        ]);

        // Insert to students or counselors table
        if ($input['role'] === 'student') {
            Student::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                // Tambahkan field student lain jika ada
            ]);
        }

        if ($input['role'] === 'counselor') {
            Counselor::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                // Tambahkan field counselor lain jika ada
            ]);
        }

        return $user;
    }
}
