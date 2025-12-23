<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValeurAttr extends Model
{
    protected $table = 'valeur_attrs';

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'ressource_id',
        'attribut_id',
        'v_string',
        'v_number',
        'v_bool',
        'v_date'
    ];

    protected $casts = [
        'ressource_id' => 'integer',
        'attribut_id' => 'integer',
        'v_number' => 'decimal:4',
        'v_bool' => 'boolean',
        'v_date' => 'date'
    ];
}
