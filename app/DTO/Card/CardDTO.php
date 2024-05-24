<?php

namespace App\DTO\Card;

use App\DTO\Account\AccountDTO;

readonly class CardDTO
{
    public function __construct(
        public string $accountID,
        public string $number,
        public string|null $id = null,
        public AccountDTO|null $account = null,
    ) {}
}
