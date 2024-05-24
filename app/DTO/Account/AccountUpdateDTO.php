<?php

namespace App\DTO\Account;

use App\DTO\User\UserDTO;

readonly class AccountUpdateDTO
{
    public function __construct(
        public string|null $userID = null,
        public string|null $number = null,
        public string|null $cash = null,
        public UserDTO|null $user = null,
    ) {}
}
