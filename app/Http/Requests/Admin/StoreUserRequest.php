<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    // TODO: Move to filament
    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /** Get the validation rules that apply to the request. */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'unique:users'],
            'name'     => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
