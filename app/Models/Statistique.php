<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistique extends Model
{
    protected $table = 'statistiques';

    protected $primaryKey = 'id_stat';

    protected $fillable = [
        'id_service',
        'nombre_plaintes',
        'temps_moyen_resolution',
        'taux_satisfaction',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
