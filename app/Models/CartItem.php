<?php

namespace App\Models;

use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CartItem extends Model implements CartItemEntity
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'name',
        'sku',
        'price',
        'quantity',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    // ---------------------------------------------------------------------
    // ProductEntity methods

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getPrice(): MoneyValueObject
    {
        return MoneyValueObject::fromInt($this->attributes['price']);
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->save();
    }

    public function removeItem(): void
    {
        $this->delete();
    }
}
