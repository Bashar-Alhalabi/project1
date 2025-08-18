<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
class TeacherSeeder extends Seeder
{
    public function run()
    {
        // Example: create 5 teachers
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'first_name' => "TeacherFirst{$i}",
                'last_name' => "TeacherLast{$i}",
                'email' => "teacher{$i}@example.com",
                'password' => Hash::make('password'),
                'role_id' => Role::where('name', 'teacher')->first()->id,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'phone' => "011000000{$i}",
            ]);
        }
    }
}