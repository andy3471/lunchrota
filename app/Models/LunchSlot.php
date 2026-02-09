<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class LunchSlot extends Model
{
    use HasUuids;

    protected $fillable = [
        'time',
        'available',
        'team_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /** @return BelongsTo<Team, $this> */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /** @return BelongsToMany<User, $this, Pivot> */
    public function users(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class)
            ->withPivot('date');
    }

    public function getTotalAvailableForDate(string $date): int|float
    {
        if (! config('app.lunch_slot_calculated')) {
            return $this->available;
        }

        $ratio      = config('app.lunch_slot_calculated_ratio');
        $rolesToday = RoleUser::query()
            ->where('date', $date)
            ->whereHas('role', fn ($query) => $query->where('is_available', true))
            ->count();

        return (int) floor(1 + (($rolesToday - 1) * $ratio));
    }

    public function getClaimedCountForDate(string $date): int
    {
        return DB::table('lunch_slot_user')
            ->where('lunch_slot_id', $this->id)
            ->where('date', $date)
            ->count();
    }

    public function getAvailableForDate(string $date): int|float
    {
        return max(0, $this->getTotalAvailableForDate($date) - $this->getClaimedCountForDate($date));
    }

    #[\Illuminate\Database\Eloquent\Attributes\Scope]
    protected function withUsersForDate(Builder $query, string $date): Builder
    {
        return $query
            ->with(['users' => fn ($q) => $q->wherePivot('date', $date)])
            ->whereHas('users', fn ($q) => $q->wherePivot('date', $date));
    }

    /** @return Attribute<string, never> */
    protected function time(): Attribute
    {
        return Attribute::make(
            get: function ($value): string {
                return mb_substr($value, 0, 5);
            });
    }

    /** @return Attribute<int|float, never> */
    protected function totalAvailableToday(): Attribute
    {
        return Attribute::make(
            get: fn (): int|float => $this->getTotalAvailableForDate(\Illuminate\Support\Facades\Date::today()->toDateString())
        );
    }

    /** @return Attribute<int, never> */
    protected function claimedCountToday(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->getClaimedCountForDate(\Illuminate\Support\Facades\Date::today()->toDateString())
        );
    }

    /** @return Attribute<int|float, never> */
    protected function availableToday(): Attribute
    {
        return Attribute::make(
            get: fn (): int|float => $this->getAvailableForDate(\Illuminate\Support\Facades\Date::today()->toDateString())
        );
    }

    protected function casts(): array
    {
        return [
            'time'      => 'datetime',
            'available' => 'integer',
        ];
    }
}
