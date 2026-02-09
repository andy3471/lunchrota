<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenantFromSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host   = $request->getHost();
        $domain = config('app.domain');

        // Extract subdomain from host
        $subdomain = str_replace('.'.$domain, '', $host);

        if (! $subdomain || $subdomain === $host) {
            abort(404);
        }

        $team = Team::where('slug', $subdomain)->first();

        if (! $team) {
            abort(404);
        }

        // Bind the team to the container so controllers can access it
        app()->instance('currentTeam', $team);
        $request->merge(['tenant' => $team]);

        // Share with views
        view()->share('currentTeam', $team);

        return $next($request);
    }
}
