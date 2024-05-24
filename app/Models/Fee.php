<?php

namespace App\Models;

use App\DTO\Fee\FeeDTO;
use App\Traits\HasDTOs;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;
    use HasDTOs;

    protected $fillable = [
        'transaction_id',
        'cash',
    ];

    public function toDTO(): FeeDTO
    {
        return new FeeDTO(
            transactionID: $this->transaction_id,
            cash: $this->cash,
            id: $this->id,
        );
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(
            Transaction::class,
            'transaction_id',
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
}
