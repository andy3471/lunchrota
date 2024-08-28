<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    // TODO: Refactor
    public function index(): View
    {
        $lunchslots = LunchSlot::orderBy('time')->get();
        $date = Carbon::today()->toDateString();

        if (auth()->check()) {
            $initialSlot = DB::table('users')
                ->select('lunch_slots.id')
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->where('users.id', Auth::user()->id)
                ->orderBy('users.name')
                ->first();
        }

        if (isset($initialSlot->id)) {
            $initialSlot = $initialSlot->id;
        } else {
            $initialSlot = '-1';
        }

        if (auth()->user()) {
            $available = auth()->user()->available;
        } else {
            $available = true;
        }

        return view('home')->withLunchSlots($lunchslots)->withInitialSlot($initialSlot)->withAvailable($available);
    }

    public function demo(): View
    {
        return view('auth.demo-mode');
    }
}
