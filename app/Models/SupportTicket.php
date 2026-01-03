<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id',
        'sujet',
        'description',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
