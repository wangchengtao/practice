<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class APIResultData extends Data
{
    public function __construct(
        public string $code,
        public string $message,
        public mixed $data,
    ) {}
}
