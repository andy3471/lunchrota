<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('web')
            // TODO
//            ->middleware('api')
            ->name('api.')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
