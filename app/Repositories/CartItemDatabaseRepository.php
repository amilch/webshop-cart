<?php

namespace App\Repositories;

use App\Models\CartItem;
use Domain\Interfaces\CartEntity;
use Domain\Interfaces\CartItemEntity;
use Domain\Interfaces\CartItemRepository;

class CartItemDatabaseRepository implements CartItemRepository
{
    public function all(?string $sku = null, ?int $cart_id = null): array
    {
        $builder = CartItem::query();

        if ($sku !== null)
        {
            $builder = $builder->where('sku', $sku);
        }

        if ($cart_id !== null)
        {
            $builder = $builder->where('cart_id', $cart_id);
        }

        return $builder->get->all();
    }
    public function upsert(CartItemEntity $cartItem, CartEntity $cart): CartItemEntity
    {
        return CartItem::updateOrCreate([
            'cart_id' => $cart->id,
            'sku' => $cartItem->getSku(),
        ], [
            'cart_id' => $cart->id,
            'sku' => $cartItem->getSku(),
            'name' => $cartItem->getName(),
            'price' => $cartItem->getPrice()->toInt(),
            'quantity' => $cartItem->getQuantity(),
        ]);
    }
}
