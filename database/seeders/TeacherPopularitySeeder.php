<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeacherPopularity;
use App\Models\Student;
use App\Models\Teacher;

class TeacherPopularitySeeder extends Seeder
{
    public function run()
    {

        $students = Student::all()->pluck('id')->toArray();
        $teachers = Teacher::all()->pluck('id')->toArray();

        // each student picks 2 favorite teachers
        foreach ($students as $stu) {
            $picks = (array) array_rand($teachers, min(2, count($teachers)));
            foreach ($picks as $key) {
                TeacherPopularity::create([
                    'student_id' => $stu,
                    'teacher_id' => $teachers[$key],
                ]);
            }
        }
    }
}
