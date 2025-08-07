<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;


use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\StoreDictationRequest;
use App\Models\Dictation;
use App\Models\Semester;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TeacherDictationController extends Controller
{
    public function store(StoreDictationRequest $request): JsonResponse
    {
        try {
            $teacher = $request->user()->teacher;
            $student = $request->user()->teacher->section->students()
                ->where('id', $request->student_id)
                ->firstOrFail();

            // determine current semester
            $semester = Semester::whereDate('start_date', '<=', today())
                ->whereDate('end_date', '>=', today())
                ->firstOrFail();
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
                'message' => __('mobile.dictation.store.success'),
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
                'message' => __('mobile.dictation.store.error'),
            ], 500);
        }
    }
}