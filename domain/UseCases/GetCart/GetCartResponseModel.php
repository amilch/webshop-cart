<?php

namespace Domain\UseCases\GetCart;

use Domain\Interfaces\CartEntity;

class GetCartResponseModel
{
    public function __construct(private ?CartEntity $cart, private bool $merged) {}

    public function getCart(): ?CartEntity
    {
        return $this->cart;
    }

    public function wasMerged(): bool
    {
        return $this->merged;
    }
}
