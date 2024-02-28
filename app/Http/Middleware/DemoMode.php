<?php

namespace App\Http\Middleware;

use Closure;

class DemoMode
{
    public function handle($request, Closure $next)
    {
        if (config('app.demo_mode') == true) {
            return redirect('demo');
        }

        return $next($request);
    }
}
