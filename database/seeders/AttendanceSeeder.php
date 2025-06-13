<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\AttendanceType;
use App\Models\Semester;
use App\Models\User;
use App\Models\Student;

class AttendanceSeeder extends Seeder
{
    public function run()
    {

        $types = AttendanceType::all()->pluck('id')->toArray();
        $semesters = Semester::all()->pluck('id')->toArray();
        $students = Student::all()->pluck('id')->toArray();
        $byUsers = User::all()->pluck('id')->toArray();

        foreach ($students as $stu) {
            for ($i = 0; $i < 5; $i++) {
                // pick a random attendance type
                $typeId = $types[array_rand($types)];

                Attendance::create([
                    'attendable_type' => Student::class,
                    'attendable_id' => $stu,
                    'by_id' => $byUsers[array_rand($byUsers)],
                    'attendance_type_id' => $typeId,
                    'semester_id' => $semesters[array_rand($semesters)],
                    'att_date' => now()->subDays(rand(0, 30))->toDateString(),
                    // if type_id == 1 → no justification; otherwise Medical note
                    'justification' => $typeId === 1 ? null : 'Medical note',
                ]);
            }
        }
    }
}
