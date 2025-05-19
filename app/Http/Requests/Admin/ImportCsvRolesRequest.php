<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvRolesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'csv' => ['required', 'file'],
        ];
    }
}
