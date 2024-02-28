<?php

namespace App\Http\Requests;

use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'currentpassword' => ['required', new CurrentPassword],
            'newpassword' => 'required|string|min:6|confirmed|different:currentpassword',
        ];
    }
}
