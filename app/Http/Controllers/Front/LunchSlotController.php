<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LunchSlotController extends Controller
{
    public function claim(Request $request): RedirectResponse
    {
        /** @var Team $team */
        $team = app('currentTeam');

        $date      = \Illuminate\Support\Facades\Date::today()->toDateString();
        $lunchslot = $team->lunchSlots()->findOrFail($request->id);

        if ((! auth()->user()->available_today) || $lunchslot->available_today >= 1) {
            auth()->user()->lunches()->detach();
            auth()->user()->lunches()->attach($request->id, ['date' => $date]);

            return redirect()->route('home');
        }

        return redirect()->route('home')->with('error', 'This lunch slot has been claimed by another user');
    }

    public function unclaim(): RedirectResponse
    {
        auth()->user()->lunches()->detach();

        return redirect()->route('home');
    }
}
