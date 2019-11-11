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
        return view('home');
    }

    public function about()
    {
        $admins = User::Select('name')->where('admin', true)->get();
        return view('about')->with('admins', $admins);
    }

    public function dsptest()
    {
        $dsp = Cache::remember('dsp', 600, function () {
            $today = Carbon::now()->toDateString();
            return DailyPassword::where('date', $today)->get();
        });
    }
}
