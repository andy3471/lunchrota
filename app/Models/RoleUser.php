<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    /** @return BelongsTo<Role, $this> */
    public function role(): BelongsTo
    {
        return $this
            ->belongsTo(Role::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this
            ->belongsTo(User::class);
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        $table = (new static)->getTable();

        return $query
            ->where("{$table}.date", $date)
            ->join('users', "{$table}.user_id", '=', 'users.id')
            ->orderBy('users.name');
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
