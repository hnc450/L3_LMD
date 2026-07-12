<?php

namespace App\Support;

use App\Models\Plainte;
use App\Models\Service;
use App\Models\User;

class PlainteAccess
{
    public static function managedService(User $user): ?Service
    {
        return Service::where('responsable_id', $user->id)->first();
    }

    public static function canView(User $user, Plainte $plainte): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isCitoyen()) {
            return $plainte->id_user === $user->id;
        }

        if ($user->isAgent()) {
            return $plainte->agent_id === $user->id
                && $plainte->id_service === $user->id_service;
        }

        if ($user->isResponsable()) {
            $service = self::managedService($user);

            return $service && $plainte->id_service === $service->id;
        }

        return false;
    }

    public static function canEdit(User $user, Plainte $plainte): bool
    {
        if ($user->isAdmin() || $user->isCitoyen()) {
            return $plainte->id_user === $user->id;
        }

        if ($user->isResponsable()) {
            $service = self::managedService($user);

            return $service && $plainte->id_service === $service->id;
        }

        return false;
    }

    public static function canManage(User $user, Plainte $plainte): bool
    {
        if (! $user->isResponsable()) {
            return false;
        }

        $service = self::managedService($user);

        return $service && $plainte->id_service === $service->id;
    }
}
