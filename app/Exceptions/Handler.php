<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('auth.login'));
            }
        }

        // Send the response in json for ajax requests.
        if ($request->ajax()) {
            $error = $exception->getMessage() . ' on ' . $exception->getLine() . ' of ' . $exception->getFile();
            logger()->error($exception);

            return response()->json(['error' => $error], 500);
        }

        // If it is a redirect exception, handle the redirect.
        if ($exception instanceof RedirectionExceptionInterface) {
            return redirect($exception->getUrl())->with('error', $exception->getMessage());
        }

        // Is in debug mode, show the full whoops page.
        if (config('app.debug')) {
            return parent::convertExceptionToResponse($exception);
        }

        // Try to send the error to a custom view page.
        $code = $exception->getCode();
        if (view()->exists("errors.{$code}")) {
            return response()->view("errors.{$code}", [], $code);
        }

        // If its an HTTP exception it will have a status code.
        //  Use that status code to render a custom view.
        if ($this->isHttpException($exception)) {
            $code = $exception->getStatusCode();
            if (view()->exists("errors.{$code}")) {
                return response()->view("errors.{$code}", [], $code);
            }

            return $this->renderHttpException($exception);
        }

        // Render it with the default laravel settings.
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('auth.login');
    }
}
