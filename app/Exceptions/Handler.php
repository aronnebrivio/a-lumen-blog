<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Throwable $e
     *
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        // Ignoring this block because only applies on production environment
        // @codeCoverageIgnoreStart
        if (app()->environment() === 'production' && app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }
        // @codeCoverageIgnoreEnd

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $e
     *
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response($e->validator->messages()->messages(), 422);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return response('Method Not Allowed.', 405);
        }
        if ($e instanceof ModelNotFoundException) {
            return response('The resource you are looking for is not available or does not belong to you.', 404);
        }
        if ($e instanceof AuthorizationException) {
            return response($e->getMessage(), 401);
        }

        // Ignoring this block because only applies if an error is not handled (like 500 server errors)
        // @codeCoverageIgnoreStart
        return response($e->getMessage(), $e->getCode() > 0 ? $e->getCode() : 500);
        // @codeCoverageIgnoreEnd
    }
}
