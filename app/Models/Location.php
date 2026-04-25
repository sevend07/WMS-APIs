<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Location extends Model
{
    protected $fillable = [
        'state',
        'regency',
        'district',
        'postal_code',
        'address',
    ];

    public function locateable(): MorphTo
    {
        return $this->morphTo();
    }
}
