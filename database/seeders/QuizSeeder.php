<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Classroom;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $subjects = Subject::all();
        $semesters = Semester::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $teachers = Teacher::all()->pluck('id')->toArray();
        $studentsCollection = Student::all()->pluck('id');

        if ($subjects->isEmpty() || $classrooms->isEmpty() || $sections->isEmpty() || empty($teachers) || $studentsCollection->isEmpty()) {
            $this->command->warn('Missing subjects/classrooms/sections/teachers/students — skipping quiz seeding.');
            return;
        }

        // create 5 quizzes
        for ($q = 1; $q <= 5; $q++) {
            // random elements
            $subject = $subjects->random();
            $semester = $semesters->random();
            $classroom = $classrooms->random();
            $section = $sections->random();
            $teacherId = $teachers[array_rand($teachers)];

            // create random start and end times for the quiz
            $startTime = now()->addDays(rand(-5, 5))->setTime(rand(8, 15), [0, 15, 30, 45][array_rand([0, 15, 30, 45])]);
            $durationMinutes = Arr::random([10, 15, 20, 30, 45]);
            $endTime = (clone $startTime)->addMinutes($durationMinutes);

            $quiz = Quiz::create([
                'name' => "Quiz {$q}",
                'subject_id' => $subject->id,
                'semester_id' => $semester->id,
                'classroom_id' => $classroom->id,
                'section_id' => $section->id,
                'teacher_id' => $teacherId,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            // for each quiz: 3 questions (each mark 5 to keep total reasonable)
            $questions = [];
            for ($i = 1; $i <= 3; $i++) {
                $questions[] = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'text' => "Question {$i} for {$quiz->name}?",
                    'mark' => 5,
                ]);
            }

            // for each question: 4 answers, 1 correct
            foreach ($questions as $question) {
                $correctIndex = rand(1, 4);
                for ($a = 1; $a <= 4; $a++) {
                    QuizQuestionAnswer::create([
                        'quiz_question_id' => $question->id,
                        // using "text" column as in your original seeder — adjust if your column name differs
                        'text' => "Option {$a} for Q{$question->id}",
                        // using "correct" boolean field as in your original seeder — adjust if differs
                        'correct' => ($a === $correctIndex),
                    ]);
                }
            }

            // choose up to 10 random students for attempts (use collection random)
            $studentCountToTake = min(10, $studentsCollection->count());
            $chosenStudents = $studentsCollection->random($studentCountToTake)->values()->all();

            foreach ($chosenStudents as $studentId) {
                DB::beginTransaction();
                try {
                    $attempt = QuizAttempt::create([
                        'quiz_id' => $quiz->id,
                        'student_id' => $studentId,
                        'started_at' => now(),
                        'submitted_at' => now()->addMinutes(rand(5, $durationMinutes)),
                    ]);

                    // pick one random answer per question
                    foreach ($questions as $question) {
                        // assume relation name is 'answers' on QuizQuestion model
                        $answers = QuizQuestionAnswer::where('quiz_question_id', $question->id)->get();
                        if ($answers->isEmpty()) {
                            continue;
                        }
                        $selected = $answers->random();

                        QuizAttemptAnswer::create([
                            'quiz_attempt_id' => $attempt->id,
                            'quiz_question_id' => $question->id,
                            // adjust column name if your migration uses another column name
                            'quiz_question_answer_id' => $selected->id,
                        ]);
                    }

                    // calculate score: sum marks of correctly answered questions
                    $score = QuizAttemptAnswer::where('quiz_attempt_id', $attempt->id)
                        ->join('quiz_question_answers', 'quiz_question_answers.id', '=', 'quiz_attempt_answers.quiz_question_answer_id')
                        ->join('quiz_questions', 'quiz_questions.id', '=', 'quiz_attempt_answers.quiz_question_id')
                        ->where('quiz_question_answers.correct', true)
                        ->sum('quiz_questions.mark');

                    $attempt->update(['total_score' => $score]);

                    DB::commit();
                } catch (\Throwable $e) {
                    DB::rollBack();
                    $this->command->error("Failed to create attempt for student {$studentId}: " . $e->getMessage());
                }
            }
        }

        $this->command->info('Quiz seeding completed.');
    }
}