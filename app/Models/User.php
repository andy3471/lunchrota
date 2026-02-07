<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
    ];

    protected $appends = [
        'deleted',
        'available_today',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin;
    }

    /** @return BelongsToMany<Role, $this, \Illuminate\Database\Eloquent\Relations\Pivot> */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('date');
    }

    /** @return BelongsToMany<LunchSlot, $this, \Illuminate\Database\Eloquent\Relations\Pivot> */
    public function lunches(): BelongsToMany
    {
        return $this->belongsToMany(LunchSlot::class)
            ->withPivot('date');
    }

    public function lunchesForDate(string $date): BelongsToMany
    {
        return $this->lunches()->wherePivot('date', $date);
    }

    public function scopeWithLunchesForDate(Builder $query, string $date): Builder
    {
        return $query
            ->with(['lunches' => fn ($q) => $q->wherePivot('date', $date)->orderBy('time')])
            ->whereHas('lunches', fn ($q) => $q->where('lunch_slot_user.date', $date))
            ->orderBy('name');
    }

    public function isAvailableForDate(string $date): bool
    {
        if (! config('app.roles_enabled')) {
            return true;
        }

        $roleUser = RoleUser::query()
            ->where('user_id', $this->id)
            ->where('date', $date)
            ->whereHas('role', fn ($query) => $query->where('available', true))
            ->first();

        return $roleUser !== null;
    }

    protected function isDeleted(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                return $this->deleted_at !== null;
            }
        );
    }

    /** @return Attribute<bool, never> */
    protected function availableToday(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->isAvailableForDate(Carbon::today()->toDateString())
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'admin'             => 'boolean',
            'scheduled'         => 'boolean',
        ];
    }
}
