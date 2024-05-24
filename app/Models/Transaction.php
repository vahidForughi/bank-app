<?php

namespace App\Models;

use App\DTO\Transaction\TransactionDTO;
use App\Traits\HasDTOs;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;
    use HasDTOs;

    const TYPE = [
        'to_card' => 1,
        'paya' => 2,
        'satna' => 3,
    ];

    const STATUS = [
        'pending' => 1,
        'success' => 2,
        'un_success' => 3,
    ];

    const FEES = [
        'to_card' => '5000',
    ];

    protected $fillable = [
        'origin_card_id',
        'destination_card_id',
        'type',
        'cash',
        'status',
    ];


    public function toDTO(): TransactionDTO
    {
        return new TransactionDTO(
            originCardID: $this->origin_card_id,
            destinationCardID: $this->destination_card_id,
            type: $this->type,
            cash: $this->cash,
            status: $this->status,
            id: $this->id,
            originCard: $this->relationLoaded('originCard') ? $this->originCard->toDTO() : null,
            destinationCard: $this->relationLoaded('destinationCard') ? $this->destinationCard->toDTO() : null,
        );
    }

    public function originCard(): BelongsTo
    {
        return $this->belongsTo(
            Card::class,
            'origin_card_id',
            'id'
        );
    }

    public function destinationCard(): BelongsTo
    {
        return $this->belongsTo(
            Card::class,
            'destination_card_id',
            'id'
        );
    }

    static public function getFeeAmount($type): string
    {
        return Transaction::FEES[array_search($type, Transaction::TYPE)];
    }
}
