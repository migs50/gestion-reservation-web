<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'statut'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'role_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the role of the user
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->nom === $roleName;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole($roles)
    {
        return $this->role && in_array($this->role->nom, (array) $roles);
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permissionName)
    {
        return $this->role && $this->role->permissions()->where('nom', $permissionName)->exists();
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->statut === 'active';
    }

    /**
     * Get user's reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'demandeur_id');
    }

    /**
     * Get reservations decided by this user
     */
    public function decidedReservations()
    {
        return $this->hasMany(Reservation::class, 'decideur_id');
    }

    /**
     * Get resources managed by this user
     */
    public function managedRessources()
    {
        return $this->hasMany(Ressource::class, 'manager_id');
    }

    /**
     * Get user's notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
