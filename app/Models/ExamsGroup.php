<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamsGroup extends Model
{

    protected $fillable = [
        'name',
        'semester_id',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'exams_group_id');
    }

}
