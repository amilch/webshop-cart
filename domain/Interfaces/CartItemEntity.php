<?php

namespace Domain\Interfaces;

use Domain\ValueObjects\MoneyValueObject;

interface CartItemEntity
{
    public function getName(): string;

    public function getSku(): string;

    public function getQuantity(): int;

    public function getPrice(): MoneyValueObject;

    public function setQuantity(int $quantity): void;

    public function addQuantity(int $quantity): void;

    public function removeItem(): void;
}
