<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\DTO\User\UserDTO;
use App\Traits\HasDTOs;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuids;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasDTOs;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
    ];

    public function toDTO(): UserDTO
    {
        return new UserDTO(
            first_name: $this->first_name,
            last_name: $this->last_name,
            phone_number: $this->phone_number,
            id: $this->id,
        );
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(
            Account::class,
            'user_id',
            'id'
        );
    }

    public function cards(): HasManyThrough
    {
        return $this->hasManyThrough(
            Card::class,
            Account::class,
            'user_id',
            'account_id',
            'id',
            'id',
        );
    }

    public function transactions(): HasManyThrough
    {
        return $this->cards()->hasMany(
            Card::class,
            Account::class,
            'user_id',
            'account_id',
            'id',
            'id',
        );
    }
}
