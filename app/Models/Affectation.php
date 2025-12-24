<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    protected $table = 'affectations';

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'reservation_id',
        'ressource_id',
        'debut_prevu',
        'fin_prevue',
        'debut_reel',
        'fin_reel',
        'statut'
    ];

    protected $casts = [
        'reservation_id' => 'integer',
        'ressource_id' => 'integer',
        'debut_prevu' => 'datetime',
        'fin_prevue' => 'datetime',
        'debut_reel' => 'datetime',
        'fin_reel' => 'datetime'
    ];

    /**
     * Get the reservation that owns the affectation
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the ressource that owns the affectation
     */
    public function ressource()
    {
        return $this->belongsTo(Ressource::class);
    }
}
