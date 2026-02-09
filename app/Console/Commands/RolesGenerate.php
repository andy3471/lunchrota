<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Team;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RolesGenerate extends Command
{
    protected $signature = 'roles:generate';

    protected $description = 'Generate Roles';

    public function handle(): void
    {
        if (config('app.default_role') === 'none') {
            $this->line('No default role set');

            return;
        }

        $startDate = now();
        $endDate   = now()->addWeek();
        $dateRange = CarbonPeriod::create($startDate, $endDate);

        Team::all()->each(function (Team $team) use ($dateRange): void {
            $this->line("Processing team: {$team->name}");

            $defaultRole = $team->roles()->where('name', config('app.default_role'))->first();

            if (! $defaultRole) {
                $this->warn("No matching default role found for team: {$team->name}");

                return;
            }

            $this->line("The Default Role is {$defaultRole->name}");

            foreach ($dateRange as $date) {
                if ($date->isWeekday()) {
                    $this->line((string) $date);
                    $dateString = CarbonImmutable::parse($date)->toDateString();

                    $usersWithRoles = DB::table('role_user')
                        ->select('user_id')
                        ->where('date', $dateString)
                        ->get()
                        ->pluck('user_id')
                        ->toArray();

                    $users = $team->members()
                        ->whereNotIn('users.id', $usersWithRoles)
                        ->get();

                    foreach ($users as $user) {
                        if ($user->is_scheduled) {
                            $user->roles()->attach($defaultRole, ['date' => $dateString]);
                            $this->line("{$user->name} Given Role Of {$defaultRole->name} For {$dateString}");
                        } else {
                            $this->line("{$user->name} is not a scheduled user");
                        }
                    }
                } else {
                    $this->line("{$date} Is Weekend");
                }
            }
        });
    }
}
