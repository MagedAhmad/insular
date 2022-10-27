<?php

namespace MagedAhmad\Insular\Jobs;

use Illuminate\Http\JsonResponse;
use MagedAhmad\Insular\Types\OkResponsePayload;

class RespondOkJsonJob
{
    public function __construct(private OkResponsePayload $payload) {}
    
    public function do(): JsonResponse
    {
        return response()->json(data: $this->payload->toArray());
    }
}
