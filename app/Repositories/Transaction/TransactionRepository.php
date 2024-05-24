<?php

namespace App\Repositories\Transaction;

use App\DTO\Transaction\TransactionDTO;
use App\DTO\Transaction\TransactionUpdateDTO;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function fetchList(array $with = []): array
    {
        return Transaction::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): TransactionDTO
    {
        return Transaction::with($with)->find($id)->toDTO();
    }

    public function store(TransactionDTO $transactionDTO): TransactionDTO
    {
        return Transaction::create([
            "origin_card_id" => $transactionDTO->originCardID,
            "destination_card_id" => $transactionDTO->destinationCardID,
            "type" => $transactionDTO->type,
            "cash" => $transactionDTO->cash,
            "status" => $transactionDTO->status,
        ])->toDTO();
    }

    public function update(string $id, TransactionUpdateDTO $transactionDTO): void
    {
        $transaction = new Transaction;

        if ($transactionDTO->originCardID)
            $transaction->origin_card_id = $transactionDTO->originCardID;

        if ($transactionDTO->destinationCardID)
            $transaction->destination_card_id = $transactionDTO->destinationCardID;

        if ($transactionDTO->type)
            $transaction->type = $transactionDTO->type;

        if ($transactionDTO->cash)
            $transaction->cash = $transactionDTO->cash;

        if ($transactionDTO->status)
            $transaction->status = $transactionDTO->status;

        Transaction::where('id', $id)->update($transaction->toArray());
    }

    public function delete(string $id): void
    {
        Transaction::find($id)->delete();
    }

    public function exists(string $id): bool
    {
        return Transaction::where('id', $id)->exists();
    }
}
