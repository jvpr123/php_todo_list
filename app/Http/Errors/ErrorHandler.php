<?php

namespace App\Http\Errors;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ErrorHandler
{
    static function handle(\Exception $error)
    {
        if ($error instanceof HttpException) {
            return response()->json([
                "message" => $error->getMessage()
            ], $error->getStatusCode());
        }

        return response()->json(["message" => $error->getMessage()], 500);
    }
}
