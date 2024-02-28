<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolesRequest extends FormRequest
{
    // TODO: Move to filament

    public function rules(): array
    {
        return [
            'roles.*.name' => 'required|string',
            'roles.*.available' => 'required|boolean',
        ];
    }
}
