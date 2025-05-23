<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

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
        'available',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->admin;
    }

    public function isDeleted(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                return $this->deleted_at !== null;
            }
        );
    }

    // TODO: Tidy this all up
    public function available(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                if (! config('app.roles_enabled')) {
                    return true;
                }

                $date = Carbon::today()->toDateString();

                $available = DB::table('role_user')
                    ->select('roles.available')
                    ->join('roles', 'role_user.role_id', 'roles.id')
                    ->where('role_user.user_id', $this->id)
                    ->where('role_user.date', $date)
                    ->first();

                return isset($available->available) && $available->available;
            }
        );
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

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'admin'             => 'boolean',
            'scheduled'         => 'boolean',
        ];
    }
}
