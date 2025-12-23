<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribut extends Model
{
    protected $table = 'attributs';

    protected $fillable = [
        'categorie_id',
        'nom',
        'type_valeur',
        'unite'
    ];

    protected $casts = [
        'categorie_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
