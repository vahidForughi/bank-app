<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'origin_card_id' => $this->originCardID,
            'destination_card_id' => $this->destinationCardID,
            'cash' => $this->cash,
            'type' => $this->type,
            'status' => $this->status,
            'origin_card' => $this->originCard,
            'destination_card' => $this->destinationCard,
        ];
    }
}
