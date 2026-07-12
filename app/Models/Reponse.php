<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reponse extends Model
{
    protected $fillable = [
        'agent_id',
        'complaint_id',
        'message',
    ];

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function plainte(): BelongsTo
    {
        return $this->belongsTo(Plainte::class, 'complaint_id');
    }
}
