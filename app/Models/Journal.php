<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';

    protected $fillable = [
        'acteur_id',
        'action',
        'objet',
        'objet_id',
        'donnees',
        'ip',
        'user_agent'
    ];

    protected $casts = [
        'acteur_id' => 'integer',
        'objet_id' => 'integer',
        'donnees' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
