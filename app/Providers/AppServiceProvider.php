<?php

namespace App\Providers;

use App\DailyPassword;
use App\AppDelSupportDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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
        if(env('REDIRECT_HTTPS')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        
        view()->composer('*', function ($view) {
            $dsp = Cache::remember('dsp', 600, function () {
                $today = Carbon::now()->toDateString();
                return DailyPassword::where('date', $today)->get();
            });

            $appDelSupport = Cache::remember('appdelsupport', 600, function () {
                $today = Carbon::now()->toDateString();
                return DB::table('users')
                ->select('users.name')
                ->join('app_del_support_days', 'users.id', '=', 'app_del_support_days.user_id')
                ->where('app_del_support_days.date', $today)
                ->get();
            });

            $view->with('dsp', $dsp)->with('ads', $appDelSupport);
        });
    }
}
