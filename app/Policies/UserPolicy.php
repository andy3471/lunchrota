<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /** Determine whether the user can update their own password. */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }
}
