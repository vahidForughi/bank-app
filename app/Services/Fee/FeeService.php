<?php

namespace App\Services\Fee;

use App\DTO\Fee\FeeUpdateDTO;
use App\DTO\Fee\FeeDTO;
use App\Repositories\Fee\FeeRepositoryInterface;
use App\Services\Transaction\TransactionService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeeService
{
    public function __construct(
        private FeeRepositoryInterface $feeRepository,
    ) {}

    public function fetchList(

    ): array
    {
        return $this->feeRepository->fetchList();
    }

    public function fetch(
        string $id,
    ): FeeDTO
    {
        if (empty($feeDTO = $this->feeRepository->fetchById($id))) {
            throw new NotFoundHttpException('fee not found');
        }

        return $feeDTO;
    }

    public function store(
        FeeDTO $feeDTO,
    ): FeeDTO
    {
        if (empty(resolve(TransactionService::class)->exists($feeDTO->transactionID))) {
            throw new NotFoundHttpException('transaction not found');
        }

        return $this->feeRepository->store(
            $feeDTO
        );
    }

    public function update(
        string $feeID,
        FeeUpdateDTO $feeDTO,
    ): void
    {
        if (empty($this->feeRepository->exists($feeID))) {
            throw new NotFoundHttpException('fee not found');
        }

        if ($feeDTO->transactionID && empty(resolve(TransactionService::class)->exists($feeDTO->transactionID))) {
            throw new NotFoundHttpException('transaction not found');
        }

        $this->feeRepository->update(
            $feeID,
            $feeDTO,
        );
    }

    public function delete(
        string $feeID,
    ): void
    {
        if (empty($this->feeRepository->exists($feeID))) {
            throw new NotFoundHttpException('fee not found');
        }

        $this->feeRepository->delete(
            $feeID,
        );
    }

    public function exists(
        string $id,
    ): bool
    {
        return $this->feeRepository->exists($id);
    }
}
