<?php

namespace App\Factories;

use App\Models\CartItem;
use Domain\Interfaces\CartItemEntity;
use Domain\Interfaces\CartItemFactory;

class CartItemModelFactory implements CartItemFactory
{
    public function make(array $attributes = []): CartItemEntity
    {
        $cartItem = new CartItem($attributes);
        return $cartItem;
    }
}
