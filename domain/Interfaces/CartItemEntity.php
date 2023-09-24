<?php

namespace Domain\Interfaces;

use Domain\ValueObjects\MoneyValueObject;

interface CartItemEntity
{
    public function getName(): string;

    public function getSku(): string;

    public function getQuantity(): int;

    public function getPrice(): MoneyValueObject;
}
