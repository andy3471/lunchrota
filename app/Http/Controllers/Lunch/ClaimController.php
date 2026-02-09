<?php

declare(strict_types=1);

namespace App\Http\Controllers\Lunch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lunch\StoreLunchSlotClaimRequest;
use App\Models\LunchSlot;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Date;

class ClaimController extends Controller
{
    public function store(StoreLunchSlotClaimRequest $request): RedirectResponse
    {
        $this->authorize('create', LunchSlot::class);

        /** @var Team $team */
        $team = app('currentTeam');

        $date      = Date::today()->toDateString();
        $lunchslot = $team->lunchSlots()->findOrFail($request->validated('id'));

        if ((! auth()->user()->available_today) || $lunchslot->available_today >= 1) {
            auth()->user()->lunches()->detach();
            auth()->user()->lunches()->attach($request->validated('id'), ['date' => $date]);

            return redirect()->route('home');
        }

        return redirect()->route('home')->with('error', 'This lunch slot has been claimed by another user');
    }

    public function destroy(): RedirectResponse
    {
        $this->authorize('delete', LunchSlot::class);

        auth()->user()->lunches()->detach();

        return redirect()->route('home');
    }
}
