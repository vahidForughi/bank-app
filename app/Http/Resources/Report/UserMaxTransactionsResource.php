<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMaxTransactionsResource extends JsonResource
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
            'first_name' => $this->originCardID,
            'last_name' => $this->originCardID,
            'transaction' => [
                'id' => $this->transaction_id,
                'type' => $this->transaction_type,
                'status' => $this->transaction_status,
                'origin_card_id' => $this->transaction_origin_card_id,
                'destination_card_id' => $this->transaction_destination_card_id,
                'totla_transactions' => $this->total_transaction,
            ],
        ];
    }
}
