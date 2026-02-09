<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Team;
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
        /** @var Team|null $currentTeam */
        $currentTeam = app()->bound('currentTeam') ? resolve('currentTeam') : null;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id'       => $request->user()->id,
                    'name'     => $request->user()->name,
                    'email'    => $request->user()->email,
                    'is_admin' => $request->user()->is_admin,
                ] : null,
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            'config' => [
                'appName'              => config('app.name', 'Rota'),
                'registerEnabled'      => $currentTeam?->register_enabled       ?? false,
                'resetPasswordEnabled' => $currentTeam?->reset_password_enabled ?? false,
                'rolesEnabled'         => $currentTeam?->roles_enabled          ?? false,
            ],
            'currentTeam' => $currentTeam ? [
                'id'   => $currentTeam->id,
                'name' => $currentTeam->name,
                'slug' => $currentTeam->slug,
            ] : null,
        ];
    }
}
