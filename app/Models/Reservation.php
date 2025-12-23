<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'demandeur_id',
        'ressource_id', //ressource_iAJOUTE (adam)
        'decideur_id',
        'debut',
        'fin',
        'justification',
        'statut',
        'note_decision',
    ];

    protected $casts = [
        'demandeur_id' => 'integer',
        'ressource_id' => 'integer',
        'decideur_id'  => 'integer',
        'debut'        => 'datetime',
        'fin'          => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    public function ressource(): BelongsTo
    {
        return $this->belongsTo(Ressource::class);
    }

    public function demandeur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function decideur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decideur_id');
    }
}
