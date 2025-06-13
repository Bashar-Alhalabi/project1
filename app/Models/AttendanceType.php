<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceType extends Model
{
    protected $fillable = ['name', 'value'];
    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
}
