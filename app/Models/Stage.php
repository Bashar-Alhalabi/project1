<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name'];
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}