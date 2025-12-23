<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePerm extends Model
{
    protected $table = 'role_perms';

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'role_id',
        'perm_id'
    ];

    protected $casts = [
        'role_id' => 'integer',
        'perm_id' => 'integer'
    ];
}
