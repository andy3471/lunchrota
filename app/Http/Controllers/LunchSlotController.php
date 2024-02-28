<?php

namespace App\Http\Controllers;

use App\Models\LunchSlot;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public function claim(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $lunchslot = LunchSlot::find($request->id);

        if ((Auth::User()->app_del || ! Auth::User()->available) || $lunchslot->available_today >= 1) {
            Auth::User()->lunches()->detach();
            Auth::User()->lunches()->attach($request->id, ['date' => $date]);

            return $this->userLunches();
        } else {
            return response()->json('This lunch slot has been claimed by another user', 403);
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function unclaim()
    {
        Auth::User()->lunches()->detach();

        return $this->userLunches();
    }
}
