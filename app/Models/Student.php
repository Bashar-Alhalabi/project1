<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'father_name',
        'mother_name',
        'father_work',
        'mother_work',
        'father_phone',
        'mother_phone',
        'location',
        'birth_day',
        'diseases',
        'special_notes',
        'stage_id',
        'classroom_id',
        'section_id',
        'gender',
        'cashed_points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function dictations()
    {
        return $this->hasMany(Dictation::class);
    }
    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }

    /**
     * All receipts (payments) from this student.
     */
    public function receipts()
    {
        return $this->hasMany(StudentReceipt::class);
    }

    public function processingFees()
    {
        return $this->hasMany(ProcessingFee::class);
    }
    public function paymentsToStudent()
    {
        return $this->hasMany(PaymentToStudent::class);
    }

    /** All discount records for this student. */
    public function studentDiscounts()
    {
        return $this->hasMany(StudentDiscount::class);
    }

    /** All accounting entries for this student. */
    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class);
    }
}