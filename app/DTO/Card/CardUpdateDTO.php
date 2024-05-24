<?php

namespace App\DTO\Card;

use Illuminate\Support\Optional;

readonly class CardUpdateDTO
{
    public function __construct(
        public string|null $accountID = null,
        public string|null $number = null,
    ) {}
}
