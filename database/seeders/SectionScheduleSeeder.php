<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SectionSchedule;
use App\Models\Section;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Teacher;

class SectionScheduleSeeder extends Seeder
{
    public function run()
    {


        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday'];

        $sections = Section::all();
        $periods = Period::all();
        $subjects = Subject::all()->pluck('id')->toArray();
        $teachers = Teacher::all()->pluck('id')->toArray();

        foreach ($sections as $section) {
            foreach ($days as $day) {
                foreach ($periods as $period) {
                    // assign randomly half of slots
                    if (rand(0, 1)) {
                        SectionSchedule::create([
                            'section_id' => $section->id,
                            'period_id' => $period->id,
                            'day_of_week' => $day,
                            'subject_id' => $subjects[array_rand($subjects)],
                            'teacher_id' => $teachers[array_rand($teachers)],
                        ]);
                    }
                }
            }
        }
    }
}
