<?php

namespace App\Models;

use Domain\Entities\SessionEntity;
use Domain\Entities\UserEntity;
use Domain\Interfaces\CartEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model implements CartEntity
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // ---------------------------------------------------------------------
    // CartEntity methods

    public function getSession(): ?SessionEntity
    {
        return $this->session_id !== null ? new SessionEntity($this->session_id) : null;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user_id !== null ? new UserEntity($this->user_id) : null;
    }

    public function getItems(): array
    {
        return $this->cartItems->all();
    }
}
