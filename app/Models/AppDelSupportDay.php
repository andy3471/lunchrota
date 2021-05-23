<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppDelSupportDay extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function appDelToday()
    {
        Return Cache::remember('appdelsupport', 600, function () {
            $today = Carbon::now()->toDateString();
            return DB::table('users')
                ->select('users.name')
                ->join('app_del_support_days', 'users.id', '=', 'app_del_support_days.user_id')
                ->where('app_del_support_days.date', $today)
                ->get();
        });

    }
}
