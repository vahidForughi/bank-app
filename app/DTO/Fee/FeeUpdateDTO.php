<?php

namespace App\DTO\Fee;

readonly class FeeUpdateDTO
{
    public function __construct(
        public string|null $transactionID = null,
        public string|null $cash = null,
    ) {}
}
