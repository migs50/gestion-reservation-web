<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'discussion_id',
        'incident_id',
        'auteur_id',
        'contenu',
        'cache'
    ];

    protected $casts = [
        'discussion_id' => 'integer',
        'incident_id' => 'integer',
        'auteur_id' => 'integer',
        'cache' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
