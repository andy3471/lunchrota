<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $lunchslots = LunchSlot::orderBy('time')->get();
        $date = Carbon::today()->toDateString();
        $initialSlot = null;

        if (auth()->check()) {
            $slotResult = DB::table('users')
                ->select('lunch_slots.id')
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->where('users.id', Auth::user()->id)
                ->orderBy('users.name')
                ->first();

            $initialSlot = $slotResult?->id;
        }

        $available = auth()->user()?->available ?? true;

        return Inertia::render('Home', [
            'lunchSlots' => $lunchslots,
            'initialSlot' => $initialSlot,
            'available' => (bool) $available,
        ]);
    }
}
