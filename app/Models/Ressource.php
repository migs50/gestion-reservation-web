<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ressource extends Model
{
    protected $table = 'ressources';

    protected $fillable = [
        'categorie_id',
        'manager_id',
        'nom',
        'code_inv',
        'etat',
        'actif',
        'emplacement',
        'description'
    ];

    protected $casts = [
        'categorie_id' => 'integer',
        'manager_id'   => 'integer',
        'actif'        => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
