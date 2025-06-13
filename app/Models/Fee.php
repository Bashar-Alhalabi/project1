<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'name',
        'value',
        'year_id',
        'stage_id',
        'classroom_id'
    ];
    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class, 'fee_id');
    }
}
