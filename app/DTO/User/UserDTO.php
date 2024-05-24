<?php

namespace App\DTO\User;

readonly class UserDTO
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $phone_number,
        public string|null $id = null,
    ) {}
}
