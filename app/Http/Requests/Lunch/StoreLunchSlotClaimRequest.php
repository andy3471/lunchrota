<?php

declare(strict_types=1);

namespace App\Http\Requests\Lunch;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLunchSlotClaimRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        /** @var Team $team */
        $team = app('currentTeam');

        return [
            'id' => [
                'required',
                Rule::exists('lunch_slots', 'id')->where('team_id', $team->id),
            ],
        ];
    }
}
