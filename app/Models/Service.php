<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Service extends Model
{
     use HasFactory;
    protected $fillable = ['name', 'description','image','responsable_id'];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function plaintes()
    {
        return $this->hasMany(Plainte::class, 'id_service');
    }

    public function agents()
    {
        return $this->hasMany(User::class, 'id_service')->whereHas('role', fn ($q) => $q->where('name', 'agent'));
    }
}
