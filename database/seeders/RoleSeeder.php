<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'student',
            'teacher',
            'employee',
            'supervisor',
            'admin',
        ];

        foreach ($roles as $name) {
            Role::create(['name' => $name]);
        }
    }
}