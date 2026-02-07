<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /** @var string */
    protected $rootView = 'app';

    /** Determine the current asset version. */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id'       => $request->user()->id,
                    'name'     => $request->user()->name,
                    'email'    => $request->user()->email,
                    'is_admin' => $request->user()->can('admin', $request->user()),
                ] : null,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'config' => [
                'appName'              => config('app.name', 'Rota'),
                'demoMode'             => config('app.demo_mode', false),
                'registerEnabled'      => config('app.register_enabled', true),
                'resetPasswordEnabled' => config('app.reset_password_enabled', true),
                'rolesEnabled'         => config('app.roles_enabled', false),
            ],
        ];
    }
}
