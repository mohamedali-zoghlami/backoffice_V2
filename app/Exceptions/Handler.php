<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\ConnectionException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ConnectionException) {
            return response()->view('errors.500', [], 500);
        }
        if ($exception instanceof QueryException && ($exception->getCode()===2002||$exception->getCode()===2006) ) {
            if(Auth::check())
            return response()->view('errors.500', [], 500);
            else
            return response()->view("errors.auth-500");
        }
        if ($exception instanceof AuthenticationException) {
            return parent::render($request, $exception);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }
        if ($exception instanceof \Exception) {
            if(Auth::check())
            return response()->view('errors.500', [], 500);
            else
                return response()->view("errors.auth-500");
            }
        return parent::render($request, $exception);
    }
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

}
