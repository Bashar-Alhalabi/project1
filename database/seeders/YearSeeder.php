<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Year;
use Carbon\Carbon;

class YearSeeder extends Seeder
{
    public function run()
    {

        Year::create([
            'name' => '2024-2025',
            'start_date' => Carbon::create(2024, 9, 1),
            'end_date' => Carbon::create(2025, 6, 30),
            'is_active' => true,
        ]);

        Year::create([
            'name' => '2025-2026',
            'start_date' => Carbon::create(2025, 9, 1),
            'end_date' => Carbon::create(2026, 6, 30),
            'is_active' => false,
        ]);
    }
}