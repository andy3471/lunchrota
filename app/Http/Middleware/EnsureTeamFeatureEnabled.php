<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamFeatureEnabled
{
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $team = app()->bound('currentTeam') ? resolve('currentTeam') : null;

        abort_if(! $team || ! $team->{$feature}, 404);

        return $next($request);
    }
}
