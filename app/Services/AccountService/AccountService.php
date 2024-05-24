<?php

namespace App\Services\AccountService;

use App\DTO\Account\AccountUpdateDTO;
use App\DTO\Fee\FeeDTO;
use App\DTO\Account\AccountDTO;
use App\Models\Account;
use App\Exceptions\PreConditionFailedException;
use App\Models\User;
use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\Card\CardRepository;
use App\Repositories\Card\CardRepositoryInterface;
use App\Repositories\Fee\FeeRepositoryInterface;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
    ) {}

    public function fetchList(

    ): array
    {
        return $this->accountRepository->fetchList([
            'user',
            'cards',
        ]);
    }

    public function fetch(
        string $id,
    ): AccountDTO
    {
        if (empty($accountDTO = $this->accountRepository->fetchById($id, [
            'user',
            'cards',
        ]))) {
            throw new NotFoundHttpException('account not found');
        }

        return $accountDTO;
    }

    public function store(
        AccountDTO $accountDTO,
    ): AccountDTO
    {
        if (empty(resolve(UserService::class)->exists($accountDTO->userID))) {
            throw new NotFoundHttpException('user not found');
        }

        return $this->accountRepository->store($accountDTO);
    }

    public function update(
        string $accountID,
        AccountUpdateDTO $accountDTO,
    ): void
    {
        if (empty($this->accountRepository->exists($accountID))) {
            throw new NotFoundHttpException('account not found');
        }

        $this->accountRepository->update(
            $accountID,
            $accountDTO,
        );
    }

    public function delete(
        string $accountID,
    ): void
    {
        if (empty($this->accountRepository->exists($accountID))) {
            throw new NotFoundHttpException('account not found');
        }

        $this->accountRepository->delete(
            $accountID,
        );
    }

    public function exists(
        string $id,
    ): bool
    {
        return $this->accountRepository->exists($id);
    }
}
