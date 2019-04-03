<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(($request->user() and $request->user()->hasRole($role)) or ($request->user() and $request->user()->isAdmin())) {
            return $next($request);
        }
        return abort(404);
    }
}
