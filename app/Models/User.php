<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasFactory;
    use HasUuids;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_approved',
        'is_scheduled',
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
        return $this->is_admin;
    }

    /** @return Collection<int, Team> */
    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams()->whereKey($tenant->getKey())->exists();
    }

    /** @return BelongsToMany<Team, $this, Pivot> */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    /** @return BelongsToMany<Role, $this, Pivot> */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('date');
    }

    /** @return BelongsToMany<LunchSlot, $this, Pivot> */
    public function lunches(): BelongsToMany
    {
        return $this->belongsToMany(LunchSlot::class)
            ->withPivot('date');
    }

    public function lunchesForDate(string $date): BelongsToMany
    {
        return $this->lunches()->wherePivot('date', $date);
    }

    public function isAvailableForDate(string $date): bool
    {
        if (! config('app.roles_enabled')) {
            return true;
        }

        $roleUser = RoleUser::query()
            ->where('user_id', $this->id)
            ->where('date', $date)
            ->whereHas('role', fn ($query) => $query->where('is_available', true))
            ->first();

        return $roleUser !== null;
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function withLunchesForDate(Builder $query, string $date): Builder
    {
        return $query
            ->with(['lunches' => fn ($q) => $q->wherePivot('date', $date)->orderBy('time')])
            ->whereHas('lunches', fn ($q) => $q->where('lunch_slot_user.date', $date))
            ->orderBy('name');
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
            get: fn (): bool => $this->isAvailableForDate(\Illuminate\Support\Facades\Date::today()->toDateString())
        );
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_admin'          => 'boolean',
            'is_approved'       => 'boolean',
            'is_scheduled'      => 'boolean',
        ];
    }
}
