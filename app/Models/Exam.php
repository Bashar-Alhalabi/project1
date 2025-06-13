<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'subject_id',
        'classroom_id',
        'exam_group_id',
        'max_result',
        'exam_date',
        'start_time',
        'end_time'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function group()
    {
        return $this->belongsTo(ExamsGroup::class, 'exams_group_id');
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
