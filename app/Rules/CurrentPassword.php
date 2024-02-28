<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
{
    // TODO: Is this needed?
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, auth()->user()->password);
    }

    public function message()
    {
        return 'The Current Password is incorrect.';
    }
}
