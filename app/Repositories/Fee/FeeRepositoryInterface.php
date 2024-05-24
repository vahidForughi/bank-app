<?php

namespace App\Repositories\Fee;

use App\DTO\Fee\FeeDTO;
use App\DTO\Fee\FeeUpdateDTO;

interface FeeRepositoryInterface
{
    public function fetchList(array $with = []): array;
    public function fetchById(string $id, array $with = []): FeeDTO;
    public function store(FeeDTO $feeDTO): FeeDTO;
    public function update(string $id, FeeUpdateDTO $feeDTO): void;
    public function delete(string $id): void;
    public function exists(string $id): bool;
}
