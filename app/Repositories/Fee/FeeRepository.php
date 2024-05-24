<?php

namespace App\Repositories\Fee;

use App\DTO\Fee\FeeDTO;
use App\DTO\Fee\FeeUpdateDTO;
use App\Models\Fee;
use App\Repositories\Fee\FeeRepositoryInterface;

class FeeRepository implements FeeRepositoryInterface
{
    public function fetchList(array $with = []): array
    {
        return Fee::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): FeeDTO
    {
        return Fee::with($with)->find($id)->toDTO();
    }

    public function store(FeeDTO $feeDTO): FeeDTO
    {
        return Fee::create([
            'transaction_id' => $feeDTO->transactionID,
            'cash' => $feeDTO->cash,
        ])->toDTO();
    }

    public function update(string $id, FeeUpdateDTO $feeDTO): void
    {
        $fee = new Fee();

        if ($feeDTO->transactionID)
            $fee->transaction_id = $feeDTO->transactionID;

        if ($feeDTO->cash)
            $fee->cash = $feeDTO->cash;
        Fee::where('id', $id)->update($fee->toArray());
    }

    public function delete(string $id): void
    {
        Fee::find($id)->delete();
    }

    public function exists(string $id): bool
    {
        return Fee::where('id', $id)->exists();
    }
}
