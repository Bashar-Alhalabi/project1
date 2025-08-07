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
        // 1) All exam IDs for those subjects in this section’s classroom
        $examIds = Exam::query()
            ->whereIn('subject_id', $subjectIds)
            ->where('classroom_id', $this->classroom_id)
            ->pluck('id');

        if ($examIds->isEmpty()) {
            return 0.0;
        }

        // 2) All student IDs in this section
        $studentIds = $this->students()->pluck('id');

        if ($studentIds->isEmpty()) {
            return 0.0;
        }

        // 3) Compute the average of only those attempts:
        return (float) ExamAttempt::query()
            ->whereIn('exam_id', $examIds)
            ->whereIn('student_id', $studentIds)
            ->where('teacher_id', $teacherId)
            ->avg('result');
    }
}