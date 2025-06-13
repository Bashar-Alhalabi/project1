<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceType;

class AttendanceTypeSeeder extends Seeder
{
    public function run()
    {

        $types = [
            ['name' => 'present', 'value' => 1],
            ['name' => 'absent', 'value' => 0],
            ['name' => 'late', 'value' => -1],
        ];

        foreach ($types as $t) {
            AttendanceType::create($t);
        }
    }
}
