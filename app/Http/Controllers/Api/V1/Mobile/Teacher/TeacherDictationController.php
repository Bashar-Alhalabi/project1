<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;


use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\StoreDictationRequest;
use App\Models\Dictation;
use App\Models\Semester;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Models\Student;
use App\Models\SectionSubject;

class TeacherDictationController extends Controller
{
    public function store(StoreDictationRequest $request): JsonResponse
    {
        try {
            $teacher = $request->user()->teacher;
            $semester = Semester::where('is_active', true)->firstOrFail();
            $student = Student::find($request->student_id);
            $sectionId = $student->section_id;
            $teaches = SectionSubject::where('section_id', $sectionId)
                ->where('subject_id', $request->subject_id)
                ->where('teacher_id', $teacher->id)
                ->exists();
            if (!$teaches) {
                return response()->json([
                    'success' => false,
                    'message' => __('mobile/teacher/dictation.errors.teacher_not_assigned'),
                ], 403);
            }
            $dictation = Dictation::create([
                'student_id' => $student->id,
                'subject_id' => $request->subject_id,
                'result' => $request->result,
                'teacher_id' => $teacher->id,
                'semester_id' => $semester->id,
                'section_id' => $student->section_id,
            ]);
            return response()->json([
                'success' => true,
                'message' => __('mobile/teacher/dictation.store.success'),
                'data' => $dictation,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Dictation store failed', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'teacher_id' => optional($request->user()->teacher)->id,
            ]);
            return response()->json([
                'success' => false,
                'message' => __('mobile/teacher/dictation.store.error'),
            ], 500);
        }
    }
}
