<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'attendable_id',
        'attendable_type',
        'attendance_type_id',
        'by_id',
        'semester_id',
        'att_date',
        'justification'
    ];

    public function attendable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'by_id');
    }

    public function attendanceType()
    {
        return $this->belongsTo(AttendanceType::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
