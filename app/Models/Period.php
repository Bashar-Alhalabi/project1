<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'order',
        'start_time',
        'end_time',
        'name',
    ];

    public function sectionSchedules()
    {
        return $this->hasMany(SectionSchedule::class);
    }

    public function teacherAvailabilities()
    {
        return $this->hasMany(TeacherAvailabilities::class);
    }
}