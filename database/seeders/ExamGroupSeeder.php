<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use App\Models\ExamsGroup;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\Semester;
use App\Models\Student;

class ExamGroupSeeder extends Seeder
{
    public function run()
    {


        $subjects = Subject::all();
        $classrooms = Classroom::all();
        $semesters = Semester::all();
        $students = Student::all()->pluck('id')->toArray();

        $teachers = Teacher::all()->pluck('id')->toArray();
        // create 3 exam groups
        for ($g = 1; $g <= 3; $g++) {
            $group = ExamsGroup::create([
                'name' => "Midterm Group {$g}",
                'semester_id' => $semesters->random()->id,
            ]);

            // for each group: 5 exams
            for ($e = 1; $e <= 5; $e++) {
                $exam = Exam::create([
                    'exams_group_id' => $group->id,
                    'subject_id' => $subjects->random()->id,
                    'classroom_id' => $classrooms->random()->id,
                    'max_result' => 100,
                    'exam_date' => now()->addDays(rand(-30, 30))->toDateString(),
                    'start_time' => now()->format('H:i:s'),
                    'end_time' => now()->addHour()->format('H:i:s'),
                ]);

                // for each exam: random 3 student attempts
                $take = min(10, count($students));
                $chosen = (array) array_rand($students, $take);
                foreach ($chosen as $key) {
                    ExamAttempt::create([
                        'exam_id' => $exam->id,
                        'student_id' => $students[$key],
                        'teacher_id' => 1,
                        'result' => rand(50, 100),
                    ]);
                }
            }
        }
    }
}
