<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use Notifiable;
   

    protected $table = 'users';

    protected $fillable = [
        'role_id',
        'nom',
        'prenom',
        'email',
        'password',
        'statut',
        'secret_question',  
        'secret_answer'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'secret_answer'
    ];

    protected $casts = [
        'role_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /* ===================== RELATIONS ===================== */

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'demandeur_id');
    }

    public function decidedReservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'decideur_id');
    }

    public function managedRessources(): HasMany
    {
        return $this->hasMany(Ressource::class, 'manager_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('lu', false);
    }
   




    /* ===================== LOGIC ===================== */

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->nom === $roleName;
    }

    public function hasAnyRole(array|string $roles): bool
    {
        return $this->role && in_array($this->role->nom, (array) $roles, true);
    }

    public function hasPermission(string $permissionName): bool
    {
        return $this->role
            && $this->role->permissions()
                ->where('nom', $permissionName)
                ->exists();
    }

    public function isActive(): bool
    {
        return $this->statut === 'active';
    }
}
