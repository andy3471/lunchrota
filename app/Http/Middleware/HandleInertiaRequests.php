<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        'email' => $request->user()->email,
                        'name' => $request->user()->name,
                        'admin' => $request->user()->admin,
                    ] : null,
                ];
            },
            'auth.logged_in'                => Auth::check(),
            'config.name'                   => config('app.name'),
            'config.roles_enabled'          => config('app.roles_enabled'),
            'config.register_enabled'       => config('app.register_enabled'),
            'config.app_del_enabled'        => config('app.app_del_enabled'),
            'config.accent_color'           => config('app.accent_color'),
            'config.lunch_slot_calculated'  => config('app.lunch_slot_calculated'),
            'config.version'                => config('app.version'),
            'flash' => function () use ($request) {
                return [
                    'messages'  =>  $request->session()->get('message'),
                ];
            },
//            'appdels.today'                 => AppDelSupportDay::appDelToday()
//            'dsp.today'                     => DailyPassword::dspToday()
        ]);
    }
}
