<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'demandeur_id',
        'decideur_id',
        'debut',
        'fin',
        'justification',
        'statut',
        'note_decision'
    ];

    protected $casts = [
        'demandeur_id' => 'integer',
        'decideur_id' => 'integer',
        'debut' => 'datetime',
        'fin' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
