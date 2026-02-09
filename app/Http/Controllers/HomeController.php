<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\DataTransferObjects\HomePageData;
use App\DataTransferObjects\LunchSlotData;
use App\DataTransferObjects\RoleData;
use App\DataTransferObjects\UserLunchData;
use App\Models\RoleUser;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        /** @var Team $team */
        $team = app('currentTeam');
        $date = $request->date('date') ?? Carbon::today();

        return Inertia::render('Home', HomePageData::from([
            'lunchSlots' => LunchSlotData::collectForDate(
                $team->lunchSlots()->orderBy('time')->get(),
                $date->toDateString()
            ),
            'initialSlot' => auth()->check()
                ? auth()->user()->lunchesForDate($date->toDateString())->first()?->id
                : null,
            'available'   => auth()->user()?->isAvailableForDate($date->toDateString()) ?? true,
            'userLunches' => UserLunchData::collect(
                User::query()
                    ->whereHas('teams', fn ($q) => $q->where('teams.id', $team->id))
                    ->withLunchesForDate($date->toDateString())
                    ->get()
            ),
            'roles' => RoleData::collect(
                RoleUser::query()
                    ->forDate($date->toDateString())
                    ->whereHas('role', fn ($q) => $q->where('team_id', $team->id))
                    ->with(['user', 'role'])
                    ->get()
            ),
            'selectedDate' => $date->toDateString(),
        ])->toArray());
    }
}
