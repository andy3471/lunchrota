<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppDelSupportDay;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AppDelSupportDayController extends Controller
{
    /**
     * @return mixed
     */
    public function appDelAdmin()
    {
        $appdels = User::where('app_del', '=', true)->get();

        return Inertia::render('Admin/AppDel', [
            'appdels' => $appdels
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
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

    /**
     * @param Request $request
     * @return bool
     */
    public function post(Request $request)
    {
        // TODO This should be a request + Job
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
