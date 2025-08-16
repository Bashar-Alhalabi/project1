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
        // eager load user to avoid N+1
        $students = $this->students()->with('user')->get();

        return $students
            ->map(function (\App\Models\Student $student) use ($type, $teacherId) {
                return [
                    'student' => [
                        'first_name' => optional($student->user)->first_name,
                        'last_name' => optional($student->user)->last_name,
                    ],
                    'points' => $student->calculatePoints($type, $teacherId),
                ];
            })
            ->sortByDesc('points')
            ->values();
    }



    /**
     * Average exam result for a teacher across given subject IDs (for this section).
     *
     * @param int   $teacherId
     * @param array $subjectIds
     * @return float
     */
    public function averageExamResultForTeacher(int $teacherId, array $subjectIds): float
    {
        // 1) All exam IDs in this section for those subjects
        $examIds = \App\Models\Exam::query()
            ->where('section_id', $this->id)
            ->whereIn('subject_id', $subjectIds)
            ->pluck('id');

        if ($examIds->isEmpty()) {
            return 0.0;
        }

        // 2) All student IDs in this section
        $studentIds = $this->students()->pluck('id');
        if ($studentIds->isEmpty()) {
            return 0.0;
        }

        // 3) Compute the average of exam_attempts matching those exams, students and teacher
        $avg = \App\Models\ExamAttempt::query()
            ->whereIn('exam_id', $examIds)
            ->whereIn('student_id', $studentIds)
            ->where('teacher_id', $teacherId)
            ->avg('result');

        return $avg === null ? 0.0 : (float) $avg;
    }
}
