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
        'password'
    ];

    protected $casts = [
        'role_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
