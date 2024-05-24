<?php

namespace App\DTO\Account;

use App\DTO\User\UserDTO;

readonly class AccountDTO
{
    public function __construct(
        public string $userID,
        public string $number,
        public string $cash,
        public string|null $id = null,
        public UserDTO|null $user = null,
    ) {}
}
