<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnabledUser
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param null|string $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        /**
         * si el usuario esta inhabilitado lo redirecciona a la vista correspondiente
         */
        if ($request->user($guard) && ! $request->user($guard)->is_active) {
            return  redirect('/disabled-user');
        }

        return $next($request);
    }
}
