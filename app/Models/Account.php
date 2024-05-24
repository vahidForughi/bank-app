<?php

namespace App\Models;

use App\DTO\Account\AccountDTO;
use App\Traits\HasDTOs;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;
    use HasDTOs;

    protected $fillable = [
        'user_id',
        'number',
        'cash',
    ];

    public function toDTO(): AccountDTO
    {
        return new AccountDTO(
            userID: $this->user_id,
            number: $this->number,
            cash: $this->cash,
            id: $this->id,
            user: $this->relationLoaded('user') ? $this->user->toDTO() : null,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    public function cards(): HasMany
    {
        return $this->hasMany(
            Card::class,
            'account_id',
            'id'
        );
    }
}
