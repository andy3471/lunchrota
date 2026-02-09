<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;

class LunchSlotPolicy
{
    /** Determine whether the user can claim a lunch slot. */
    public function create(User $user): bool
    {
        return true;
    }

    /** Determine whether the user can unclaim a lunch slot. */
    public function delete(User $user): bool
    {
        return $user->lunches()->exists();
    }
}
