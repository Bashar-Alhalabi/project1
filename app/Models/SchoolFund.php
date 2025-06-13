<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolFund extends Model
{
    protected $fillable = [
    'debit', 'credit', 'description', 'student_id',
    'student_receipt_id', 'payment_to_student_id',
    'salary_receipt_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentReceipt()
    {
        return $this->belongsTo(StudentReceipt::class);
    }

    public function paymentToStudent()
    {
        return $this->belongsTo(PaymentToStudent::class);
    }

    public function salaryReceipt()
    {
        return $this->belongsTo(SalaryReceipt::class);
    }
}
