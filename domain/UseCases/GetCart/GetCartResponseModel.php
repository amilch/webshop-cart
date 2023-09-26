<?php

namespace Domain\UseCases\GetCart;

use Domain\Interfaces\CartEntity;
use Domain\ValueObjects\MoneyValueObject;

class GetCartResponseModel
{
    public function __construct(
        private ?CartEntity $cart,
        private bool $merged,
        private ?MoneyValueObject $total
    ) {}

    public function getCart(): ?CartEntity
    {
        return $this->cart;
    }

    public function wasMerged(): bool
    {
        return $this->merged;
    }

    public function getTotal(): ?MoneyValueObject
    {
        return $this->total;
    }
}
