<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAccount extends Model
{
    protected $fillable = [
        'student_id',
        'classroom_id',
        'debit',
        'credit',
        'description',
        'fee_invoice_id',
        'student_discount_id',
        'student_receipt_id',
        'processing_fee_id',
        'payment_to_student_id'
    ];
public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function feeInvoice()
    {
        return $this->belongsTo(FeeInvoice::class, 'fee_invoice_id');
    }

    public function studentDiscount()
    {
        return $this->belongsTo(StudentDiscount::class);
    }

    public function studentReceipt()
    {
        return $this->belongsTo(StudentReceipt::class);
    }

    public function processingFee()
    {
        return $this->belongsTo(ProcessingFee::class);
    }

    public function paymentToStudent()
    {
        return $this->belongsTo(PaymentToStudent::class);
    }
}