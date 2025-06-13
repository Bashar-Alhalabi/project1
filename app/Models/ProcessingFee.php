<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessingFee extends Model
{
    protected $fillable = ['student_id', 'amount', 'description'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}