<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LunchSlot extends Model
{
    protected $appends = ['available_today'];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('date');
    }

    public function getTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }

    public function getAvailableTodayAttribute()
    {
        $date = Carbon::today()->toDateString();

        if (config('app.lunch_slot_calculated')) {
            $ratio = config('app.lunch_slot_calculated_ratio');

            $rolesToday = DB::Table('role_user')
                ->join('roles', 'role_user.role_id', 'roles.id')
                ->join('users', 'role_user.user_id', 'users.id')
                ->where('role_user.date', $date)
                ->where('roles.available', true)
                ->where('users.app_del', false)
                ->count();

            $totalAvailable = floor(1 + (($rolesToday - 1) * ($ratio)));
        } else {
            $totalAvailable = $this->available;
        }

        $totalClaimed = DB::Table('lunch_slot_user')
            ->join('users', 'lunch_slot_user.user_id', 'users.id')
            ->where('users.app_del', false)
            ->where('date', $date)
            ->where('lunch_slot_id', $this->id)
            ->count();

        $remainingAvailable = $totalAvailable - $totalClaimed;
        if ($remainingAvailable < 0) { return 0; };
        return $remainingAvailable;
    }
}
