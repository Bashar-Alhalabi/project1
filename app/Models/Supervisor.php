<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = ['user_id', 'phone', 'stage_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}