<?php

namespace MagedAhmad\Insular\Types;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Size;
use Spatie\LaravelData\Attributes\Validation\Nullable;

class OkResponsePayload extends Data
{
    const DEFAULT_STATUS_CODE = 200;

    public function __construct(
        public ?MessageType $message = null,
        
        #[Size(3)]
        public ?int $status = self::DEFAULT_STATUS_CODE,
        
        #[Nullable]
        public $data = null,
        
        public ?array $filters = [],

        public ?MetaType $meta = null,

        public $ranges = null,

        public $range = null,
    ) {}
}
