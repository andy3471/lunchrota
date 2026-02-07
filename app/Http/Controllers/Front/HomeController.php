<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\DataTransferObjects\HomePageData;
use App\DataTransferObjects\LunchSlotData;
use App\DataTransferObjects\RoleData;
use App\DataTransferObjects\UserLunchData;
use App\Http\Controllers\Controller;
use App\Models\LunchSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $lunchslots  = LunchSlot::orderBy('time')->get();
        $date        = $request->input('date') ?? \Illuminate\Support\Facades\Date::today()->toDateString();
        $date        = \Illuminate\Support\Facades\Date::parse($date)->toDateString();
        $initialSlot = null;
        $userLunches = collect();

        // Get roles for the date (visible to everyone)
        $roles = DB::table('users')
            ->select('users.name', 'roles.name as role', 'roles.available')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('role_user.date', $date)
            ->oldest('users.name')
            ->get();

        if (auth()->check()) {
            $slotResult = DB::table('users')
                ->select('lunch_slots.id')
                ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                ->where('lunch_slot_user.date', $date)
                ->where('users.id', Auth::user()->id)
                ->orderBy('users.name')
                ->first();

            $initialSlot = $slotResult?->id;

            // Get today's user lunches
            if (config('database.default') === 'sqlsrv') {
                $userLunches = DB::table('users')
                    ->select('users.id', 'users.name', DB::RAW("FORMAT(CAST(lunch_slots.time as datetime2), N'HH:mm') as time"))
                    ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                    ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                    ->where('lunch_slot_user.date', $date)
                    ->oldest('time')
                    ->get();
            } else {
                $userLunches = DB::table('users')
                    ->select('users.id', 'users.name', 'lunch_slots.time')
                    ->join('lunch_slot_user', 'users.id', '=', 'lunch_slot_user.user_id')
                    ->join('lunch_slots', 'lunch_slots.id', '=', 'lunch_slot_user.lunch_slot_id')
                    ->where('lunch_slot_user.date', $date)
                    ->oldest('users.name')
                    ->get();
            }
        }

        $available = auth()->user()?->available ?? true;

        $lunchSlotData = $lunchslots->map(fn ($slot) => LunchSlotData::from([
            'id'              => $slot->id,
            'time'            => $slot->time,
            'available_slots' => $slot->getAvailableForDate($date),
        ]))->toArray();

        $userLunchData = $userLunches->map(fn ($lunch) => UserLunchData::from([
            'id'   => $lunch->id,
            'name' => $lunch->name,
            'time' => $lunch->time,
        ]))->toArray();

        $roleData = $roles->map(fn ($role) => RoleData::from([
            'name'      => $role->name,
            'role'      => $role->role,
            'available' => $role->available,
        ]))->toArray();

        $pageData = HomePageData::from([
            'lunchSlots'   => $lunchSlotData,
            'initialSlot'  => $initialSlot,
            'available'    => (bool) $available,
            'userLunches'  => $userLunchData,
            'roles'        => $roleData,
            'selectedDate' => $date,
        ]);

        return Inertia::render('Home', $pageData->toArray());
    }
}
