<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyUserCan
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route()->parameter('user');
        $order = $request->route()->parameter('order');

        if ($user->id === auth()->id()) {
            if ($order && $order->user_id !== $user->id) {
                abort(403);
            }

            return $next($request);
        }

        abort(403);
    }
}
