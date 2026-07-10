<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plainte extends Model
{
    protected $fillable = [
        'id_user','id_service','title','description','piece_jointe','statut','location'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}
