<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'admin':
                if (Auth::guard('admin')->check()) {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                break;

            default:
                if (Auth::check()) {
                    if (Auth::user()->email_verified_at === null) {
                        /**
                         * si el usuario no ha verificado su email se carga la variable de sesion
                         */
                        session(['verify_email' => __('Please check your email to complete registration')]);
                    }

                    return redirect(RouteServiceProvider::HOME);
                }
                break;
        }

        return $next($request);
    }
}
