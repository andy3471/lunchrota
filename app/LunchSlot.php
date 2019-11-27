<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LunchSlot extends Model
{
    protected $appends = ['available_today'];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('date');
    }

    public function getAvailableTodayAttribute()
    {
        $date = Carbon::today()->toDateString();

        $rolesToday = DB::Table('role_user')
            ->join('roles', 'role_user.role_id', 'roles.id')
            ->where('role_user.date', $date)
            ->where('roles.available', true)
            ->count();

        $totalAvailable = floor(1 + (($rolesToday - 1) * (1 / 3)));

        $totalClaimed = DB::Table('lunch_slot_user')
            ->where('date', $date)
            ->where('lunch_slot_id', $this->id)
            ->count();

        $remainingAvailable = $totalAvailable - $totalClaimed;

        return $remainingAvailable;
    }
}
