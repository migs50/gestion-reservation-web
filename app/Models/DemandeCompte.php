<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeCompte extends Model
{
    protected $table = 'demande_comptes';

    protected $fillable = [
        'nom_complet',
        'email',
        'telephone',
        'type_demande',
        'justification',
        'password',
        'statut',
        'decided_by',
        'note_decision'
    ];

    protected $casts = [
        'decided_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
