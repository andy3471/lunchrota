<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLunchSlotsRequest extends FormRequest
{
    // TODO: Move to filament

    public function rules(): array
    {
        return [
            'slots.*.time'      => ['required', 'date_format:H:i'],
            'roles.*.available' => ['required', 'integer'],
        ];
    }
}
