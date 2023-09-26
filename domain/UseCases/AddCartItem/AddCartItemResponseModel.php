<?php

namespace Domain\UseCases\AddCartItem;

use Domain\Interfaces\CartEntity;
use Domain\ValueObjects\MoneyValueObject;

class AddCartItemResponseModel
{
    public function __construct(
        private CartEntity $cart,
        private bool $merged,
        private MoneyValueObject $total
    ) {}

    public function getCart(): CartEntity
    {
        return $this->cart;
    }

    public function wasMerged(): bool
    {
        return $this->merged;
    }

    public function getTotal(): MoneyValueObject
    {
        return $this->total;
    }
}
