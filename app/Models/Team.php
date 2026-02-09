<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Team extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'register_enabled',
        'reset_password_enabled',
        'roles_enabled',
        'lunch_slot_calculated',
        'lunch_slot_calculated_ratio',
        'default_role',
    ];

    /** @return BelongsToMany<User, $this, Pivot> */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /** @return HasMany<Role, $this> */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /** @return HasMany<LunchSlot, $this> */
    public function lunchSlots(): HasMany
    {
        return $this->hasMany(LunchSlot::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'register_enabled'            => 'boolean',
            'reset_password_enabled'      => 'boolean',
            'roles_enabled'               => 'boolean',
            'lunch_slot_calculated'       => 'boolean',
            'lunch_slot_calculated_ratio' => 'decimal:2',
        ];
    }
}
