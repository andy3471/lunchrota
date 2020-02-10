<?php

namespace App\Http\Controllers;

use App\LunchSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class LunchSlotController extends Controller
{
    public function getSlots()
    {
        return LunchSlot::all();
    }

    public function userLunches()
    {
        $date = Carbon::today()->toDateString();

        if (config('database.default') == 'sqlsrv') {
            $userLunches = DB::table('users')
                ->select('users.id', 'users.name', DB::RAW("FORMAT(CAST(lunch_slots.time as datetime2), N'HH:mm') as time"))
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->orderBy('users.name')
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

    public function claim(Request $request)
    {
        $date = Carbon::today()->toDateString();

        Auth::User()->lunches()->detach();
        Auth::User()->lunches()->attach($request->id, ['date' => $date]);

        $lunchslot = LunchSlot::find($request->id);

        if ($lunchslot->available_today < 0) {
            return response()->json('This lunch slot has been claimed by another user', 403);
        }

        return $this->userLunches();
    }

    public function unclaim()
    {
        Auth::User()->lunches()->detach();
        return $this->userLunches();
    }

    public function index()
    {
        return view('admin.lunches.index');
    }

    public function getAdminSlots()
    {
        return LunchSlot::orderBy('Time')->get();
    }

    public function adminUpdateSlots(Request $request)
    {
        $this->validate($request, [
            'slots.*.time' => 'required|date_format:H:i',
            'roles.*.available'    => 'required|integer',
        ]);

        $slots = collect($request->slots);
        $deletedSlots = LunchSlot::whereNotIn('id', $slots->where('id', '!=', null)->pluck('id')->toArray())->get();

        foreach ($deletedSlots as $slot) {
            $slot->users()->detach();
            $slot->delete();
        };

        foreach ($slots as $s) {
            if ($s['id'] == 0) {
                $slot = new LunchSlot;
                $slot->time = $s['time'];
            } else {
                $slot = LunchSlot::find($s['id']);
            }

            if (config('app.lunch_slot_calculated')) {
            } else {
                $slot->available = $s['available'];
            }

            $slot->save();
        }

        return LunchSlot::orderBy('time')->get();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $lunchSlot = new LunchSlot;
        $lunchSlot->time = $request->time;
        $lunchSlot->available = $request->available;
        $lunchSlot->save;
    }

    public function show(LunchSlot $lunchSlot)
    {
    }

    public function edit(LunchSlot $lunchSlot)
    {
    }

    public function update(Request $request, LunchSlot $lunchSlot)
    {
    }

    public function destroy(LunchSlot $lunchSlot)
    {
        return $lunchSlot;

        $lunchSlot->users()->detatch();
        $lunchSlot->delete();
    }
}
