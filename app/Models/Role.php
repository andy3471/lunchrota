<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('date');
    }

    public function available($value): Attribute
    {
        return Attribute::make(
            get: function () use ($value) {
                return $value > 0;
            }
        );
    }
}
