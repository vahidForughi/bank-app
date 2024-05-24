<?php

namespace App\Repositories\Account;

use App\DTO\Account\AccountDTO;
use App\DTO\Account\AccountUpdateDTO;
use App\Models\Account;
use App\Repositories\Account\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    public function fetchList(array $with = []): array
    {
        return Account::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): AccountDTO
    {
        return Account::with($with)->find($id)->toDTO();
    }

    public function store(AccountDTO $accountDTO): AccountDTO
    {
        return Account::create([
            'user_id' => $accountDTO->userID,
            'number' => $accountDTO->number,
            'cash' => $accountDTO->cash,
        ])->toDTO();
    }

    public function update(string $id, AccountUpdateDTO $accountDTO): void
    {
        $account = new Account;

        if ($accountDTO->userID)
            $account->user_id = $accountDTO->userID;

        if ($accountDTO->number)
            $account->number = $accountDTO->number;

        if ($accountDTO->cash)
            $account->cash = $accountDTO->cash;

        Account::where('id', $id)->update($account->toArray());
    }

    public function delete(string $id): void
    {
        Account::find($id)->delete();
    }

    public function exists(string $id): bool
    {
        return Account::where('id', $id)->exists();
    }
}
