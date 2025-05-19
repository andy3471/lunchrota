<?php

use App\Console\Commands\DemoModeRefresh;
use App\Console\Commands\RolesClear;
use App\Console\Commands\RolesGenerate;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(DemoModeRefresh::class)
    ->daily();

Schedule::command(RolesGenerate::class)
    ->daily();

Schedule::command(RolesClear::class)
    ->daily();
