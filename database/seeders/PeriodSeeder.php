<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Period;

class PeriodSeeder extends Seeder
{
    public function run()
    {

        $periods = [
            ['order' => 1, 'name' => 'P1', 'start_time' => '08:00:00', 'end_time' => '08:45:00'],
            ['order' => 2, 'name' => 'P2', 'start_time' => '08:50:00', 'end_time' => '09:35:00'],
            ['order' => 3, 'name' => 'P3', 'start_time' => '09:50:00', 'end_time' => '10:35:00'],
            ['order' => 4, 'name' => 'P4', 'start_time' => '10:40:00', 'end_time' => '11:25:00'],
            ['order' => 5, 'name' => 'P5', 'start_time' => '11:30:00', 'end_time' => '12:15:00'],
        ];

        foreach ($periods as $p) {
            Period::create($p);
        }
    }
}
