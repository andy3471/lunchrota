<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LunchSlotController extends Controller
{
    // TODO: Rename
    public function getSlots(): JsonResponse
    {
        return response()->json(LunchSlot::orderBy('time')->get());
    }

    // TODO: Rename
    public function userLunches(): JsonResponse
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

        return response()->json($userLunches);
    }

    public function claim(Request $request): JsonResponse
    {
        $date = Carbon::today()->toDateString();
        $lunchslot = LunchSlot::find($request->id);

        if ((! auth()->user()->available) || $lunchslot->available_today >= 1) {
            auth()->user()->lunches()->detach();
            auth()->user()->lunches()->attach($request->id, ['date' => $date]);

            return $this->userLunches();
        } else {
            return response()->json('This lunch slot has been claimed by another user', 403);
        }
    }

    public function unclaim(): JsonResponse
    {
        auth()->user()->lunches()->detach();

        return $this->userLunches();
    }
}
