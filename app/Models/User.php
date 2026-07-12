<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'phone', 'id_role', 'id_service', 'created_by', 'api_token'])]
#[Hidden(['password', 'remember_token', 'api_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'responsable_id');
    }

    public function assignedService()
    {
        return $this->belongsTo(Service::class, 'id_service');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdAgents()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function plaintes()
    {
        return $this->hasMany(Plainte::class, 'id_user');
    }

    public function plaintesAssignees()
    {
        return $this->hasMany(Plainte::class, 'agent_id');
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'agent_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user');
    }

    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    public function isCitoyen(): bool
    {
        return $this->hasRole('citoyen');
    }

    public function isResponsable(): bool
    {
        return $this->hasRole('responsable');
    }

    public function dashboardRoute(): string
    {
        return match ($this->role?->name) {
            'admin' => 'admin.index',
            'agent' => 'agent.index',
            'responsable' => 'responsable.index',
            default => 'user.dashboard',
        };
    }
}
