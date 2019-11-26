<?php

namespace App\Http\Controllers;

use App\LunchSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\User;
use Auth;

class LunchSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lunchslots = Cache::remember('lunchslots', 86400, function () {
            return LunchSlot::all();
        });

        return $lunchslots;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::today()->toDateString();

        Auth::User()->lunches()->detach();
        Auth::User()->lunches()->attach($request->id, ['date' => $date]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LunchSlot  $lunchSlot
     * @return \Illuminate\Http\Response
     */
    public function show(LunchSlot $lunchSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LunchSlot  $lunchSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(LunchSlot $lunchSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LunchSlot  $lunchSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LunchSlot $lunchSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LunchSlot  $lunchSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(LunchSlot $lunchSlot)
    {
        Auth::User()->lunches()->detach();
    }
}
