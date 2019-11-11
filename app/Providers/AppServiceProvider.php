<?php

namespace App\Providers;

use App\DailyPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            $dsp = Cache::remember('dsp', 600, function () {
                $today = Carbon::now()->toDateString();
                return DailyPassword::where('date', $today)->get();
            });

            $view->with('dsp', $dsp);
        });
    }
}
