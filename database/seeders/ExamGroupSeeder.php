<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SectionSubject;
use App\Models\ExamAttempt;
use App\Models\Semester;

class ExamGroupSeeder extends Seeder
{
    public function run()
    {
        // Fetch available section-subject-teacher assignments
        $sectionSubjects = SectionSubject::all();

        if ($sectionSubjects->isEmpty()) {
            $this->command->info('No section_subjects found — skipping exam_attempts seeding.');
            return;
        }

        $semesterIds = Semester::all()->pluck('id')->toArray();
        // If there are no semesters, we allow null — adjust as needed
        if (empty($semesterIds)) {
            $this->command->warn('No semesters found — semester_id will be null for created exam_attempts.');
        }

        $statusOptions = ['approved', 'wait'];

        // We'll create 15 "exam instances" (similar to old groups*exams)
        for ($instance = 1; $instance <= 15; $instance++) {
            // Pick a random valid section-subject-teacher combo
            $ss = $sectionSubjects->random();

            $sectionId = $ss->section_id;
            $subjectId = $ss->subject_id;
            $teacherId = $ss->teacher_id;

            // Get students for that section
            $students = Student::where('section_id', $sectionId)->pluck('id')->toArray();
            if (empty($students)) {
                // nothing to seed for this combo
                continue;
            }

            // pick up to 10 random students from the section
            shuffle($students);
            $take = min(10, count($students));
            $chosenStudents = array_slice($students, 0, $take);

            // choose random semester if available
            $semesterId = !empty($semesterIds) ? $semesterIds[array_rand($semesterIds)] : null;

            // choose a max_result for this exam instance (common values)
            $possibleMax = [20, 25, 50, 100];
            $maxResult = $possibleMax[array_rand($possibleMax)];

            // create attempts for each chosen student
            foreach ($chosenStudents as $studentId) {
                ExamAttempt::create([
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'subject_id' => $subjectId,
                    'semester_id' => $semesterId,
                    'max_result' => $maxResult,
                    'result' => rand(0, $maxResult),
                    'status' => $statusOptions[array_rand($statusOptions)],
                    'section_id' => $sectionId,
                ]);
            }
        }

        $this->command->info('Exam attempts seeding completed.');
    }
}