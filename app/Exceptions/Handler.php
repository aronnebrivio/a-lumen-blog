<?php

namespace App\Exceptions;

use ErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use UnexpectedValueException;

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
     * @param Exception $e
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ValidationException)
            return response($e->validator->messages()->messages(), 422);

        if ($e instanceof MethodNotAllowedHttpException)
            return response('Method Not Allowed.', 405);

        if ($e instanceof UnexpectedValueException)
            return response('Unexpected value.', 422);

        if ($e instanceof ModelNotFoundException)
            return response('The resource you are looking for is not available or does not belong to you.', 404);

        if ($e instanceof ErrorException)
            return response('Unprocessable. Please provide all inputs and retry.', 422);

        return response($e->getMessage(), $e->getCode());
    }
}
