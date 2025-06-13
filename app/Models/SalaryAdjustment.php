<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAdjustment extends Model
{
    protected $fillable = [
        'payee_type',
        'payee_id',
        'salary_payout_id',
        'type',
        'amount',
        'reason'
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
