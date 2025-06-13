<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
        protected $fillable = [
        'student_id',
        'from_grade',
        'from_classroom',
        'from_section',
        'to_grade',
        'to_classroom',
        'to_section',
        'academic_year',
        'academic_year_new',
    ];

    /**
     * Get the student being promoted.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the original grade.
     */
    public function fromGrade()
    {
        return $this->belongsTo(Stage::class, 'from_stage');
    }

    /**
     * Get the original classroom.
     */
    public function fromClassroom()
    {
        return $this->belongsTo(Classroom::class, 'from_classroom');
    }

    /**
     * Get the original section.
     */
    public function fromSection()
    {
        return $this->belongsTo(Section::class, 'from_section');
    }

    /**
     * Get the new grade.
     */
    public function toGrade()
    {
        return $this->belongsTo(Stage::class, 'to_stage');
    }

    /**
     * Get the new classroom.
     */
    public function toClassroom()
    {
        return $this->belongsTo(Classroom::class, 'to_classroom');
    }

    /**
     * Get the new section.
     */
    public function toSection()
    {
        return $this->belongsTo(Section::class, 'to_section');
    }
}
