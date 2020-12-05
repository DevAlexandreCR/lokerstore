<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson() || strpos($request->path(), 'api/products') !== false) {
            abort(response()->json([
                'status' => [
                    'status' => trans('http_errors.unauthenticated'),
                    'reason' => trans(''),
                    'code'   => 401,
                ],
            ], 401));
        }

        if ($request->path() === 'admin') {
            return route('admin.login');
        }

        return route('login');
    }
}
