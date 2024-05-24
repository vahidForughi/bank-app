<?php

namespace App\DTO\Transaction;

use App\DTO\Card\CardDTO;

readonly class TransactionDTO
{
    public function __construct(
        public string $originCardID,
        public string $destinationCardID,
        public int $type,
        public string $cash,
        public int|null $status = null,
        public string|null $id = null,
        public CardDTO|null $originCard = null,
        public CardDTO|null $destinationCard = null,
    ) {}
}
