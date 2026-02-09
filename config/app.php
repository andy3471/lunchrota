<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Facade;

return [

    'domain' => env('APP_DOMAIN', 'localhost'),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
