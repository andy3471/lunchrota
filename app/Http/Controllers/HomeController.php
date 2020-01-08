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

        return view('home')->withLunchSlots($lunchslots);
    }

    public function about()
    {
        $admins = User::Select('name')->where('admin', true)->get();
        return view('about')->with('admins', $admins);
    }
}
