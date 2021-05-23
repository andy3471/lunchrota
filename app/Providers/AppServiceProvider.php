<?php

namespace App\Providers;

use App\Models\DailyPassword;
use App\AppDelSupportDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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

//        view()->composer('*', function ($view) {
//            $versionAlert = Cache::remember('versionalert', 600, function () {
//                $version = config('app.version');
//                $url = 'https://andyh.app/lunchrota/alert/' . $version;
//
//                $client = new Client(['http_errors' => false]);
//
//                $response = $client->get($url, ['verify' => false]);
//                $statuscode = $response->getStatusCode();
//
//                if ($statuscode === 200) {
//                    return $response->getBody();
//                } else {
//                    return null;
//                }
//            });
//
//            $view->with('versionalert', $versionAlert);
//        });
    }
}
