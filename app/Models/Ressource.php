<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'categorie',
        'type',
        'icone',
        'specifications',
        'statut',
        'actif',
        'responsable_id',
    ];

    protected $casts = [
        'specifications' => 'array',
        'actif' => 'boolean',
    ];

    // Relations
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
