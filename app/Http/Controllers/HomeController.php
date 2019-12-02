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
    { }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {

        $lunchslots = Cache::remember('lunchslots', 86400, function () {
            return LunchSlot::all();
        });

        $date = Carbon::today()->toDateString();

        $selectedLunch = DB::table('users')
            ->select('lunch_slots.id')
            ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
            ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
            ->where('lunch_slot_user.date', $date)
            ->where('users.id', Auth::User()->id)
            ->orderBy('users.name')
            ->get();


        //$selectedLunch = $selectedLunch[0]->id;

        return view('home')->withLunchSlots($lunchslots); //->withSelectedLunch($selectedLunch);
    }

    public function about()
    {
        $admins = User::Select('name')->where('admin', true)->get();
        return view('about')->with('admins', $admins);
    }
}
