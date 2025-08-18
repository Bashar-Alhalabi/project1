<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['name', 'year_id', 'start_date', 'end_date'];
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}