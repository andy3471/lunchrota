<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\RolesGenerate;
use App\Console\Commands\RolesClear;
use App\Console\Commands\DemoModeRefresh;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command(DemoModeRefresh::class)
    ->daily();

Schedule::command(RolesGenerate::class)
    ->daily();

Schedule::command(RolesClear::class)
    ->daily();
