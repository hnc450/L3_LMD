<?php

namespace App\Support;

class PlainteStatut
{
    public const EN_ATTENTE = 'En attente';

    public const EN_COURS = 'En cours de traitement';

    public const RESOLUE = 'Résolue';

    public const REJETEE = 'Rejetée';

    public static function all(): array
    {
        return [
            self::EN_ATTENTE,
            self::EN_COURS,
            self::RESOLUE,
            self::REJETEE,
        ];
    }

    public static function badgeClass(string $statut): string
    {
        return match ($statut) {
            self::EN_ATTENTE => 'bg-yellow-100 text-yellow-800',
            self::EN_COURS => 'bg-blue-100 text-blue-800',
            self::RESOLUE => 'bg-green-100 text-green-800',
            self::REJETEE => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public static function icon(string $statut): string
    {
        return match ($statut) {
            self::EN_ATTENTE => '🟡',
            self::EN_COURS => '🔵',
            self::RESOLUE => '🟢',
            self::REJETEE => '🔴',
            default => '⚪',
        };
    }
}
