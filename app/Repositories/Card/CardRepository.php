<?php

namespace App\Repositories\Card;

use App\DTO\Card\CardDTO;
use App\DTO\Card\CardUpdateDTO;
use App\Models\Card;

class CardRepository implements CardRepositoryInterface
{

    public function fetchList(array $with = []): array
    {
        return Card::with($with)->get();
    }

    public function fetchById(string $id, array $with = []): CardDTO|null
    {
        return Card::with($with)->find($id)?->toDTO();
    }

    public function fetchByCardNumber(string $number, $with = []): CardDTO|null
    {
        return Card::with($with)->firstWhere('number',$number)?->toDTO();
    }

    public function store(CardDTO $cardDTO): CardDTO
    {
        return Card::create([
            'account_id' => $cardDTO->accountID,
            'number' => $cardDTO->number,
        ])->toDTO();
    }

    public function update(string $id, CardUpdateDTO $cardDTO): void
    {
        $card = new Card;

        if ($cardDTO->accountID)
            $card->account_id = $cardDTO->accountID;

        if ($cardDTO->number)
            $card->number = $cardDTO->number;

        Card::where('id', $id)->update($cardDTO->toArray());
    }

    public function delete(string $id): void
    {
        Card::find($id)->delete();
    }

    public function exists(string $id): bool
    {
        return Card::where('id', $id)->exists();
    }

    public function cardNumberExists(string $number): bool
    {
        return Card::where('number', $number)->exists();
    }
}
