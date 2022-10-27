<?php

namespace MagedAhmad\Insular\Jobs;

use Illuminate\Http\JsonResponse;
use MagedAhmad\Insular\Types\ErrorResponsePayload;

class RespondErrorJsonJob
{
    public function __construct(
        private ErrorResponsePayload $error
    ) {}

    public function do(): JsonResponse
    {
        return response()->json(
            data: $this->error->toArray(),
            status: $this->error->status
        );
    }
}
