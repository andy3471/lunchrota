<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Cache;
use App\LunchSlot;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function index()
    {
        $lunchslots = LunchSlot::orderBy('time')->get();
        $date = Carbon::today()->toDateString();

        if (Auth::check()) {
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

        return view('home')->withLunchSlots($lunchslots)->withInitialSlot($initialSlot);
    }

    public function about()
    {
        $admins = User::Select('name')->where('admin', true)->get();
        return view('about')->with('admins', $admins);
    }

    public function demo()
    {
        return view('auth.demomode');
    }
}
