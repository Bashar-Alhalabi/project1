<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\SectionSubject;
use App\Models\Supervisor;
use App\Models\Semester;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Student;
use App\Models\Subject;

class ExamGroupSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Starting ExamSeeder...');

        $sectionSubjects = SectionSubject::all();
        if ($sectionSubjects->isEmpty()) {
            $this->command->warn('No section_subjects found — nothing to seed.');
            return;
        }

        $supervisors = Supervisor::all();
        if ($supervisors->isEmpty()) {
            $this->command->warn('No supervisors found — please create at least one supervisor before running this seeder.');
            return;
        }

        // Prefer active semester, otherwise first found
        $semester = Semester::where('is_active', true)->first() ?? Semester::first();
        if (!$semester) {
            $this->command->warn('No semesters found — please create at least one semester before running this seeder.');
            return;
        }

        $possibleMax = [20, 25, 50, 100];
        $attemptStatusOptions = ['approved', 'wait'];

        // How many exams to create
        $examCount = 12;

        for ($i = 1; $i <= $examCount; $i++) {
            // pick random section-subject assignment
            $ss = $sectionSubjects->random();

            $sectionId = $ss->section_id;
            $subjectId = $ss->subject_id;
            $teacherId = $ss->teacher_id;

            // get subject name (best effort)
            $subjectName = optional(Subject::find($subjectId))->name ?? "Subject-{$subjectId}";

            // pick random supervisor as creator
            $supervisorId = $supervisors->random()->id;

            // pick random max result
            $maxResult = Arr::random($possibleMax);

            // choose a name for the exam
            $name = "Exam {$i} - {$subjectName} - Section {$sectionId}";

            // random status (most will be 'wait' so teachers can enter)
            $status = (mt_rand(1, 100) <= 80) ? 'wait' : 'released';

            // create exam
            $exam = Exam::create([
                'created_by' => $supervisorId,
                'semester_id' => $semester->id,
                'section_id' => $sectionId,
                'subject_id' => $subjectId,
                'name' => $name,
                'status' => $status,
                'max_result' => $maxResult,
            ]);

            $this->command->info("Created exam [id={$exam->id}] name=\"{$name}\" section={$sectionId} subject={$subjectId} max={$maxResult} status={$status}");

            // fetch students in that section
            $students = Student::where('section_id', $sectionId)->pluck('id')->toArray();
            if (empty($students)) {
                $this->command->warn(" - No students in section {$sectionId}; skipping attempts creation for this exam.");
                continue;
            }

            // choose up to 10 students
            shuffle($students);
            $take = min(10, count($students));
            $chosen = array_slice($students, 0, $take);

            foreach ($chosen as $studentId) {
                // random result with two decimals between 0 and maxResult
                $result = mt_rand(0, (int) ($maxResult * 100)) / 100;

                ExamAttempt::create([
                    'exam_id' => $exam->id,
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'result' => $result,
                    'status' => $attemptStatusOptions[array_rand($attemptStatusOptions)],
                ]);

                $this->command->info("   - Attempt for student {$studentId}: result={$result}");
            }
        }

        $this->command->info('ExamSeeder completed.');
    }
}
