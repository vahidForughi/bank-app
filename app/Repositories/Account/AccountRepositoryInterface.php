<?php

namespace App\Repositories\Account;

use App\DTO\Account\AccountDTO;
use App\DTO\Account\AccountUpdateDTO;

interface AccountRepositoryInterface
{
    public function fetchList(array $with = []): array;
    public function fetchById(string $id, array $with = []): AccountDTO;
    public function store(AccountDTO $accountDTO): AccountDTO;
    public function update(string $id, AccountUpdateDTO $accountDTO): void;
    public function delete(string $id): void;
    public function exists(string $id): bool;
}
