<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Plainte;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function notifyUser(
        User $user,
        Plainte $plainte,
        string $content,
        string $event = 'update'
    ): void {
        self::notify($user->id, $plainte, $content, 'in-app');

        if ($user->email) {
            self::notify($user->id, $plainte, $content, 'email');
            Mail::raw($content, function ($message) use ($user, $plainte, $event) {
                $message->to($user->email)
                    ->subject(self::subjectFor($event, $plainte));
            });
        }

        if ($user->phone) {
            self::notify($user->id, $plainte, $content, 'SMS');
            SmsService::send($user->phone, $content);
        }
    }

    public static function notify(
        int $userId,
        Plainte $plainte,
        string $content,
        string $type = 'in-app'
    ): Notification {
        return Notification::create([
            'id_user' => $userId,
            'id_plainte' => $plainte->id,
            'type' => $type,
            'content' => $content,
            'status' => 'sent',
        ]);
    }

    public static function plainteCreated(Plainte $plainte): void
    {
        if (! $plainte->user) {
            return;
        }

        self::notifyUser(
            $plainte->user,
            $plainte,
            "Votre plainte « {$plainte->title} » a été enregistrée. Référence : {$plainte->code_suivi}.",
            'creation'
        );
    }

    public static function assigned(Plainte $plainte, User $agent): void
    {
        if ($plainte->user) {
            self::notifyUser(
                $plainte->user,
                $plainte,
                "Votre plainte {$plainte->code_suivi} a été affectée à l'agent {$agent->name}.",
                'affectation'
            );
        }

        self::notify(
            $agent->id,
            $plainte,
            "Une nouvelle plainte vous a été affectée : {$plainte->code_suivi} — {$plainte->title}.",
            'in-app'
        );

        if ($agent->email) {
            Mail::raw(
                "Plainte affectée : {$plainte->code_suivi}",
                fn ($m) => $m->to($agent->email)->subject('Nouvelle plainte affectée')
            );
        }
    }

    public static function statusUpdated(Plainte $plainte, string $oldStatus): void
    {
        if (! $plainte->user) {
            return;
        }

        self::notifyUser(
            $plainte->user,
            $plainte,
            "Le statut de votre plainte {$plainte->code_suivi} est passé de « {$oldStatus} » à « {$plainte->statut} ».",
            'statut'
        );
    }

    public static function resolved(Plainte $plainte): void
    {
        if (! $plainte->user) {
            return;
        }

        self::notifyUser(
            $plainte->user,
            $plainte,
            "Votre plainte {$plainte->code_suivi} a été résolue. Merci de votre patience.",
            'resolution'
        );
    }

    public static function responseAdded(Plainte $plainte, string $message): void
    {
        if (! $plainte->user) {
            return;
        }

        self::notifyUser(
            $plainte->user,
            $plainte,
            "Nouvelle réponse sur votre plainte {$plainte->code_suivi} : {$message}",
            'reponse'
        );
    }

    private static function subjectFor(string $event, Plainte $plainte): string
    {
        return match ($event) {
            'creation' => "Confirmation de dépôt — {$plainte->code_suivi}",
            'affectation' => "Affectation de votre plainte — {$plainte->code_suivi}",
            'resolution' => "Plainte résolue — {$plainte->code_suivi}",
            default => "Mise à jour plainte — {$plainte->code_suivi}",
        };
    }
}
