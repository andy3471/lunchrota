<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isDeleted(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->deleted_at != null;
            }
        );
    }

    // TODO: Tidy this all up
    public function admin(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value > 0;
            }
        );
    }

    // TODO: Tidy this all up
    public function scheduled(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value > 0;
            }
        );
    }

    // TODO: Tidy this all up
    public function appDel(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $value > 0;
            }
        );
    }

    // TODO: Tidy this all up
    public function available(): Attribute
    {
        return Attribute::make(
            get: function () {
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('date');
    }

    public function lunches(): BelongsToMany
    {
        return $this->belongsToMany(LunchSlot::class)
            ->withPivot('date');
    }

    public function appdelsupportdays(): HasMany
    {
        return $this->hasMany(AppDelSupportDay::class);
    }
}
