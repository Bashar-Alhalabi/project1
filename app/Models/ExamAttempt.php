<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $table = 'exam_attempts';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'result',
        'status',
    ];

    protected $casts = [
        'max_result' => 'float',
        'result' => 'float',
    ];
    public const STATUS_APPROVED = 'approved';
    public const STATUS_WAIT = 'wait';

    /*
     * Relations
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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