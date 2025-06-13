<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentToStudent extends Model
{
    protected $fillable = ['student_id', 'amount', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class, 'payment_to_student_id');
    }
}
