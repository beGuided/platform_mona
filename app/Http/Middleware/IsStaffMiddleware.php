<?php

namespace App\Http\Middleware;

use Closure;

class IsStaffMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->User()->role_id !='staff') {
            abort(403, 'Unauthorized Action');
        }

        return $next($request);
    }
}
