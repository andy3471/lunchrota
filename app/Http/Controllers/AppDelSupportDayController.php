<?php

namespace App\Http\Controllers;

use App\AppDelSupportDay;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AppDelSupportDayController extends Controller
{
    public function appDelAdmin()
    {
        $appdels = User::where('app_del', '=', true)->get();
        return view('admin.appdel.index')->withAppdels($appdels);
    }

    public function supportToday()
    {
        Cache::forget('appdelsupport');

        $today = Carbon::now()->toDateString();
        $appDelSupport = Cache::remember('appdelsupport', 600, function () {
            $today = Carbon::now()->toDateString();
            return DB::table('users')
            ->select('users.name')
            ->join('app_del_support_days', 'users.id', '=', 'app_del_support_days.user_id')
            ->where('app_del_support_days.date', $today)
            ->get();
        });

        return $appDelSupport;
    }

    public function get(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $user_id = $request->user_id;

        $AppDelSupportDay = AppDelSupportDay::where('date', '=', $date)->where('user_id', '=', $user_id)->get();

        if ($AppDelSupportDay->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function post(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $user_id = $request->user_id;
        $on_support = $request->on_support;

        if ($on_support) {
            $supportDay = new AppDelSupportDay;
            $supportDay->user_id = $user_id;
            $supportDay->date = $date;
            $supportDay->Save();
            Cache::forget('appdelsupport');
            return true;
        } else {;
            $supportDay = AppDelSupportDay::where('user_id', '=', $user_id)->where('date', '=', $date);
            $supportDay->delete();
            Cache::forget('appdelsupport');
            return false;
        }
    }
}
