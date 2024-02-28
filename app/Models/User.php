<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'admin',
    ];

    protected $appends = [
        'deleted',
        'available',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getDeletedAttribute()
    {
        if ($this->deleted_at == null) {
            return false;
        } else {
            return true;
        }
    }

    public function getAdminAttribute($value)
    {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getScheduledAttribute($value)
    {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getAppDelAttribute($value)
    {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getAvailableAttribute()
    {
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

        if (isset($available->available) && $available->available) {
            return true;
        } else {
            return false;
        }
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withPivot('date');
    }

    public function lunches()
    {
        return $this->belongsToMany('App\Models\LunchSlot')->withPivot('date');
    }

    public function appdelsupportdays()
    {
        return $this->hasMany('App\AppDelSupportDay');
    }
}
