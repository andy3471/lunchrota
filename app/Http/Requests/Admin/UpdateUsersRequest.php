<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users.*.name' => 'required|string',
            'users.*.email' => 'email',
            'users.*.scheduled' => 'required|boolean',
            'users.*.admin' => 'required|boolean',
            'users.*.app_del' => 'required|boolean',
            'users.*.deleted' => 'required|boolean',
            'users.*.new_password' => 'nullable|string|min:6',
        ];
    }
}
