<?php

namespace App\DTO\User;

use Illuminate\Support\Optional;

readonly class UserUpdateDTO
{
    public function __construct(
        public string|null $first_name = null,
        public string|null $last_name = null,
        public string|null $phone_number = null,
    ) {}
}
