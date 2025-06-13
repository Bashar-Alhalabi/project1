<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['text', 'mark', 'quiz_id'];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizQuestionAnswer::class);
    }

    public function attemptAnswers()
    {
        return $this->hasMany(QuizAttemptAnswer::class);
    }
}
