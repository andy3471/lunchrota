<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\HomePageData;
use App\DataTransferObjects\LunchSlotData;
use App\DataTransferObjects\RoleData;
use App\DataTransferObjects\UserLunchData;
use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $date = $request->date('date') ?? Carbon::today();

        return Inertia::render('Home', HomePageData::from([
            'lunchSlots' => LunchSlotData::collectForDate(
                LunchSlot::orderBy('time')->get(),
                $date->toDateString()
            ),
            'initialSlot' => auth()->check()
                ? auth()->user()->lunchesForDate($date->toDateString())->first()?->id
                : null,
            'available'   => auth()->user()?->isAvailableForDate($date->toDateString()) ?? true,
            'userLunches' => UserLunchData::collect(
                User::query()
                    ->withLunchesForDate($date->toDateString())
                    ->get()
            ),
            'roles' => RoleData::collect(
                RoleUser::query()
                    ->forDate($date->toDateString())
                    ->with(['user', 'role'])
                    ->get()
            ),
            'selectedDate' => $date->toDateString(),
        ])->toArray());
    }
}
