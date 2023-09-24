<?php

namespace App\Repositories;

use App\Models\CartItem;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Domain\Interfaces\CartItemRepository;

class CartItemDatabaseRepository implements CartItemRepository
{
    public function upsert(CartItemEntity $cartItem, CartEntity $cart): CartItemEntity
    {
        return CartItem::updateOrCreate([
            'id' => $cartItem->id,
        ], [
            'cart_id' => $cart->id,
            'sku' => $cartItem->getSku(),
            'name' => $cartItem->getName(),
            'price' => $cartItem->getPrice()->toInt(),
            'quantity' => $cartItem->getQuantity(),
        ]);
    }
}
