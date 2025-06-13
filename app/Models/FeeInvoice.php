<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    protected $fillable = ['amount', 'fee_id', 'student_id'];

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function receipts()
    {
        return $this->hasMany(StudentReceipt::class, 'student_id', 'student_id')
            ->whereColumn('student_receipts.student_id', 'fee_invoices.student_id');
    }

    public function studentDiscounts()
    {
        return $this->hasMany(StudentDiscount::class, 'fee_invoice_id');
    }

    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class, 'fee_invoice_id');
    }
}