<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::now()->addMonth(-1);
        $endDate = Carbon::now()->addMonth(1);
        $dateRange = CarbonPeriod::create($startDate, $endDate);

        foreach ($dateRange as $date) {
            if ($date->isWeekday()) {
                $dateString = Carbon::parse($date)->toDateString();

                $users = User::all();

                foreach ($users as $user) {
                    $role = Role::all()->random()->id;
                    $user->roles()->attach($role, ['date' => $dateString]);
                }
            }
        }
    }
}
