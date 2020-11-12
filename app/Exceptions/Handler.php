<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson() && strpos($request->path(), 'api') !== false) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => 'Product not found',
                        'code'    => 404
                    ]
                ], 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => 'Route not found',
                        'code'    => 404
                    ]
                ], 404);
            }

            if ($exception instanceof UnauthorizedException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => 'User is authenticated',
                        'code'    => 401
                    ]
                ], 401);
            }
        }
        return parent::render($request, $exception);
    }
}
