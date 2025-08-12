<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'phone', 'lesson_rate'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sectionSubjects()
    {
        return $this->hasMany(SectionSubject::class);
    }

    public function subjects()
    {
        // Option A: via hasManyThrough
        return $this->hasManyThrough(
            Subject::class,
            SectionSubject::class,
            'teacher_id',
            'id',
            'id',
            'subject_id'
        );
    }
    /**
     * Get all Sections this teacher actually teaches (unique).
     *
     * @return \Illuminate\Support\Collection
     */
    public function sectionsTaught()
    {
        return \App\Models\Section::whereIn('id', function ($q) {
            $q->select('section_id')
                ->from('section_subjects')
                ->where('teacher_id', $this->id);
        })->get();
    }

    public function teacherPopularities()
    {
        return $this->hasMany(TeacherPopularity::class);
    }
}
