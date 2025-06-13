<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'phone', 'lesson_rate'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sectionSubjects()
    {
        return $this->hasMany(SectionSubject::class);
    }

    public function subjects()
    {
        // Option A: via hasManyThrough
        return $this->hasManyThrough(
            Subject::class,
            SectionSubject::class,
            'teacher_id',
            'id',
            'id',
            'subject_id'
        );
        // Option B: via belongsToMany (same table, no pivot model)
        // return $this->belongsToMany(
        //     Subject::class,
        //     'section_subjects',
        //     'teacher_id',
        //     'subject_id'
        // )->withTimestamps()->distinct();
    }

    public function salaryPayouts()
    {
        return $this->morphMany(SalaryPayout::class, 'payee');
    }

    public function salaryAdjustments()
    {
        return $this->morphMany(SalaryAdjustment::class, 'payee');
    }

    public function salaryReceipts()
    {
        return $this->morphMany(SalaryReceipt::class, 'payee');
    }

    public function salaryAccounts()
    {
        return $this->morphMany(SalaryAccount::class, 'payee');
    }
}
