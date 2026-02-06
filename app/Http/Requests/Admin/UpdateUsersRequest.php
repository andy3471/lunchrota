<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    // TODO: Move to filament

    public function rules(): array
    {
        return [
            'users.*.name'         => ['required', 'string'],
            'users.*.email'        => ['email'],
            'users.*.scheduled'    => ['required', 'boolean'],
            'users.*.admin'        => ['required', 'boolean'],
            'users.*.deleted'      => ['required', 'boolean'],
            'users.*.new_password' => ['nullable', 'string', 'min:6'],
        ];
    }
}
