<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            $status = Response::HTTP_BAD_REQUEST;
            $error = 'HTTP_BAD_REQUEST';
            $message = $e->getMessage();
            $trace = (config('app.env') != 'production') ? $e->getTrace() : null;

            if($e instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $error = 'HTTP_NOT_FOUND';
            }

            if($e instanceof ValidationException) {
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                $error = 'HTTP_UNPROCESSABLE_ENTITY';
                $message = $e->errors();
            }
            return response()->jsonError(
                error: $error,
                message: $message,
                status: $status,
                trace: $trace,
            );
        }

        return parent::render($request, $e);
    }

    public function report(Throwable $e)
    {
        if($e instanceof NotFoundHttpException) {
            Log::info('NotFoundHttpException: '.$e->getMessage());
        }

        parent::report($e);
    }
}
