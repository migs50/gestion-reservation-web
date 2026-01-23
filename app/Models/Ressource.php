<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'description',
        'cpu',
        'ram',
        'os',
        'bande_passante',
        'capacite',
        'type_stockage'
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
    public function ressource()
{
    return $this->belongsTo(Ressource::class);
}

public function demandeur()
{
    return $this->belongsTo(User::class, 'demandeur_id');
}
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function responsable()
{
    return $this->belongsTo(User::class, 'manager_id');
}

}
