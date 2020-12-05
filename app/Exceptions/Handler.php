<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @throws Exception|Throwable
     * @return void
     *
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
     * @throws Throwable
     * @return Response
     *
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson() && strpos($request->path(), 'api') !== false) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => trans('messages.not_found', [
                            'resource' => trans_choice('products.product', 1, ['product_count' => ''])
                        ]),
                        'code'    => 404,
                    ],
                ], 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => trans('fields.route'),
                        'code'    => 404,
                    ],
                ], 404);
            }

            if ($exception instanceof UnauthorizedException) {
                return response()->json([
                    'status' => [
                        'status' => 'failed',
                        'message' => trans('http_errors.unauthenticated'),
                        'code'    => 401,
                    ],
                ], 401);
            }
        }

        return parent::render($request, $exception);
    }
}
