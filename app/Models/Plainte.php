<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plainte extends Model
{
    protected $fillable = [
        'code_suivi',
        'id_user',
        'id_service',
        'agent_id',
        'contact_nom',
        'contact_info',
        'title',
        'description',
        'piece_jointe',
        'statut',
        'priorite',
        'location',
    ];

    public static function generateCodeSuivi(): string
    {
        do {
            $code = 'PLT-' . strtoupper(substr(uniqid(), -8));
        } while (self::where('code_suivi', $code)->exists());

        return $code;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function reponses(): HasMany
    {
        return $this->hasMany(Reponse::class, 'complaint_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'id_plainte');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'id_plainte');
    }

    public function interventions(): HasMany
    {
        return $this->hasMany(Intervention::class, 'plainte_id');
    }

    public function citoyenNom(): string
    {
        return $this->user?->name ?? $this->contact_nom ?? 'Anonyme';
    }
}
