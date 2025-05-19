<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'version' => '4.0.0',

    'register_enabled' => env('APP_REGISTER_ENABLED', true),

    'reset_password_enabled' => env('APP_RESET_PASSWORD_ENABLED', false),

    'roles_enabled' => env('APP_ROLES_ENABLED', true),

    'lunch_slot_calculated' => env('LUNCH_SLOT_CALCLULATED', false),

    'lunch_slot_calculated_ratio' => env('LUNCH_SLOT_CALCULATED_RATIO', '0.33'),

    'demo_mode' => env('APP_DEMO_MODE', false),

    'default_role' => env('APP_DEFAULT_ROLE', 'none'),

    'footer_text' => env('APP_FOOTER_TEXT', ''),

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Laravel Framework Service Providers...
         */

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\Filament\AdminPanelProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
