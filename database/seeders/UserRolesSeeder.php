<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Team;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $team  = Team::where('slug', 'demo')->firstOrFail();
        $roles = $team->roles;

        $startDate = Carbon::now()->addMonth(-1);
        $endDate   = Carbon::now()->addMonth(1);
        $dateRange = CarbonPeriod::create($startDate, $endDate);

        foreach ($dateRange as $date) {
            if ($date->isWeekday()) {
                $dateString = Carbon::parse($date)->toDateString();

                foreach ($team->members as $user) {
                    $role = $roles->random();
                    $user->roles()->attach($role, ['date' => $dateString]);
                }
            }
        }
    }
}
