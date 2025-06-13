<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;
use App\Models\Year;
use Carbon\Carbon;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $year1 = Year::where('name', '2024-2025')->first();

        Semester::create([
            'name' => 'First Semester',
            'start_date' => Carbon::create(2024, 9, 1),
            'end_date' => Carbon::create(2025, 1, 31),
            'year_id' => $year1->id,
            'is_active' => true,
        ]);

        Semester::create([
            'name' => 'Second Semester',
            'start_date' => Carbon::create(2025, 2, 1),
            'end_date' => Carbon::create(2025, 6, 30),
            'year_id' => $year1->id,
            'is_active' => false,
        ]);
    }
}
