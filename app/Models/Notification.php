<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'titre',
        'contenu',
        'lu'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'lu' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
