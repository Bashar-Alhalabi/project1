<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          User::create([
               'first_name' => "Khaled",
                'last_name'  => "Zghaeb",
                'email'      => "khaled@example.com",
                'password'   => Hash::make('password'),
                'role_id'    => Role::where('name', 'admin')->first()->id, 
           ]) ;
    }
}
