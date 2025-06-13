<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dictation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Semester;

class DictationSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all()->pluck('id')->toArray();
        $teachers = Teacher::all()->pluck('id')->toArray();
        $semesters = Semester::all()->pluck('id')->toArray();
        $sections = \App\Models\Section::all()->pluck('id')->toArray();

        // create 15 dictations
        for ($i = 1; $i <= 15; $i++) {
            Dictation::create([
                'result' => rand(0, 20) + (rand(0, 99) / 100),
                'student_id' => $students[array_rand($students)],
                'teacher_id' => $teachers[array_rand($teachers)],
                'semester_id' => $semesters[array_rand($semesters)],
                'section_id' => $sections[array_rand($sections)],
            ]);
        }
    }
}
