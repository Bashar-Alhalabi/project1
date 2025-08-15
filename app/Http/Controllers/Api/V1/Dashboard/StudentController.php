<?php

namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{

   public function index(Request $request)
    {
        $q = Student::query();

        if ($search = $request->query('q')) {
            $q->where(function ($w) use ($search) {
                $w->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('class', 'like', "%$search%");
            });
        }

        $students = $q->latest()->paginate($request->integer('per_page', 15));
        return StudentResource::collection($students)->additional([
            'message' => __('messages.list_success'),
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return (new StudentResource($student))
            ->additional(['message' => __('messages.student_created')])
            ->response()->setStatusCode(201);
    }

     public function show(Student $student)
    {
        return (new StudentResource($student))
            ->additional(['message' => __('messages.show_success')]);
    }

     public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return (new StudentResource($student))
            ->additional(['message' => __('messages.student_updated')]);
    }
     public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['message' => __('messages.student_deleted')], 200);
    }
}
