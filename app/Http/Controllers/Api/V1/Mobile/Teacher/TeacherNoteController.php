<?php

namespace App\Http\Controllers\Api\V1\Mobile\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Teacher\CreateNoteRequest;
use App\Models\Note;
use App\Models\Semester;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TeacherNoteController extends Controller
{
    public function store(CreateNoteRequest $request)
    {
        try {
            $teacherUserId = Auth::id();
            $semester = Semester::where('is_active', true)->firstOrFail();
            $note = Note::create([
                'student_id' => $request->student_id,
                'semester_id' => $semester->id,
                'by_id' => $teacherUserId,
                'type' => $request->type,
                'reason' => $request->reason,
            ]);
            return response()->json([
                'success' => true,
                'message' => __('mobile/notes.created'),
                'note' => $note,
            ], 201);
        } catch (Exception $e) {
            Log::error('Error in teacher note request', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => __('mobile/notes.server_error'),
            ], 500);
        }
    }
}
