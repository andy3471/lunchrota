<?php

namespace App\Providers;

use App\DailyPassword;
use App\AppDelSupportDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

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
                ->where('users.app_del', true)
                ->get();
            });

            $versionAlert = Cache::remember('versionalert', 600, function () {
                $version = config('app.version');
                $url = 'https://andyh.app/lunchrota/alert/' . $version;
                $response = Http::get($url);
                
                if ($response->ok()) {
                    return $response->body();
                } else{ 
                    return null;
                }
            });

            $view->with('dsp', $dsp)->with('ads', $appDelSupport)->with('versionalert', $versionAlert);
        });
    }
}
