<?php

namespace Domain\UseCases\UpdateCartItem;

class UpdateCartItemRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}


    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getSku(): string
    {
        return $this->attributes['sku'];
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }
}
