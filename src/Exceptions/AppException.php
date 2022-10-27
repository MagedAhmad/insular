<?php

namespace MagedAhmad\Insular\Exceptions;

use Exception;
use function trans;
use Illuminate\Http\JsonResponse;

class AppException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(data: [
            'message' => trans(key: $this->getMessage())
        ], status: 400);
    }
}
