<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\SectionSubject;

class SectionSubjectSeeder extends Seeder
{
    public function run()
    {
        // Clean up existing pivot records
        $subjects = Subject::all();
        $sections = Section::all();
        $teachers = Teacher::all()->pluck('id')->toArray();

        foreach ($sections as $section) {
            foreach ($subjects as $subject) {
                SectionSubject::create([
                    'section_id' => $section->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teachers[array_rand($teachers)],
                ]);
            }
        }
    }
}