<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnabledUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        /**
         * si el usuario esta inhabilitado lo redirecciona a la vista correspondiente
         */
        if ($request->user() && ! $request->user()->is_active) {
            return  redirect('/disabled-user');
        }

        return $next($request);
    }
}
