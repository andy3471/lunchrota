<?php

namespace App\Http\Controllers;

use App\Models\LunchSlot;
use App\Models\User;
use Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $lunchslots = LunchSlot::orderBy('time')->get();
        $initialSlot = LunchSlot::getMyLunchSlotToday();
        (Auth::user()) ? $available = Auth::user()->available : $available = true;

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
            'admins' => $admins,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function demo()
    {
        return Inertia::render('Demo');
    }
}
