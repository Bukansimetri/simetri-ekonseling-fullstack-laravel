<?php

namespace Database\Seeders;

use App\Models\Counselor;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CounselorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            // Create user for counselor
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // default password
                'role' => 'counselor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create counselor detail
            Counselor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'education' => 'S1',
                'experience' => $faker->numberBetween(2, 15).' years counseling experience',
                'username' => $faker->unique()->userName,
                'email' => $user->email,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'essay' => $faker->sentence(12),
                'office' => 'Room '.$faker->numberBetween(101, 210).', Counseling Center',
                'image' => 'counselors/default.jpg', // set default image
                'is_active' => $faker->boolean(90), // 90% active
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
