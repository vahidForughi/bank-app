<?php

namespace App\Repositories\User;

use App\DTO\User\UserDTO;
use App\DTO\User\UserUpdateDTO;

interface UserRepositoryInterface
{
    public function fetchList(array $with = []): array;
    public function fetchById(string $id, array $with = []): UserDTO;
    public function store(UserDTO $accountDTO): UserDTO;
    public function update(string $id, UserUpdateDTO $accountDTO): void;
    public function delete(string $id): void;
    public function exists(string $id): bool;
}
