<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $primaryKey = 'id_feedback';

    protected $fillable = [
        'id_plainte',
        'id_user',
        'note',
        'comment',
    ];

    public function plainte(): BelongsTo
    {
        return $this->belongsTo(Plainte::class, 'id_plainte');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
