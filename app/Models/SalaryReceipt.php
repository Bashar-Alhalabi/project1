<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryReceipt extends Model
{
    protected $fillable = [
        'payee_type',
        'payee_id',
        'salary_payout_id',
        'amount',
        'paid_on'
    ];

    public function payee()
    {
        return $this->morphTo();
    }

    public function payout()
    {
        return $this->belongsTo(SalaryPayout::class, 'salary_payout_id');
    }
}
