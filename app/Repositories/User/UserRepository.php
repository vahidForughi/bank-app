<?php

namespace App\Repositories\User;

use App\DTO\User\UserDTO;
use App\DTO\User\UserUpdateDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function fetchList(array $with = []): array
    {
        return User::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): UserDTO
    {
        return User::with($with)->find($id)->toDTO();
    }

    public function store(UserDTO $userDTO): UserDTO
    {
        return User::create([
            'first_name' => $userDTO->first_name,
            'last_name' => $userDTO->last_name,
            'phone_number' => $userDTO->phone_number,
        ])->toDTO();
    }

    public function update(string $id, UserUpdateDTO $userDTO): void
    {
        $user = new User;

        if ($userDTO->userID)
            $user->user_id = $userDTO->userID;

        if ($userDTO->number)
            $user->number = $userDTO->number;

        if ($userDTO->cash)
            $user->cash = $userDTO->cash;

        User::where('id', $id)->update($user->toArray());
    }

    public function delete(string $id): void
    {
        User::find($id)->delete();
    }

    public function exists(string $id): bool
    {
        return User::where('id', $id)->exists();
    }
}
