<?php

namespace App\Console;

use App\Console\Commands\DemoModeRefresh;
use App\Console\Commands\RolesClear;
use App\Console\Commands\RolesGenerate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(DemoModeRefresh::class)
            ->daily();

        $schedule->command(RolesGenerate::class)
            ->daily();

        $schedule->command(RolesClear::class)
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
