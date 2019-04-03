<?php

namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if(($request->user() and $request->user()->hasPerm($permission)) or ($request->user() and $request->user()->isAdmin())) {
            return $next($request);
        }
        return abort(404);
    }
}
