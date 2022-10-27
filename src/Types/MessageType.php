<?php 

namespace MagedAhmad\Insular\Types;

use Spatie\LaravelData\Data;

class MessageType extends Data
{
    public function __construct(
        public string $message,
        public string $type, 
        public ?string $caption = '', 
        public ?string $position = '', 
        public ?string $icon = '', 
        public ?int $timeout = 0, 
    ) {}
}
