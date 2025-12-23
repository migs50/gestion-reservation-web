<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $table = 'discussions';

    protected $fillable = [
        'ressource_id',
        'reservation_id',
        'createur_id',
        'statut'
    ];

    protected $casts = [
        'ressource_id' => 'integer',
        'reservation_id' => 'integer',
        'createur_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
