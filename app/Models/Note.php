<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'by_id',
        'student_id',
        'semester_id',
        'type',
        'reason',
        'status',
        'value'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'by_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
