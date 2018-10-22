<?php

namespace App\Exceptions;

use App\Logging\Logger;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Session;
use Symfony\Component\HttpKernel\Exception\HttpException as KernelHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
        KernelHttpException::class,
        RedirectException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof KernelHttpException && $exception->getStatusCode() == 403) {
            Logger::logNotice('#AccessDenied', ['exception' => $exception]);
        } elseif ($exception instanceof TokenMismatchException) {
            Logger::logNotice('#TokenExpired', ['exception' => $exception]);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            Logger::logNotice('#MethodNotAllowed', ['exception' => $exception]);
        } elseif ($exception instanceof KernelHttpException && $exception->getStatusCode() == 404) {
            return;
        } elseif ($exception instanceof KernelHttpException && $exception->getStatusCode() == 503) {
            return;
        } elseif ($exception instanceof RedirectException) {
            return;
        } elseif ($exception instanceof ValidationException) {
            Logger::logLogicError($exception->errors());
        } else {
            Logger::logError($exception->getMessage(), ['exception' => $exception]);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Exception                $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
        }
        if ($exception instanceof RedirectException) {
            if ($exception->getErrorMessage()) {
                Session::flash('errors', (new ViewErrorBag())->put('default', new MessageBag([$exception->getErrorMessage()])));
            }

            return redirect()->to($exception->getUrl());
        }
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->except('password'))->withErrors(['Validation Token was expired. Please try again']);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
