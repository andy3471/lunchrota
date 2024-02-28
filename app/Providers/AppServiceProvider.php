<?php

namespace App\Providers;

use App\Models\DailyPassword;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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

            $versionAlert = Cache::remember('versionalert', 600, function () {
                $version = config('app.version');
                $url = 'https://andyh.app/lunchrota/alert/'.$version;

                $client = new Client(['http_errors' => false]);

                try {
                    $response = $client->get($url, ['verify' => false]);
                    $statuscode = $response->getStatusCode();
                    if ($statuscode === 200) {
                        return $response->getBody();
                    }
                } catch (ConnectException $e) {
                    return null;
                }

                return null;
            });

            $view->with('dsp', $dsp)->with('ads', $appDelSupport)->with('versionalert', $versionAlert);
        });
    }
}
