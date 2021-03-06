<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Role;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                };
            }
        }
    }
}
