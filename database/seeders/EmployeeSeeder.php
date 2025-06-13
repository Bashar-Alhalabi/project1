<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Example: create 3 employees
        $types = ['caretaker', 'librarian', 'janitor'];

        foreach ($types as $idx => $type) {
            $user = User::create([
                'first_name' => ucfirst($type),
                'last_name'  => 'Employee',
                'email'      => "{$type}@example.com",
                'password'   => Hash::make('password'),
                'role_id'    => Role::where('name', 'employee')->first()->id,
            ]);

            Employee::create([
                'user_id' => $user->id,
                'phone'   => "012000000{$idx}",
                'type'    => $type,
                'salary'  => 2000 + $idx * 500,
            ]);
        }
    }
}
