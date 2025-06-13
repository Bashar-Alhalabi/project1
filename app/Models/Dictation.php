<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictation extends Model
{
    protected $fillable = [
        'result',
        'student_id',
        'teacher_id',
        'semester_id',
        'section_id',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
