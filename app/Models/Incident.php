<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $table = 'incidents';

    protected $fillable = [
        'declarant_id',
        'ressource_id',
        'assigne_id',
        'titre',
        'description',
        'statut'
    ];

    protected $casts = [
        'declarant_id' => 'integer',
        'ressource_id' => 'integer',
        'assigne_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    /**
     * Fixes "undefined relationship [ressource]"
     */
    public function ressource()
    {
        return $this->belongsTo(Ressource::class, 'ressource_id');
    }

    /**
     * Links to the user who declared the incident
     */
    public function declarant()
    {
        return $this->belongsTo(User::class, 'declarant_id');
    }

    /**
     * Links to the user assigned to fix it (can be null)
     */
    public function assigne()
    {
        return $this->belongsTo(User::class, 'assigne_id');
    }
}

