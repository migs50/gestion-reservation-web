<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regle extends Model
{
    protected $table = 'regles';

    protected $fillable = [
        'categorie_id',
        'auteur_id',
        'titre',
        'contenu',
        'actif'
    ];

    protected $casts = [
        'categorie_id' => 'integer',
        'auteur_id' => 'integer',
        'actif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
