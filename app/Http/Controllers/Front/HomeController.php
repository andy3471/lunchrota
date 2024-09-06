<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $initialSlot = null;
        // TODO: Refactor this
        if (auth()->check()) {
            $initialSlot = DB::table('users')
                ->select('lunch_slots.id')
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', Carbon::today()->toDateString())
                ->where('users.id', auth()->user()->id)
                ->orderBy('users.name')
                ->first();
        }

        return Inertia::render('HomePage', [
            'lunchSlots' => fn () => LunchSlot::orderBy('time')->get(),
            'initialSlot' => $initialSlot?->id ?: -1,
            'available' => fn () => auth()->user()?->available ?: true,
        ]);
    }
}
