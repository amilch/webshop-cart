<?php

namespace Domain\UseCases\UpdateCartItem;

use Domain\Interfaces\CartEntity;

class UpdateCartItemResponseModel
{
    public function __construct(private CartEntity $cart, private bool $merged) {}

    public function getCart(): CartEntity
    {
        return $this->cart;
    }

    public function wasMerged(): bool
    {
        return $this->merged;
    }
}
