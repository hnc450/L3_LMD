<?php

namespace App\Services;

use App\Models\Intervention;
use App\Models\Plainte;
use App\Models\User;

class InterventionService
{
    public static function create(
        Plainte $plainte,
        User $agent,
        string $type,
        string $description,
        string $statut = 'en_cours'
    ): Intervention {
        return Intervention::create([
            'plainte_id' => $plainte->id,
            'agent_id' => $agent->id,
            'type' => $type,
            'description' => $description,
            'statut' => $statut,
            'date_debut' => now(),
            'date_fin' => $statut === 'terminee' ? now() : null,
        ]);
    }
}
