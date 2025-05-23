<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'available',
    ];

    /** @return BelongsToMany<User, $this, \Illuminate\Database\Eloquent\Relations\Pivot> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('date');
    }

    protected function casts(): array
    {
        return [
            'available' => 'boolean',
        ];
    }
}
