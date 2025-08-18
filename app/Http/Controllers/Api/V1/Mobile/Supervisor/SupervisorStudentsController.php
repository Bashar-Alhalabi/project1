<?php

namespace App\Http\Controllers\Api\V1\Mobile\SuperVisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class SupervisorStudentsController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $supervisor = $user->supervisor;
            $stage = $supervisor->stage;
            $classrooms = $stage->classrooms;
            $sections = $classrooms->sections;
            $sections->load(['students.user', 'classroom']);
            $result = [];

            foreach ($sections as $section) {
                $className = $section->classroom->name;
                $sectionName = $section->name;
                $students = $section->students->map(fn($student) => [
                    'id' => $student->id,
                    'first_name' => $student->user->first_name,
                    'last_name' => $student->user->last_name,
                    'gender' => $student->gender,
                ]);
                $result[$className][$sectionName]['students'] = $students;
            }
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error fetching teacher students', [
                'teacher_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Could not retrieve students.',
            ], 500);
        }
    }
}
