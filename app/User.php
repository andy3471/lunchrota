<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin'
    ];

    protected $appends = [
        'deleted',
        'available'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
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

    public function getAdminAttribute($value) {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }
    
    public function getScheduledAttribute($value) {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getAppDelAttribute($value) {
        if ($value == '0') {
            return false;
        } else {
            return true;
        }
    }

    public function getAvailableAttribute()
    {
        if (!config('app.roles_enabled')) {
            return true;
        };

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
        return $this->belongsToMany('App\Role')->withPivot('date');
    }

    public function lunches()
    {
        return $this->belongsToMany('App\LunchSlot')->withPivot('date');
    }

    public function appdelsupportdays()
    {
        return $this->hasMany('App\AppDelSupportDay');
    }
}
