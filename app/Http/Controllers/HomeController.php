<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\DailyPassword;

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

        return view('home')->withLunchSlots($lunchslots);
    }

    public function about()
    {
        $admins = User::Select('name')->where('admin', true)->get();
        return view('about')->with('admins', $admins);
    }
}
