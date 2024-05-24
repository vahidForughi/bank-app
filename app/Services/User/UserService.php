<?php

namespace App\Services\User;

use App\DTO\User\UserUpdateDTO;
use App\DTO\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {}

    public function fetchList(

    ): array
    {
        return $this->userRepository->fetchList([
            'account',
        ]);
    }

    public function fetch(
        string $id,
    ): UserDTO
    {
        if (empty($userDTO = $this->userRepository->fetchById($id, [
            'account',
        ]))) {
            throw new NotFoundHttpException('user not found');
        }

        return $userDTO;
    }

    public function store(
        UserDTO $userDTO,
    ): UserDTO
    {
        return $this->userRepository->store(
            $userDTO
        );
    }

    public function update(
        string $userID,
        UserUpdateDTO $userDTO,
    ): void
    {
        if (empty($this->userRepository->exists($userID))) {
            throw new NotFoundHttpException('user not found');
        }

        $this->userRepository->update(
            $userID,
            $userDTO,
        );
    }

    public function delete(
        string $userID,
    ): void
    {
        if (empty($this->userRepository->exists($userID))) {
            throw new NotFoundHttpException('user not found');
        }

        $this->userRepository->delete(
            $userID,
        );
    }

    public function exists(
        string $id,
    ): bool
    {
        return $this->userRepository->exists($id);
    }
}
