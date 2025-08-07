<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Call extends Model
{
    protected $fillable = [
        'channel_name',
        'created_by',
        'started_at',
        'ended_at',
    ];

    protected $dates = ['started_at', 'ended_at'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(CallParticipant::class);
    }
}
