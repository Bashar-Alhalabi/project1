<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

class QuizSeeder extends Seeder
{
    public function run()
    {


        $subjects = Subject::all();
        $semesters = Semester::all();
        $classrooms = Classroom::all();
        $sections = Section::all();
        $teachers = Teacher::all()->pluck('id')->toArray();
        $students = Student::all()->pluck('id')->toArray();

        // create 5 quizzes
        for ($q = 1; $q <= 5; $q++) {
            $quiz = Quiz::create([
                'name' => "Quiz {$q}",
                'subject_id' => $subjects->random()->id,
                'semester_id' => $semesters->random()->id,
                'classroom_id' => $classrooms->random()->id,
                'section_id' => $sections->random()->id,
                'teacher_id' => $teachers[array_rand($teachers)],
            ]);

            // for each quiz: 3 questions
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
                        'text' => "Option {$a} for Q{$question->id}",
                        'correct' => ($a === $correctIndex),
                    ]);
                }
            }

            // for each quiz: 2 student attempts
            foreach (array_rand($students, min(10, count($students))) as $stuKey) {
                $studentId = $students[$stuKey];
                $attempt = QuizAttempt::create([
                    'quiz_id' => $quiz->id,
                    'student_id' => $studentId,
                    'started_at' => now(),
                    'submitted_at' => now()->addMinutes(10),
                ]);

                // record answers: pick one random answer per question
                foreach ($questions as $question) {
                    $answers = $question->answers; // relation on QuizQuestion model
                    $selected = $answers->random();
                    QuizAttemptAnswer::create([
                        'quiz_attempt_id' => $attempt->id,
                        'quiz_question_id' => $question->id,
                        'quiz_question_answer_id' => $selected->id,
                    ]);
                }

                // update total_score
                // update total_score
                $score = QuizAttemptAnswer::where('quiz_attempt_id', $attempt->id)
                    ->join('quiz_question_answers', 'quiz_question_answers.id', '=', 'quiz_attempt_answers.quiz_question_answer_id')
                    ->join('quiz_questions', 'quiz_questions.id', '=', 'quiz_attempt_answers.quiz_question_id')
                    ->where('quiz_question_answers.correct', true)
                    ->sum('quiz_questions.mark');

                $attempt->update(['total_score' => $score]);

            }
        }
    }
}