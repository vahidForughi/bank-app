<?php

namespace App\Services\Card;

use App\DTO\Card\CardUpdateDTO;
use App\DTO\Card\CardDTO;
use App\Models\Card;
use App\Repositories\Card\CardRepositoryInterface;
use App\Services\AccountService\AccountService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CardService
{
    public function __construct(
        private CardRepositoryInterface $cardRepository,
    ) {}

    public function fetchList(

    ): array
    {
        return $this->cardRepository->fetchList([
            'account',
        ]);
    }

    public function fetch(
        string $id,
    ): CardDTO
    {
        if (empty($cardDTO = $this->cardRepository->fetchById($id, [
            'account',
        ]))) {
            throw new NotFoundHttpException('card not found');
        }

        return $cardDTO;
    }

    public function fetchByCardNumber(
        string $id,
    ): CardDTO
    {
        if (empty($cardDTO = $this->cardRepository->fetchByCardNumber($id, [
            'account',
        ]))) {
            throw new NotFoundHttpException('card not found');
        }

        return $cardDTO;
    }

    public function store(
        CardDTO $cardDTO,
    ): CardDTO
    {
        if (empty(resolve(AccountService::class)->exists($cardDTO->accountID))) {
            throw new NotFoundHttpException('account not found');
        }

        return $this->cardRepository->store(
            $cardDTO
        );
    }

    public function update(
        string $cardID,
        CardUpdateDTO $cardDTO,
    ): void
    {
        if (empty($this->cardRepository->exists($cardID))) {
            throw new NotFoundHttpException('card not found');
        }

        if ($cardDTO->accountID && empty(resolve(AccountService::class)->exists($cardDTO->accountID))) {
            throw new NotFoundHttpException('account not found');
        }

        $this->cardRepository->update(
            $cardID,
            $cardDTO,
        );
    }

    public function delete(
        string $cardID,
    ): void
    {
        if (empty($this->cardRepository->exists($cardID))) {
            throw new NotFoundHttpException('card not found');
        }

        $this->cardRepository->delete(
            $cardID,
        );
    }

    public function cardNumberExists(
        string $cardNumber,
    ): bool
    {
        return $this->cardRepository->cardNumberExists($cardNumber);
    }

    public function exists(
        string $id,
    ): bool
    {
        return $this->cardRepository->exists($id);
    }
}
