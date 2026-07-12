<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'id_user',
        'id_plainte',
        'type',
        'content',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function plainte(): BelongsTo
    {
        return $this->belongsTo(Plainte::class, 'id_plainte');
    }
}
