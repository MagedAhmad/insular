<?php

namespace MagedAhmad\Insular\Types;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\Validation\ArrayType;

class ErrorResponsePayload extends Data
{
    public function __construct(
        #[Min(3)]
        public MessageType $message,
        #[Size(3)]
        public int $status,
        #[ArrayType]
        public ?array $data = []
    ) {}
}
