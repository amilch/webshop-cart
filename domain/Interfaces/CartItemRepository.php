<?php

namespace Domain\Interfaces;


interface CartItemRepository
{
    public function upsert(CartItemEntity $cartItem, CartEntity $cart): CartItemEntity;
}
