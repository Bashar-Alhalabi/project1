<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stage;

class StageSeeder extends Seeder
{
    public function run()
    {

        $names = ['Primary', 'Middle', 'High'];

        foreach ($names as $name) {
            Stage::create(['name' => $name]);
        }
    }
}