<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentReceipt extends Model
{
    protected $fillable = [
        'student_id',
        'amount_received',
        'receipt_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
