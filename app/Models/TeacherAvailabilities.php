<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAvailabilities extends Model
{
    protected $fillable = [
        'teacher_id',
        'period_id',
        'day_of_week',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
