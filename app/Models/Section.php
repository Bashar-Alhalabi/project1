<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
class Section extends Model
{
    protected $fillable = ['name', 'classroom_id'];
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function sectionSubjects()
    {
        return $this->hasMany(SectionSubject::class);
    }

    public function sectionSchedules()
    {
        return $this->hasMany(SectionSchedule::class);
    }
    public function calls()
    {
        return $this->hasMany(Call::class);
    }


    /**
     * Get this section’s students ordered by their points.
     *
     * @param  string     $type      One of "exams", "quiz", "notes" , "attendances" or "all"
     * @param  int|null   $teacherId Optional: only count points awarded by this teacher
     * @return \Illuminate\Support\Collection
     */
    public function studentRanking(string $type = 'all', int $teacherId = null)
    {
        return $this->students
            ->map(function (\App\Models\Student $student) use ($type, $teacherId) {
                return [
                    'student' => [
                        'first_name' => $student->user->first_name,
                        'last_name' => $student->user->last_name,
                    ],
                    'points' => $student->calculatePoints($type, $teacherId),
                ];
            })
            ->sortByDesc('points')
            ->values();
    }



    public function averageExamResultForTeacher(int $teacherId, array $subjectIds): float
    {
        // 1) All student IDs in this section
        $studentIds = $this->students()->pluck('id');
        if ($studentIds->isEmpty()) {
            return 0.0;
        }
        // 2) Compute the average from exam_attempts for:
        //    - the requested subject(s)
        //    - this section (we now store section_id on exam_attempts)
        //    - the given teacher
        //    - only the students of this section
        $avg = ExamAttempt::query()
            ->whereIn('subject_id', $subjectIds)
            ->where('section_id', $this->id)
            ->where('teacher_id', $teacherId)
            ->whereIn('student_id', $studentIds)
            ->avg('result');
        return $avg === null ? 0.0 : (float) $avg;
    }
}
