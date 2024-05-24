<?php

namespace App\Repositories\Transaction;

use App\DTO\Transaction\TransactionDTO;
use App\DTO\Transaction\TransactionUpdateDTO;

interface TransactionRepositoryInterface
{
    public function fetchList(array $with = []): array;
    public function fetchById(string $id, array $with = []): TransactionDTO;
    public function store(TransactionDTO $transactionDTO): TransactionDTO;
    public function update(string $id, TransactionUpdateDTO $transactionDTO): void;
    public function delete(string $id): void;
    public function exists(string $id): bool;
}
