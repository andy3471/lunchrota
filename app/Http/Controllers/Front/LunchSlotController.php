<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class LunchSlotController extends Controller
{

    public function claim(Request $request): RedirectResponse
    {
        $date      = \Illuminate\Support\Facades\Date::today()->toDateString();
        $lunchslot = LunchSlot::findOrFail($request->id);

        if ((! auth()->user()->available) || $lunchslot->available_today >= 1) {
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
