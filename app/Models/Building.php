<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = ['address', 'location'];

    protected $casts = [
        'location' => Point::class,
    ];

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
