<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LunchSlot;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
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

        if (Auth::user()) {
            $available = Auth::user()->available;
        } else {
            $available = true;
        }

        return Inertia::render('Home', [
            'lunchslots'    => $lunchslots,
            'initiallunch'  => $initialSlot,
            'available'     => $available,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $admins = User::admins()->get();
        return Inertia::render('About', [
            'admins' => $admins
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function demo()
    {
        return view('auth.demomode');
    }
}
