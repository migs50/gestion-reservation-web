<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nom'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the users for this role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the permissions for this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_perms', 'role_id', 'perm_id');
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('nom', $permissionName)->exists();
    }
}
