<?php

namespace Domain\Interfaces;


interface CartItemRepository
{
    public function all(?string $sku, ?int $cart_id): array;
    public function upsert(CartItemEntity $cartItem, CartEntity $cart): CartItemEntity;
}
