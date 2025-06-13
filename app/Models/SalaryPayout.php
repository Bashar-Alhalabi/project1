<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryPayout extends Model
{
    protected $fillable = [
        'payee_type',
        'payee_id',
        'amount',
        'salary_month',
        'paid_on'
    ];

    public function payee()
    {
        return $this->morphTo();
    }

    public function adjustments()
    {
        return $this->hasMany(SalaryAdjustment::class);
    }

    public function receipts()
    {
        return $this->hasMany(SalaryReceipt::class);
    }
}
