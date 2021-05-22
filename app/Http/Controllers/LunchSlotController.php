<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateLunchSlotsRequest;
use App\Jobs\AdminUpdateLunchSlotsJob;
use App\LunchSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class LunchSlotController extends Controller
{
    /**
     * @return mixed
     */
    public function getSlots()
    {
        return LunchSlot::orderBy('time')->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function userLunches()
    {
        $date = Carbon::today()->toDateString();

        if (config('database.default') == 'sqlsrv') {
            $userLunches = DB::table('users')
                ->select('users.id', 'users.name', DB::RAW("FORMAT(CAST(lunch_slots.time as datetime2), N'HH:mm') as time"))
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->orderBy('time')
                ->get();
        } else {
            $userLunches = DB::table('users')
                ->select('users.id', 'users.name', 'lunch_slots.time')
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->orderBy('users.name')
                ->get();
        }

        return $userLunches;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public function claim(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $lunchslot = LunchSlot::find($request->id);

        if ((Auth::User()->app_del || !Auth::User()->available) || $lunchslot->available_today >= 1) {
            Auth::User()->lunches()->detach();
            Auth::User()->lunches()->attach($request->id, ['date' => $date]);
            return $this->userLunches();
        } else {
            return response()->json('This lunch slot has been claimed by another user', 403);
        }
    }

    public function unclaim(): \Illuminate\Support\Collection
    {
        Auth::User()->lunches()->detach();
        return $this->userLunches();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.lunches.index');
    }

    /**
     * @return mixed
     */
    public function getAdminSlots()
    {
        return LunchSlot::orderBy('Time')->get();
    }

    /**
     * @param AdminUpdateLunchSlotsRequest $request
     * @return mixed
     */
    public function adminUpdateLunchSlots(AdminUpdateLunchSlotsRequest $request)
    {
        AdminUpdateLunchSlotsJob::dispatchNow($request);
        return LunchSlot::orderBy('time')->get();
    }
}
