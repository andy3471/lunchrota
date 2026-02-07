<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Role extends Model
{
    protected $fillable = [
        'name',
        'is_available',
    ];

    /** @return BelongsToMany<User, $this, Pivot> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('date');
    }

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }
}
