<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppDelSupportDayRequest;
use App\Jobs\Admin\StoreAppDelSupportDayJob;
use App\Models\AppDelSupportDay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            'appdels' => $appdels,
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function get(Request $request)
    {
        $date = Carbon::parse($request->date)->toDateString();
        $AppDelSupportDay = AppDelSupportDay::where('date', '=', $date)->where('user_id', '=', $request->user_id)->get();

        return ($AppDelSupportDay->isEmpty()) ? false : true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function post(StoreAppDelSupportDayRequest $request)
    {
        return StoreAppDelSupportDayJob::dispatchNow($request);
    }
}
