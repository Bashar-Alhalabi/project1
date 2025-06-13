<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryAccount extends Model
{
    protected $fillable = [
        'payee_type',
        'payee_id',
        'debit',
        'credit',
        'description',
        'transactable_type',
        'transactable_id'
    ];

    public function payee()
    {
        return $this->morphTo();
    }

    public function transactable()
    {
        return $this->morphTo();
    }
}
