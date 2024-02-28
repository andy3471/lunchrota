<?php

namespace App\Providers;

use App\Models\DailyPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    // TODO: Tidy this mess up
    public function boot()
    {
        if (env('REDIRECT_HTTPS')) {
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
                    ->where('users.app_del', true)
                    ->get();
            });

            $view->with('dsp', $dsp)->with('ads', $appDelSupport);
        });
    }
}
