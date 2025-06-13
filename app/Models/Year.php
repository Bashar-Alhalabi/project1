<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date'];
    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}