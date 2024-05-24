<?php

namespace App\DTO\Transaction;

use App\DTO\Card\CardDTO;

readonly class TransactionUpdateDTO
{
    public function __construct(
        public string|null $originCardID = null,
        public string|null $destinationCardID = null,
        public int|null $type = null,
        public string|null $cash = null,
        public int|null $status = null,
        public CardDTO|null $originCard = null,
        public CardDTO|null $destinationCard = null,
    ) {}
}
