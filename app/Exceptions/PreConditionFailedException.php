<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PreConditionFailedException extends Exception
{
    public function render($message, Exception $e)
    {
        $trace = (config('app.env') != 'production') ? $e->getTrace() : null;

        return response()->jsonError(
            error: 'HTTP_PRECONDITION_FAILED',
            status: Response::HTTP_BAD_REQUEST,
            message: $message,
            trace: $trace,
        );
    }

    public function report(Exception $e)
    {
        Log::info('PreConditionFaildException: '.$e->getMessage());
    }
}
