<?php

namespace App\DTO\Fee;

readonly class FeeDTO
{
    public function __construct(
        public string $transactionID,
        public string $cash,
        public string|null $id = null,
    ) {}
}
