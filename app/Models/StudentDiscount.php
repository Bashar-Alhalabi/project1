<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDiscount extends Model
{
    protected $fillable = [
        'discount_id',
        'student_id',
        'fee_invoice_id',
        'amount_applied'
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeInvoice()
    {
        return $this->belongsTo(FeeInvoice::class, 'fee_invoice_id');
    }

    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class, 'student_discount_id');
    }
}