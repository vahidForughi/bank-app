<?php

namespace App\Models;

use App\DTO\Card\CardDTO;
use App\Traits\HasDTOs;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;
    use HasDTOs;

    protected $fillable = [
        'account_id',
        'number',
    ];

    public function toDTO(): CardDTO
    {
        return new CardDTO(
            accountID: $this->account_id,
            number: $this->number,
            id: $this->id,
            account: $this->relationLoaded('account') ? $this->account->toDTO() : null,
        );
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(
            Account::class,
            'account_id',
            'id'
        );
    }

    public function withdrawalTransactions(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'origin_card_id',
            'id'
        );
    }

    public function depositTransactions(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'destination_card_id',
            'id'
        );
    }
}
