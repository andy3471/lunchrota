<?php

namespace App\Http\Controllers;

use App\LunchSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class LunchSlotController extends Controller
{
    public function getSlots()
    {

        $lunchslots = Cache::remember('lunchslots', 86400, function () {
            return LunchSlot::all();
        });

        return $lunchslots;
    }

    public function userLunches()
    {
        $date = Carbon::today()->toDateString();

        $userLunches = DB::table('users')
            ->select('users.id', 'users.name', 'lunch_slots.time')
            ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
            ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
            ->where('lunch_slot_user.date', $date)
            ->orderBy('users.name')
            ->get();

        return $userLunches;
    }

    public function claim(Request $request)
    {
        $date = Carbon::today()->toDateString();

        Auth::User()->lunches()->detach();
        Auth::User()->lunches()->attach($request->id, ['date' => $date]);

        return $this->userLunches();
    }

    public function unclaim()
    {
        Auth::User()->lunches()->detach();
        return $this->userLunches();
    }

    public function index()
    { }

    public function create()
    { }

    public function show(LunchSlot $lunchSlot)
    { }

    public function edit(LunchSlot $lunchSlot)
    { }

    public function update(Request $request, LunchSlot $lunchSlot)
    { }

    public function destroy(LunchSlot $lunchSlot)
    { }
}
