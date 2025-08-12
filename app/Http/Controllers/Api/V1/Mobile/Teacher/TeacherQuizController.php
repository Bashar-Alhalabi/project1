<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\CreateQuizRequest;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use App\Models\SectionSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherQuizController extends Controller
{
    public function store(CreateQuizRequest $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return response()->json([
                'message' => __('mobile.quiz.errors.not_teacher')
            ], 403);
        }

        $data = $request->validated();

        // Ensure teacher teaches this subject in this section
        $sectionSubjectExists = SectionSubject::where('section_id', $data['section_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('teacher_id', $teacher->id)
            ->exists();

        if (!$sectionSubjectExists) {
            return response()->json([
                'message' => __('mobile.quiz.errors.teacher_not_assigned')
            ], 403);
        }

        // Validate total marks ≤ 20 and exactly one correct answer per question
        $questions = $data['questions'];
        $totalMark = 0;
        foreach ($questions as $qIndex => $q) {
            $qMark = isset($q['mark']) ? floatval($q['mark']) : 0;
            $totalMark += $qMark;

            if (!isset($q['answers']) || !is_array($q['answers']) || count($q['answers']) < 2) {
                return response()->json([
                    'message' => __('mobile.quiz.errors.min_answers_per_question'),
                    'question_index' => $qIndex,
                ], 422);
            }

            $correctCount = 0;
            foreach ($q['answers'] as $a) {
                if (!array_key_exists('is_correct', $a)) {
                    return response()->json([
                        'message' => __('mobile.quiz.errors.answer_correct_flag'),
                        'question_index' => $qIndex,
                    ], 422);
                }
                if ($a['is_correct'])
                    $correctCount++;
            }

            if ($correctCount !== 1) {
                return response()->json([
                    'message' => __('mobile.quiz.errors.one_correct_answer'),
                    'question_index' => $qIndex,
                    'correct_count' => $correctCount
                ], 422);
            }
        }

        if ($totalMark > 20) {
            return response()->json([
                'message' => __('mobile.quiz.errors.total_mark_exceeded'),
                'total' => $totalMark
            ], 422);
        }

        DB::beginTransaction();
        try {
            $quiz = Quiz::create([
                'teacher_id' => $teacher->id,
                'subject_id' => $data['subject_id'],
                'classroom_id' => $data['classroom_id'],
                'section_id' => $data['section_id'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'name' => $data['name'],   // <-- use name (matches your migrations)
            ]);

            foreach ($questions as $q) {
                $qq = QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'text' => $q['question'],
                    'mark' => $q['mark'],
                ]);

                foreach ($q['answers'] as $a) {
                    QuizQuestionAnswer::create([
                        'quiz_question_id' => $qq->id,
                        'answer' => $a['answer'],
                        'is_correct' => (bool) $a['is_correct'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => __('mobile.quiz.created'),
                'quiz_id' => $quiz->id,
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => __('mobile.quiz.errors.save_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
