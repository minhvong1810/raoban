<?php

namespace App\Http\Middleware;

use Closure;

class IpCheckMiddleware
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
        //server bluesea
        if ($request->ip() != "123.30.211.24") {

            abort(404);
        }

        return $next($request);
    }
}
