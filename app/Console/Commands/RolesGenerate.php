<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RolesGenerate extends Command
{
    protected $signature = 'roles:generate';

    protected $description = 'Generate Roles';

    // TODO: Tidy up the code in this file
    public function handle(): void
    {
        if (config('app.default_role') === 'none') {
            $this->line('No default role set');

            return;
        }

        $defaultRole = Role::where('name', config('app.default_role'))->first();
        $startDate   = now();
        $endDate     = now()->addWeek();
        $dateRange   = CarbonPeriod::create($startDate, $endDate);

        if ($defaultRole) {
            $this->line('The Default Role is '.$defaultRole->name);
        } else {
            $this->error('The default role in the .env file does not match the name of a role');

            return;
        }

        foreach ($dateRange as $date) {
            if ($date->isWeekday()) {
                $this->line($date);
                $dateString = CarbonImmutable::parse($date)->toDateString();

                $usersWithRoles = DB::table('role_user')
                    ->select('user_id')
                    ->where('date', $dateString)
                    ->get();

                $usersWithRoles = json_decode((string) json_encode($usersWithRoles), true);

                $users = User::whereNotIn('id', $usersWithRoles)->get();

                foreach ($users as $user) {
                    if ($user->scheduled) {
                        $user->roles()->attach($defaultRole, ['date' => $dateString]);
                        $this->line($user->name.' Given Role Of '.$defaultRole->name.' For '.$dateString);
                    } else {
                        $this->line($user->name.' is not a scheduled user');
                    }
                }
            } else {
                $this->line($date.' Is Weekend');
            }
        }

    }
}
