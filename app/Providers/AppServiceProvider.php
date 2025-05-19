<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    public function register()
    {
        Model::preventLazyLoading(app()->isLocal());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        $this->bootAuth();
    }

    public function bootAuth()
    {

        Gate::define('admin', function ($user) {
            return $user->admin;
        });
    }
}
