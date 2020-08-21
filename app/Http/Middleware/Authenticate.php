<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            switch ($request->path()) {
                case 'admin':
                    return route('admin.login');
                    break;

                default:
                    return route('login');
                    break;
            }
        }
        return route('login');
    }
}
