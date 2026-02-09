<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Team> */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        $name = fake()->company();

        return [
            'name'                        => $name,
            'slug'                        => Str::slug($name).'-'.fake()->unique()->numberBetween(1, 9999),
            'register_enabled'            => true,
            'reset_password_enabled'      => false,
            'roles_enabled'               => true,
            'lunch_slot_calculated'       => false,
            'lunch_slot_calculated_ratio' => 0.33,
            'default_role'                => 'none',
        ];
    }
}
