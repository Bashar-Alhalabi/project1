<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'notes', 'start_date', 'end_date', 'semester_id'];
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
