<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestionAnswer extends Model
{
    protected $fillable = ['text', 'correct', 'quiz_question_id'];
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function attemptAnswers()
    {
        return $this->hasMany(QuizAttemptAnswer::class);
    }
}
