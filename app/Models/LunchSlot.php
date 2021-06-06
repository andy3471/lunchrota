<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LunchSlot extends Model
{
    /**
     * @var string[]
     */
    protected $appends = ['available_today'];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public static function getUserLunchesByDate($date)
    {
        return (config('database.default') == 'sqlsrv') ? self::getUserLunchesByDateTsql($date) : self::getUserLunchesByDateMySql($date);
    }

    /**
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public static function getUserLunchesByDateTsql($date)
    {
        return DB::table('users')
            ->select('users.id', 'users.name', DB::RAW("FORMAT(CAST(lunch_slots.time as datetime2), N'HH:mm') as time"))
            ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
            ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
            ->where('lunch_slot_user.date', $date)
            ->orderBy('time')
            ->get();
    }

    /**
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public static function getUserLunchesByDateMySql($date)
    {
        return DB::table('users')
            ->select('users.id', 'users.name', 'lunch_slots.time')
            ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
            ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
            ->where('lunch_slot_user.date', $date)
            ->orderBy('users.name')
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getUserLunchesToday()
    {
        $date = Carbon::today()->toDateString();
        return self::getUserLunchesByDate($date);
    }

    /**
     * @param User $user
     * @param $date
     * @return int|mixed
     */
    public static function getUserLunchSlotByDate(User $user, $date)
    {
        $slot = DB::table('users')
            ->select('lunch_slots.id')
            ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
            ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
            ->where('lunch_slot_user.date', $date)
            ->where('users.id', $user->id)
            ->orderBy('users.name')
            ->first();

        return (isset($slot->id)) ? $slot->id : -1;
    }

    /**
     * @param User $user
     * @return int|mixed
     */
    public static function getUserLunchSlotToday(User $user)
    {
        $date = Carbon::today()->toDateString();
        return self::getUserLunchSlotByDate($user, $date);
    }

    /**
     * @return int|mixed|null
     */
    public static function getMyLunchSlotToday()
    {
        return (Auth::check()) ? LunchSlot::getUserLunchSlotToday(Auth::user()) : null;
    }

    /**
     * @param $date
     * @return int|mixed|null
     */
    public static function getMyLunchSlotByDate($date)
    {
        return (Auth::check()) ? LunchSlot::getUserLunchSlotByDate(Auth::user(), $date) : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('date');
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getTimeAttribute($value)
    {
        return substr($value, 0, 5);
    }

    /**
     * @return false|float|int|mixed
     */
    public function getAvailableTodayAttribute()
    {
        $date = Carbon::today()->toDateString();
        $totalAvailable = (config('app.lunch_slot_calculated')) ? $this->getTotalAvailableCalculated($date) : $totalAvailable = $this->available;
        $totalClaimed = $this->getTotalClaimed($date);
        $remainingAvailable = $totalAvailable - $totalClaimed;

        return ($remainingAvailable < 0) ? 0 : $remainingAvailable;
    }

    /**
     * @param $date
     * @return false|float
     */
    public function getTotalAvailableCalculated($date)
    {
        $ratio = config('app.lunch_slot_calculated_ratio');
        $rolesToday = DB::Table('role_user')
            ->join('roles', 'role_user.role_id', 'roles.id')
            ->join('users', 'role_user.user_id', 'users.id')
            ->where('role_user.date', $date)
            ->where('roles.available', true)
            ->where('users.app_del', false)
            ->count();

        return floor(1 + (($rolesToday - 1) * ($ratio)));
    }

    /**
     * @param $date
     * @return int
     */
    public function getTotalClaimed($date)
    {
        return DB::Table('lunch_slot_user')
            ->join('users', 'lunch_slot_user.user_id', 'users.id')
            ->where('users.app_del', false)
            ->where('date', $date)
            ->where('lunch_slot_id', $this->id)
            ->count();
    }
}
