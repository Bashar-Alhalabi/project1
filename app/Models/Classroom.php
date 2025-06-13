<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['name', 'stage_id', 'supervisor_id'];
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function studentAccounts()
    {
        return $this->hasMany(StudentAccount::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}