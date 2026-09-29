<?php

namespace App\Exceptions;

use App\Support\ErrorDiagnostics;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ViewErrorBag;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Reference shown on the error page and written to the log, e.g. ERR-7F3A9C.
     *
     * @var string|null
     */
    private $reference;

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

    public function reference()
    {
        return $this->reference ?? ($this->reference = 'ERR-' . strtoupper(bin2hex(random_bytes(3))));
    }

    /**
     * Log context: the reference, so an error reported by a visitor can be found in the log.
     */
    protected function context()
    {
        return array_merge(['reference' => $this->reference()], parent::context());
    }

    /**
     * Unexpected errors: the shop's 500 page with a reference, plus the exception details
     * for admins. Everyone else never sees technical details, and APP_DEBUG stays off.
     */
    protected function prepareResponse($request, Throwable $e)
    {
        if ($this->isHttpException($e) || config('app.debug')) {
            return parent::prepareResponse($request, $e);
        }

        try {
            return response()->view('errors.500', [
                'errors' => new ViewErrorBag,
                'exception' => new HttpException(500),
                'reference' => $this->reference(),
                'diagnostics' => $this->showsDiagnostics($request) ? ErrorDiagnostics::from($e, $request, $this->reference()) : null,
            ], 500)->header('Cache-Control', 'no-store, private');
        } catch (Throwable $renderError) {
            return $this->plainErrorPage($renderError);
        }
    }

    /**
     * HTTP errors (404, 403, 419, …); if the page itself fails, e.g. with the database down,
     * fall back to a plain page instead of failing again.
     */
    protected function renderHttpException(HttpExceptionInterface $e)
    {
        try {
            return parent::renderHttpException($e);
        } catch (Throwable $renderError) {
            return $this->plainErrorPage($renderError, $e);
        }
    }

    /**
     * errors/{status}, or errors/4xx / errors/5xx for statuses without their own page.
     */
    protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
        $view = 'errors::' . $e->getStatusCode();

        return view()->exists($view) ? $view : 'errors::' . ($e->getStatusCode() >= 500 ? '5xx' : '4xx');
    }

    /**
     * JSON errors (search suggestions, catalog updates) carry the reference too.
     */
    protected function convertExceptionToArray(Throwable $e)
    {
        return parent::convertExceptionToArray($e) + ($this->isHttpException($e) ? [] : ['reference' => $this->reference()]);
    }

    private function showsDiagnostics($request)
    {
        try {
            $user = $request->user();

            return $user !== null && Gate::forUser($user)->allows('isAdmin');
        } catch (Throwable $e) {
            return false;
        }
    }

    private function plainErrorPage(Throwable $renderError, ?HttpExceptionInterface $e = null)
    {
        try {
            logger()->error('The error page could not be rendered: ' . $renderError->getMessage(), [
                'reference' => $this->reference(),
                'exception' => $renderError,
            ]);
        } catch (Throwable $ignored) {
            //
        }

        return $this->convertExceptionToResponse($e ?? new HttpException(500));
    }
}
