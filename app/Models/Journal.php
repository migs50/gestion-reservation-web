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
        'details',
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

    /**
     * Get the user who performed the action
     */
    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteur_id');
    }

    /**
     * Get a human-readable action label
     */
    public function getActionLabelAttribute()
    {
        $labels = [
            'login' => 'Connexion',
            'logout' => 'Déconnexion',
            'create' => 'Création',
            'update' => 'Modification',
            'delete' => 'Suppression',
            'approve' => 'Approbation',
            'reject' => 'Refus',
            'cancel' => 'Annulation',
            'activate' => 'Activation',
            'complete' => 'Finalisation',
            'state_change' => 'Changement d\'état',
        ];

        return $labels[$this->action] ?? ucfirst($this->action);
    }
}
