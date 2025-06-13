<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = ['user_id', 'phone', 'salary'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function salaryPayouts()
    {
        return $this->morphMany(SalaryPayout::class, 'payee');
    }

    public function salaryAdjustments()
    {
        return $this->morphMany(SalaryAdjustment::class, 'payee');
    }

    public function salaryReceipts()
    {
        return $this->morphMany(SalaryReceipt::class, 'payee');
    }

    public function salaryAccounts()
    {
        return $this->morphMany(SalaryAccount::class, 'payee');
    }

}
