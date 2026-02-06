<?php

declare(strict_types=1);

namespace App\Models;

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
}
