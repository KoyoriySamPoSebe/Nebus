<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = ['name', 'key_hash', 'revoked', 'scopes'];

    protected $casts = [
        'scopes' => 'array',
        'revoked' => 'boolean',
    ];
}
