<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderation extends Model
{
    protected $table = 'moderations';

    protected $fillable = [
        'message_id',
        'moderateur_id',
        'action',
        'raison'
    ];

    protected $casts = [
        'message_id' => 'integer',
        'moderateur_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
