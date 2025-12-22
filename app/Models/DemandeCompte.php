<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeCompte extends Model
{
    use HasFactory;

    protected $table = 'demandes_compte';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'affiliation',
        'projet',
        'justification',
        'duree_estimee',
        'ressources_demandees',
        'statut',
        'commentaire_admin',
    ];

    protected $casts = [
        'ressources_demandees' => 'array',
    ];
}