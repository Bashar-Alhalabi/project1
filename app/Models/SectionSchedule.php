<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionSchedule extends Model
{
    protected $fillable = [
        'section_id',
        'period_id',
        'day_of_week',
        'subject_id',
        'teacher_id',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}