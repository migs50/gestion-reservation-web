<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indispo extends Model
{
    protected $table = 'indispos';

    protected $fillable = [
        'ressource_id',
        'created_by',
        'type',
        'debut',
        'fin',
        'raison',
        'actif'
    ];

    protected $casts = [
        'ressource_id' => 'integer',
        'created_by' => 'integer',
        'debut' => 'datetime',
        'fin' => 'datetime',
        'actif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
