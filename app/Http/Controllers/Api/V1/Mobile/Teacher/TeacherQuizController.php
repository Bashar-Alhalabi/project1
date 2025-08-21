<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\CreateQuizRequest;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;
use App\Models\SectionSubject;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;

class TeacherQuizController extends Controller
{
    public function store(CreateQuizRequest $request)
    {
        $user = $request->user();
        $teacher = $user->teacher;
        if (!$teacher) {
            return response()->json([
                'message' => __('mobile/teacher/quiz.errors.not_teacher')
            ], 403);
        }
        $data = $request->validated();
        $sectionSubjectExists = SectionSubject::where('section_id', $data['section_id'])
            ->where('subject_id', $data['subject_id'])
            ->where('teacher_id', $teacher->id)
            ->exists();
        if (!$sectionSubjectExists) {
            return response()->json([
                'message' => __('mobile/teacher/quiz.errors.teacher_not_assigned')
            ], 403);
        }
        $questions = $data['questions'];
        $totalMark = 0;
        foreach ($questions as $qIndex => $q) {
            $qMark = isset($q['mark']) ? floatval($q['mark']) : 0;
            $totalMark += $qMark;
            if (!isset($q['answers']) || !is_array($q['answers']) || count($q['answers']) < 2) {
                return response()->json([
                    'message' => __('mobile/teacher/quiz.errors.min_answers_per_question'),
                    'question_index' => $qIndex,
                ], 422);
            }
            $correctCount = 0;
            foreach ($q['answers'] as $a) {
                if (!array_key_exists('is_correct', $a)) {
                    return response()->json([
                        'message' => __('mobile/teacher/quiz.errors.answer_correct_flag'),
                        'question_index' => $qIndex,
                    ], 422);
                }
                if ($a['is_correct'])
                    $correctCount++;
            }
            if ($correctCount !== 1) {
                return response()->json([
                    'message' => __('mobile/teacher/quiz.errors.one_correct_answer'),
                    'question_index' => $qIndex,
                    'correct_count' => $correctCount
                ], 422);
            }
        }
        if ($totalMark > 20) {
            return response()->json([
                'message' => __('mobile/teacher/quiz.errors.total_mark_exceeded'),
                'total' => $totalMark
            ], 422);
        }
        DB::beginTransaction();
        try {
            $semester = Semester::where('is_active', true)->firstOrFail();
            $quiz = Quiz::create([
                'teacher_id' => $teacher->id,
                'subject_id' => $data['subject_id'],
                'classroom_id' => $data['classroom_id'],
                'section_id' => $data['section_id'],
                'semester_id' => $semester->id,
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'name' => $data['name'],
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
                        'text' => $a['answer'],
                        'correct' => (bool) $a['is_correct'],
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'message' => __('mobile/teacher/quiz.created'),
                'quiz_id' => $quiz->id,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => __('mobile/teacher/quiz.errors.save_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
