<?php

namespace App\Repositories\Card;

use App\DTO\Card\CardDTO;
use App\DTO\Card\CardUpdateDTO;

interface CardRepositoryInterface
{
    public function fetchList(array $with = []): array;
    public function fetchById(string $id, array $with = []): CardDTO|null;
    public function fetchByCardNumber(string $number, $with = []): CardDTO|null;
    public function store(CardDTO $cardDTO): CardDTO;
    public function update(string $id, CardUpdateDTO $cardDTO): void;
    public function delete(string $id): void;
    public function exists(string $id): bool;
    public function cardNumberExists(string $number): bool;
}
